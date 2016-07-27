<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalAirport
{
    public function getAirportAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['airport_'.$curLang] ? :$this->attributes['airport_' . config('app.locale')];
    }
}