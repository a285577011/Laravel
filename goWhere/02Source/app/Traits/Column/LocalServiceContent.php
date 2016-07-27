<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalServiceContent
{

    public function getServiceContentAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['service_content_' . $curLang] ?: $this->attributes['service_content_' . config('app.locale')];
    }
}