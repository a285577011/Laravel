<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalRouteFeature
{

    public function getRouteFeatureAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['route_feature_' . $curLang] ?: $this->attributes['route_feature_' . config('app.locale')];
    }
}