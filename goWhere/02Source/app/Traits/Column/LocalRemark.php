<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalRemark
{

    public function getRemarkAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['remark_' . $curLang] ?: $this->attributes['remark_' . config('app.locale')];
    }
}