<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalEventOverview
{

    public function getEventOverviewAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['event_overview_' . $curLang] ?: $this->attributes['event_overview_' . config('app.locale')];
    }
}