<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalVisitView
{

    public function getVisitViewAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['visit_view_' . $curLang] ?: $this->attributes['visit_view_' . config('app.locale')];
    }
}