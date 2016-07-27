<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class OrderComposer
{
    public function __construct()
    {
    }
    
    public function compose(View $view)
    {
        $view->with([
            'typeConf' => config('order.orderType'),
            'typeShortConf' => config('order.orderTypeShort'),
            'periodSearchConf' => config('order.periodSearch'),
            'orderStatusConf' => config('order.orderStatus'),
            'orderStatusCfcConf' => config('order.orderStatusCfc'),
        ]);
    }
}
