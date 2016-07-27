<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Orders extends Model
{

    protected $table = 'orders';

    public $timestamps = false;

    /**
     * 引入 Trait 处理多币种
     */
    use \App\Traits\Column\LocalMoney;
    protected $appends = ['localMoney'];

    public static function addOrder($orderData)
    {
        $order = new self();
        $order->order_sn = $orderData['order_sn'];
        $order->prd_id = $orderData['prd_id'];
        $order->members_id = $orderData['members_id'];
        $order->money = $orderData['money'];
        $order->currency = $orderData['currency'];
        $order->type = $orderData['type'];
        $order->from = $orderData['from'];
        $order->payment = $orderData['payment'];
        $order->status = $orderData['status'];
        $order->ctime = $orderData['ctime'];
        $order->mtime = $orderData['mtime'];
        $order->remark = $orderData['remark'];
        $order->paytime = $orderData['paytime'];
        $order->prd_time=$orderData['departure_date'];
        if ($order->save()) {
            return $order->id;
        }
        return false;
    }

    public static function paySuccessUp($id, $status, $payType)
    {
        return self::where([
            'id' => $id
        ])->update([
            'status' => $status,
            'payment' => $payType,
            'mtime' => time(),
            'paytime' => time()
        ]);
    }

    public function getOrder($orderId, $type, $status)
    {
        return self::where([
            'id' => $orderId,
            'type' => $type,
            'status' => $status
        ])->take(1)->get();
    }

    /**
     * 获取订单列表
     *
     * @param int $userId            
     * @param int $page            
     * @param int $pageNum            
     * @param array $condition            
     * @return object
     */
    public static function getUserOrder($userId, $page, $pageNum, $condition=[])
    {
        $query = self::where('members_id', $userId);
        if (isset($condition['type']) && $condition['type']) {
            $query->where('type', $condition['type']);
        }
        if (isset($condition['status']) && $condition['status']) {
            $query->where('status', $condition['status']);
        }
        if (isset($condition['date_start']) && $condition['date_start']) {
            $query->where('ctime', '>=', strtotime($condition['date_start']));
        }
        if (isset($condition['date_end']) && $condition['date_end']) {
            $query->where('ctime', '<', strtotime($condition['date_end'] . ' + 1 day'));
        }
        if (isset($condition['prd_time']) && $condition['prd_time']) {
            is_array($condition['prd_time'])
                ? $query->where('prd_time', $condition['prd_time'][0], $condition['prd_time'][1])
                : $query->where('prd_time', $condition['prd_time']);
        }
        $count = $query->count();
        return [
            $count,
            $query->orderBy('ctime','desc')
                ->skip(($page - 1) * $pageNum)
                ->take($pageNum)
                ->get()
        ];
    }

    /**
     * 获取订单信息
     *
     * @param Illuminate\Database\Eloquent\Collection|array $list            
     */
    public static function getOrderItems($list)
    {
        $images = $items = [];
        if (is_object($list)) {
            $list = $list->groupBy('type')->all();
        }
        if ($list) {
            foreach ($list as $type => $prd) {
                $prdIds = $prd->pluck('prd_id')->all();
                switch ($type) {
                    case 1:
                        $items[$type] = \App\Models\Tour::whereIn('id', $prdIds)->get()->keyBy('id');
                        $images[$type] = \App\Models\TourToPic::whereIn('tour_id', $prdIds)->groupBy('tour_id')->lists('image', 'tour_id');
                        break;
                    case 2:
                        $items[$type] = \App\Models\CustomOrder::whereIn('id', $prdIds)->get()->keyBy('id');
                        break;
                    case 3:
                        $items[$type] = \App\Models\HotelOrder::whereIn('id', $prdIds)->get()->keyBy('id');
                        break;
                    case 4:
                        $items[$type] = \App\Models\FlightOrder::whereIn('id', $prdIds)->get()->keyBy('id');
                        break;
                    default:
                        break;
                }
            }
        }
        return [$items, $images];
    }

    /**
     * 取消订单
     * @param string $ordersn
     * @return boolean
     * @throws \Exception
     */
    public static function cancelOrder($ordersn, $memberId)
    {
        try{
            DB::beginTransaction();
            $order = self::where('order_sn', $ordersn)->where('members_id', $memberId)->lockForUpdate()->firstOrFail();
            if($order->status != 1) {
                throw new \Exception();
            }
            $order->status = 3;
            $order->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 根据订单号获取订单信息
     * @param string $ordersn
     * @param integer $memberId
     */
    public static function getUserOrderBySn($ordersn, $memberId)
    {
        $orderMain = self::where('order_sn', $ordersn)->where('members_id', $memberId)->first();
        $extraInfo = $prdInfo = null;
        if($orderMain) {
            switch ($orderMain->type) {
                case 1: // 跟团游
                    $prdInfo = Tour::getPrdInfo($orderMain->prd_id);
                    $extraInfo = TourOrder::getOrderInfo($orderMain->id, $prdInfo);
                    break;
                case 2: // 定制游
                    break;
                case 3: // 酒店
                    break;
                case 4: // 机票
                    break;
                default:
                    break;
            }
            $orderMain->extraInfo = $extraInfo;
            $orderMain->prdInfo = $prdInfo;
        }
        return $orderMain;
    }
}
