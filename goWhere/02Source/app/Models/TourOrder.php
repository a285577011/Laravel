<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;

class TourOrder extends Model
{

    protected $table = 'tour_order';

    public $timestamps = false;

    public static function addOrder($orderData, $tourOrderData)
    {
        \DB::beginTransaction();
        try {
            if (! TourPriceDate::checkNum($orderData['prd_id'], $tourOrderData['departure_date'], $tourOrderData['adult_num'], $tourOrderData['child_num'])) {
                throw new \PDOException(trans('tour.not_enough_number'));
            }
            $tourOrder = new self();
            $orderId = Orders::addOrder($orderData); // 添加订单
            $tourOrderData['orders_id'] = $orderId;
            $tourOrderData['tour_id'] = $orderData['prd_id'];
            $tourOrderId = self::addTourOrder($tourOrderData); // 跟团游订单
           // \DB::table('tour')->where(['id'=>$orderData['prd_id']])->increment('booking_count'); // 更新预订数量
           // \DB::table('tour_price_date')->where(['tour_id'=>$tourOrderData['tour_id'],'price_date'=>$tourOrderData['departure_date']])->where('stock', '>=', $tourOrderData['adult_num']+$tourOrderData['child_num'])//不更新 跟团游没票数
              //->decrement('stock',$tourOrderData['adult_num'] + $tourOrderData['child_num']); // 更新门票数量
                // 更新redis
           // \LaravelRedis::hIncrBy(config('tour.calendar_redis_key') . date('Y-m-d',$tourOrderData['departure_date']), config('tour.calendar_redis_field_key_total') . $orderData['prd_id'], - ($tourOrderData['adult_num'] + $tourOrderData['child_num']));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return array(
            $orderId,
            $tourOrderId
        );
    }

    /**
     * 添加跟团游订单
     */
    public static function addTourOrder($tourOrderData)
    {
        $tourOrder = new self();
        $tourOrder->orders_id = $tourOrderData['orders_id'];
        $tourOrder->departure_date = $tourOrderData['departure_date'];
        $tourOrder->adult_num = $tourOrderData['adult_num'];
        $tourOrder->child_num = $tourOrderData['child_num'];
        $tourOrder->invoice = $tourOrderData['invoice'];
        $tourOrder->invoice_info = $tourOrderData['invoice_info'];
        $tourOrder->currency = $tourOrderData['currency'];
        $tourOrder->total_price = $tourOrderData['total_price'];
        $tourOrder->contact_name = $tourOrderData['contact_name'];
        $tourOrder->contact_gender = $tourOrderData['contact_gender'];
        $tourOrder->contact_phone = $tourOrderData['contact_phone'];
        $tourOrder->contact_email = $tourOrderData['contact_email'];
        $tourOrder->tourist_info = $tourOrderData['tourist_info'];
        //$tourOrder->tour_detail = $tourOrderData['tour_detail'];
        $tourOrder->tour_id = $tourOrderData['tour_id'];
        $tourOrder->insurance_id = $tourOrderData['insurance_id']?:'';
        $tourOrder->insurance_num = $tourOrderData['insurance_num'];
        if ($tourOrder->save()) {
            return $tourOrder->id;
        }
        return false;
    }

    /**
     * 获取订单信息
     * @param integer $mainOrderId 订单主表ID
     */
    public static function getOrderInfo($mainOrderId, $prdInfo=null)
    {
        $extraInfo = self::where('orders_id', $mainOrderId)->first();
        if($extraInfo && isset($prdInfo->schedule_days)) {
            $extraInfo->return_date = $extraInfo->departure_date + $prdInfo->schedule_days * 86400;
        }
        return $extraInfo;
    }
}
