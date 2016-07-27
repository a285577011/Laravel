<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;
use Illuminate\Support\Facades\Redis;

class TourPriceDate extends Model
{

    protected $table = 'tour_price_date';

    public $timestamps = false;

    public static function getByTourAndDateSingle($tourId, $date)
    {
        return self::where([
            'tour_id' => $tourId,
            'price_date' => $date
        ])->first();
    }

    public static function getByTourAndDate($tourId, $date, $limit = null)
    
    {
        $newData = [];
        if ($keys = Redis::keys(config('tour.calendar_redis_key') . '*')) {
            $time = [];
            $i = 0;
            foreach ($keys as $key) {
                $day = str_replace(config('tour.calendar_redis_key'), '', $key);
                if (strtotime($day) - $date >= 0) { // 筛选天数
                    if (! $price = Redis::hget($key, config('tour.calendar_redis_field_key_price') . $tourId)) {
                        continue;
                    }
                    if ($limit === $i) {
                        break;
                    }
                    $time[] = $day;
                    $newData[$day]['price'] = $price;
                    $newData[$day]['child_price'] = Redis::hget($key, config('tour.calendar_redis_field_key_child_price') . $tourId);
                    $newData[$day]['total'] = Redis::hget($key, config('tour.calendar_redis_field_key_total') . $tourId);
                    $i ++;
                }
            }
            if ($newData) {
                array_multisort($time, SORT_ASC, $newData);
                return $newData;
            }
        }
        $data = self::where([
            'tour_id' => $tourId
        ])->where('price_date', '>=', $date)
            ->select('price_date', 'adult_price', 'child_price', 'stock')
            ->orderBy('price_date', 'asc')
            ->take($limit)
            ->get();
        if ($data->count()) {
            foreach ($data as $v) {
                $newData[date('Y-m-d', $v->price_date)]['price'] = $v->adult_price;
                $newData[date('Y-m-d', $v->price_date)]['child_price'] = $v->child_price;
                $newData[date('Y-m-d', $v->price_date)]['total'] = $v->stock;
            }
            return $newData;
        } else {
            return array();
        }
    }

    public static function checkNum($tourId, $priceDate, $adultNum, $childNum)
    {
        $totle = $adultNum + $childNum;
        return self::where([
            'tour_id' => $tourId,
            'price_date' => $priceDate
        ])->where('stock', '>=', $totle)
            ->take(1)
            ->count('id');
    }

    public static function add($tourId, $price, $childPrice, $stock, $priceDate)
    {
        if (is_array($priceDate)) {
            // Redis::set('tour_price_date_data_'.$tourId,['adult_price'=>$price,'stock'=>$stock,'child_price'=>$childPrice,'priceDate'=>$priceDate,'tour_id'=>$tourId]);//写入redis
            // Common::sqlDump();
            foreach ($priceDate as $day) {
                if (self::getByTourAndDateSingle($tourId, $day)) {
                    continue;
                }
                $self = new self(); // 重新实例化对象才能插入
                $self->tour_id = $tourId;
                $self->price_date = $day;
                $self->stock = $stock;
                $self->adult_price = $price;
                $self->child_price = $childPrice; // 慢的话先不插入库 先写REDIS
                if ($self->save()) {
                    Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $day), config('tour.calendar_redis_field_key_price') . $tourId, $price);
                    Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $day), config('tour.calendar_redis_field_key_total') . $tourId, $stock);
                    Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $day), config('tour.calendar_redis_field_key_child_price') . $tourId, $childPrice);
                    // Redis::expire(config('tour.calendar_redis_key') . date('Y-m-d', $day), strtotime(date('Y-m-d 23:59:59', $day)) - (time()+$advanceDay*86400)); // 根据提前的时间设置过期时间
                    Redis::expire(config('tour.calendar_redis_key') . date('Y-m-d', $day), strtotime(date('Y-m-d 23:59:59', $day)) - time()); // 设置过期时间超过今天晚上12点就过期
                }
            }
        }
    }

    public static function updateById($tourId, $price, $childPrice, $priceDate = [], $stock = null)
    {
        $stock or $stock = Tour::where([
            'id' => $tourId
        ])->value('stock');
        // Redis::del('tour_price_date_data_'.$tourId);; //删redis
        if (! $priceDate) { // 时间没变
            self::where([
                'tour_id' => $tourId
            ])->update([
                'adult_price' => $price,
                'child_price' => $childPrice,
                'stock' => $stock
            ]);
            $dateArr = self::where([
                'tour_id' => $tourId
            ])->lists('price_date');
            foreach ($dateArr as $date) {
                Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $date), config('tour.calendar_redis_field_key_price') . $tourId, $price);
                Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $date), config('tour.calendar_redis_field_key_total') . $tourId, $stock);
                Redis::hset(config('tour.calendar_redis_key') . date('Y-m-d', $date), config('tour.calendar_redis_field_key_child_price') . $tourId, $childPrice);
            }
        } else {
            self::where('tour_id', $tourId)->delete(); // 删除所有记录
            $keys = Redis::keys(config('tour.calendar_redis_key') . '*');
            if ($keys) {
                foreach ($keys as $key) {
                    Redis::hdel($key, config('tour.calendar_redis_field_key_price') . $tourId); // 清楚redis
                    Redis::hdel($key, config('tour.calendar_redis_field_key_total') . $tourId);
                    Redis::hdel(config('tour.calendar_redis_key') . date('Y-m-d', $data->price_date), config('tour.calendar_redis_field_key_child_price') . $data->tour_id);
                }
            }
            self::add($tourId, $price, $childPrice, $stock, $priceDate);
        }
    }

    public static function del(array $ids)
    {
        if ($ids) {
            foreach ($ids as $id) {
                $data = self::find($id);
                self::destroy($id);
                Redis::hdel(config('tour.calendar_redis_key') . date('Y-m-d', $data->price_date), config('tour.calendar_redis_field_key_total') . $data->tour_id);
                Redis::hdel(config('tour.calendar_redis_key') . date('Y-m-d', $data->price_date), config('tour.calendar_redis_field_key_price') . $data->tour_id);
                Redis::hdel(config('tour.calendar_redis_key') . date('Y-m-d', $data->price_date), config('tour.calendar_redis_field_key_child_price') . $data->tour_id);
            }
            return true;
        }
        return false;
    }

    /**
     *
     * @param unknown $tourId            
     * @return string
     */
    public static function getDateById($tourId, $limit = null)
    {
        $dateArr = self::where([
            'tour_id' => $tourId
        ])->take($limit)
            ->orderBy('price_date', 'asc')
            ->lists('price_date');
        return $dateArr;
    }

    /**
     * 通过tourID 日期获取价格
     *
     * @param unknown $tourId            
     * @return string
     */
    public static function getPriceByIdDate($tourId, $date)
    {
        if ($price = \LaravelRedis::hget(config('tour.calendar_redis_key') . date('Y-m-d', $date), config('tour.calendar_redis_field_key_price') . $tourId)) {
            return [
                'price' => $price,
                'child_price' => \LaravelRedis::hget(config('tour.calendar_redis_key') . date('Y-m-d', $date), config('tour.calendar_redis_field_key_child_price') . $tourId)
            ];
        }
        $priceArr = self::where([
            'tour_id' => $tourId,
            'price_date' => $date
        ])->select('adult_price AS price', 'child_price')->first();
        if ($priceArr) {
            return $priceArr->toArray();
        }
        return [];
    }
}
