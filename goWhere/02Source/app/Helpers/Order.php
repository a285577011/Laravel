<?php

namespace App\Helpers;

use DB;
use App;
use Illuminate\Support\Str;
use App\Models\Currency;

/**
 * Order
 *
 * @author jishu01
 *        
 */
class Order
{
    /**
     * 获得按时间区段的搜索条件
     * @param int $period
     * @param array $condition
     */
    public static function getPeriodCdt($period, $condition = [])
    {
        $condition['date_end'] = date('Y-m-d');
        switch ($period) {
            case '1m':
                $condition['date_start'] = date('Y-m-d', strtotime('today -1 month'));
                break;
            case '3m':
                $condition['date_start'] = date('Y-m-d', strtotime('today -3 months'));
                break;
            case '1y':
                $condition['date_start'] = date('Y-m-d', strtotime('today -1 year'));
                break;
            default:
                break;
        }
        return $condition;
    }

    /**
     * 根据订单状态分类决定搜索条件，先只判断状态
     * @param array $condition
     * @return array
     */
    public static function getStatusCfcCdt($condition)
    {
        if(!isset($condition['status_cfc'])) {
            return $condition;
        }
        switch ($condition['status_cfc']) {
            case 'all':
                $condition['status'] = 0;
                break;
            case 'awaitPay':
                $condition['status'] = 1;
                break;
            case 'notTravel':
                $condition['prd_time'] = ['<', \time()];
                break;
            case 'awaitReview':
                $condition['status'] = 2;
                break;
            case 'refund':
                $condition['status'] = 4;
                break;
            default:
                break;
        }
        return $condition;
    }

    public static function getPayLink($order)
    {
        switch($order->type) {
            case 1: //跟团游
                $url = url('tour/pay').'?orderId='.\Crypt::encrypt($order->id);
                break;
            case 2: //定制游
                $url = '';
                break;
            case 3: //酒店
                $url = '';
                break;
            case 4: //机票
                $url = '';
                break;
            default:
                $url = '';
                break;
        }
        return $url;
    }
}