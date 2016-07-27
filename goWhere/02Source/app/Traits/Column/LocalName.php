<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalName
{
    public function getNameAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['name_'.$curLang] ? : $this->attributes['name_' . config('app.locale')];
    }
}