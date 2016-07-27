<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalDesc
{

    public function getDescAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['desc_' . $curLang] ?: $this->attributes['desc_' . config('app.locale')];
    }
}