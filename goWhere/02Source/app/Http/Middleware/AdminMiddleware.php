<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Entrust;

class AdminMiddleware
{
    protected $isAdmin = false; //是否是拥有全部权限的管理员
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 修改用户表
        Config::set('auth.model', Config::get('auth.adminModel'));
        // 修改session和cookie前缀
        Config::set('auth.prefix', Config::get('auth.adminPrefix'));
        // 修改标记
        Config::set('app.isBackend', true);
        // 当前route
        // 视图变量
        $route = \Route::current();
        $routeName = $route->getName();
        if(!in_array($routeName, ['admin::login', 'admin::logout', 'admin::postLogin'])) {
            $menuConf = config('admin-menu');
            if(!\Auth::check()) //必须登录才能访问
            {
                return redirect('/admin/login');
            }
            $this->authCheck($routeName, $menuConf);

            if(!$request->ajax()) {
                $this->prepareViewData($routeName, $menuConf);
            }
        }

        return $next($request);
    }
    
    /**
     * 根据路由检查权限
     * @param array $menuConf
     * @return boolean
     */
    protected function authCheck($curRoute, $menuConf)
    {
        // 系统管理员具有所有权限
        if(Entrust::hasRole('admin')) {
            $this->isAdmin = true;
            return true;
        }
        // 管理首页都能登录
        if($routeName === 'admin::index') {
            return true;
        }
        if (!isset($menuConf[$curRoute]['permission']) || !Entrust::can($menuConf[$curRoute]['permission']))
        {
            abort(403, '无权访问');
        }
        return true;
    }

    /**
     * 准备视图数据
     * @param array $menuConf
     */
    protected function prepareViewData($curRoute, $menuConf)
    {
        list($menu, $breadcrumbs) = $this->getMenuAndBreadcrumbs($curRoute, $menuConf);
        view()->share('viewMenuList', $menu);
        view()->share('viewBreadcrumbs', $breadcrumbs);
    }

    /**
     * 获取菜单数据
     * @param array $menuConf
     * @return boolean
     */
    protected function getMenuAndBreadcrumbs($curRoute, $menuConf)
    {
        $markMe = &$menuConf[$curRoute];
        $open = false;
        while(true) {
            $markMe['active'] = true;
            if( $open ) {
                $markMe['open'] = true;
            }
            $breadcrumbs[] = $markMe;
            $parentId = isset($markMe['parent']) ? $markMe['parent'] : null;
            if( !$parentId || !isset($menuConf[$parentId]) ) break;
            $markMe = &$menuConf[$parentId];
            $open = true;
        }
        $breadcrumbsArr['links'] = array_reverse($breadcrumbs);
        $breadcrumbsArr['title'] = array_pop($breadcrumbsArr['links'])['text'];

        foreach ($menuConf as $mk => $menu) {
            if($this->isAdmin || (isset($menu['permission']) && Entrust::can($menu['permission']))) {
                $menuConf[$mk]['show'] = true;
            } else {
                $menuConf[$mk]['show'] = false;
            }
            if (isset($menu['parent']) && $menu['parent']) {
                isset($menu['hide']) && $menu['hide'] ? '' : $menuConf[$menu['parent']]['submenu'][] = &$menuConf[$mk];
                $menuConf[$mk]['show'] && (!isset($menu['hide']) || !$menu['hide']) ? $menuConf[$menu['parent']]['show'] = true : '';
            }
        }
        return [$menuConf, $breadcrumbsArr];
    }
}
