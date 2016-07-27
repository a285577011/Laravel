<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalTitle
{

    public function getTitleAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['title_' . $curLang] ?: $this->attributes['customer_' . config('app.locale')];
    }
}