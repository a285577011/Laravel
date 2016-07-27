<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalSimpleRoute
{

    public function getSimpleRouteAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['simple_route_' . $curLang] ?: $this->attributes['simple_route_' . config('app.locale')];
    }
}