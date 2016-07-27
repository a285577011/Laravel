<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalAttractions
{
    public function getAttractionsAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['attractions_'.$curLang] ? : $this->attributes['attractions_' . config('app.locale')];
    }
}