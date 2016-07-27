<?php

namespace App\Http\Middleware;

use Closure;

class FormatUrlParamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $paramDefiner='')
    {
        if($paramDefiner) {
            // 解析路由中间件的第三个参数，分离出包含特殊参数定义的路由参数名和规则ID
            list($targetName, $definerRuleId) = \explode('_', $paramDefiner, 2);
            $route = $request->route();
            $originParam = $route->parameter($targetName);
            // 将原始路由参数按规则解析为新路由参数
            $parsedParams = \App\Helpers\Common::parseSeoUrlParams($originParam, $definerRuleId);
            // 将新路由参数并回Route
            foreach ($parsedParams as $key => $value) {
                $route->setParameter($key, $value);
            }
            // 从Route中去掉定义特殊参数规则的路由参数
            //$route->forgetParameter($targetName);
        }
        return $next($request);
    }
}
