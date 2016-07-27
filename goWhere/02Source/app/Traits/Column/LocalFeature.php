<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalFeature
{
    public function getFeatureAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['feature_'.$curLang] ? : $this->attributes['feature_' . config('app.locale')];
    }
}