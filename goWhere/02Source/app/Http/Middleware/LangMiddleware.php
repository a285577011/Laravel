<?php
namespace App\Http\Middleware;

use Closure;
use Config;
use App;
use Cookie;
use Agent;
class LangMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request            
     * @param \Closure $next            
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $all = config('app.lang');
        $lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : '';
        if ($lang) { // cookie优先
            $lang = array_search($lang, $all) ? $lang : config('app.locale');
        } else { // 浏览器
            $languages = Agent::languages();
            if (isset($languages[0])) {
                switch (strtolower($languages[0])) {
                    case 'zh':
                    case 'zh-cn':
                    case 'zh-sg':
                        $lang = 'zh_cn';
                        break;
                    case 'zh-tw':
                    case 'zh-hk':
                        $lang = 'zh_tw';
                        break;
                    default:
                        $lang = config('app.locale');
                }
            }
        }
        // echo $lang;
        App::setLocale($lang);
        $_COOKIE['lang'] = $lang;
        // echo App::getLocale();die;
        return $next($request);
    }
}
