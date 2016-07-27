<?php
/**
 * 多语言字段的处理
 */

namespace App\Traits\Column;

use App\Helpers\Common as CommonHelper;

trait LocalMoney
{
    public function getLocalMoneyAttribute()
    {
        $currency = CommonHelper::getCurrency();
        return [
            'symbol' => CommonHelper::getCurrencySymbol(),
            'money' => CommonHelper::getPriceByValue($this->attributes['money']),
        ];
    }
}