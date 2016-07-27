<?php
/**
 * 多语言字段的处理
 */
namespace App\Traits\Column;

trait LocalCustomer
{

    public function getCustomerAttribute()
    {
        $curLang = \App::getLocale();
        return $this->attributes['customer_' . $curLang] ?: $this->attributes['customer_' . config('app.locale')];
    }
}