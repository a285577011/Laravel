<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalAdvantage
{
    public function getAdvantageAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['advantage_'.$curLang] ? : $this->attributes['advantage_' . config('app.locale')];
    }
}