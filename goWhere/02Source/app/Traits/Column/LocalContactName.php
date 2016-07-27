<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalContactName
{

    public function getContactNameAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['contact_name_' . $curLang] ?: $this->attributes['contact_name_' . config('app.locale')];
    }
}