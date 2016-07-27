<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

trait LocalAddress
{
    public function getAddressAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['address_'.$curLang] ? :$this->attributes['address_' . config('app.locale')];
    }
}