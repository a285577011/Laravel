<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Es\TourEs;
use App\Helpers\Common;
use DB;
use App;
use App\Helpers\TransChinese;

class Tour extends Model
{
    
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;

    protected $appends = [
        'name'
    ];

    protected $table = 'tour';

    public $timestamps = false;

    const SEARCH_TYPE = 1;
    // 1DB,2ES
    
    /**
     * $param
     */
    public static function getList($param)
    {
        if (self::SEARCH_TYPE == 1) {
            // $allAreaIds = [];
            // if ($param['areaId']) {
            // $allAreaIds = array_filter(array_map('intval', explode(',', $param['areaId'])));
            // }
            $query = self::join('tour_price_date', function ($join) {
                $join->on('tour.id', '=', 'tour_price_date.tour_id');
            })->where([
                'tour_status' => 1
            ])
                ->
            // ->whereRaw("tour_price_date.price_date>=tour.advance_day*86400+".strtotime(date('Y-m-d', time())))
            select('tour.id', 'tour.name_' . App::getLocale(), 'tour.price', 'tour.leave_area', 'tour.schedule_days', 'tour.booking_count', 'tour.ctime', 'tour.advance_day', 'tour.days', 'tour.nights')
                ->distinct('tour.id');
            if ($param['areaId']) {
                $areaId = $param['areaId'];
                $query->Where(function ($q) use ($areaId) {
                    $q->orwhereRaw("FIND_IN_SET({$areaId},tour.belong_destination)");
                });
            }
            if ($param['leaveArea']) {
                $leaveAreaId = $param['leaveArea'];
                $query->Where(function ($q) use ($leaveAreaId) {
                    $q->orwhereRaw("FIND_IN_SET({$leaveAreaId},tour.leave_area)");
                });
            }
            $param['goDate'] && $query->where('tour_price_date.price_date', $param['goDate']);
            $stock = $param['adultNum'] + $param['childNum'];
            $stock && $query->where('tour_price_date.stock', '>=', $stock);
            $priceRange = self::setRang($param['startPrice'], $param['endPrice'], true);
            if ($priceRange) {
                if (is_array($priceRange)) {
                    $query->whereBetween('price', $priceRange);
                } else {
                    $query->where('price', '>=', $priceRange);
                }
            }
            $all = $city = $scheduleDays = [];
            $count = $query->count('tour.id');
            $query->chunk(1000, function ($lists) use (&$all) {
                $all = array_merge($lists->toArray(), $all);
            });
            if ($all) {
                foreach ($all as $v) {
                    foreach (@explode(',', $v['leave_area']) as $id) {
                        $city[] = $id;
                    }
                    $scheduleDays[] = $v['schedule_days'] > 15 ? 15 : $v['schedule_days'];
                }
            }
            $scheduleDays = array_unique($scheduleDays);
            \sort($scheduleDays);
            $city = array_unique($city);
            $param['scheduleDay'] == 15 ? $query->where('schedule_days', '>=', $param['scheduleDay']) : $param['scheduleDay'] && $query->where('schedule_days', '=', $param['scheduleDay']);
            // $param['leaveArea'] && $query->where('leave_area', $param['leaveArea']);
            list ($order, $by) = self::formatSort($param['sort']);
            $query->orderBy($order, $by);
            $limitStart = ($param['page'] - 1) * config('tour.page'); // 1;
            $data = $query->take(config('tour.page'))
                ->offset($limitStart)
                ->get();
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator('', $count, config('tour.page'), $param['page'], [
                'path' => '/tour/lists'
            ]);
            if ($data->count()) {
                foreach ($data as $k => $v) {
                    $data[$k]->infoData = TourInfo::where([
                        'tour_id' => $v->id
                    ])->first();
                }
            }
            // _rint_r($data);
            // die();
            // print_r($data);
            // die();
            return array(
                $data,
                $city,
                $scheduleDays,
                $paginator
            );
        }
        // $es = new TourEs();
        if ($area = $param['area']) {
            // $areaIdS = [];
            // $areaId = (array) $es->areaSearch();
            if ($data) {
                $areaIdS = self::getSubId($data, 'id', 'parent_id', $area);
                // foreach ($areaId as $id) {
                // }
            }
            // print_r($areaIdS);
            // die();
            $param['areaId'] = $areaIdS;
        }
        list ($order, $by) = self::formatSort($param['sort']);
        // $data = $es->tourSearch();
        // return $data;
        return array();
    }

    /**
     * 设置范围搜索条件
     *
     * @param unknown $start            
     * @param unknown $end            
     * @param string $zero            
     * @return multitype:unknown number |number|multitype:number unknown
     *         |boolean
     */
    public static function setRang($start, $end, $zero = false)
    {
        if ($zero) {
            $start or $start = 0;
        } else {
            $start or $start = 1;
        }
        if ($start && $end) {
            if ($end >= $start) {
                return array(
                    $start,
                    $end
                );
            }
            return $start;
        } elseif ($start) {
            return $start;
        } elseif ($end) {
            return array(
                0,
                $end
            );
        }
        return false;
    }

    public static function formatSort($sort)
    {
        $sortStr = '';
        $param = @explode('-', $sort);
        if (count($param) != 2) {
            return array(
                'ctime',
                'desc'
            );
        }
        list ($order, $by) = $param;
        if (! $order || ! $by || ! in_array($by = strtolower($by), array(
            'asc',
            'desc'
        ))) {
            return array(
                'ctime',
                'desc'
            );
        }
        switch ($order) {
            case 'day':
                $order = "schedule_days";
                break;
            case 'price':
                $order = "price";
                break;
            case 'salenum':
                $order = "booking_count";
                break;
        }
        return array(
            $order,
            $by
        );
    }

    /**
     * 获取子ID
     *
     * @param array $list
     *            要转换的数据集
     * @param string $pid
     *            parent标记字段
     * @return array
     *
     */
    public static function getSubId($list, $pk = 'id', $pid = 'pid', $id = 0)
    {
        // 创建Tree
        $ids = array();
        if (is_array($list)) {
            foreach ($list as $key => $data) {
                $data = (array) $data;
                if ($data[$pid] == $id) {
                    $ids[] = $data[$pk];
                    self::getSubId($list, $pk, $pid, $data[$pk]);
                }
            }
        }
        return $ids;
    }

    public static function getOneById($id)
    {
        return self::find($id);
    }

    public static function addTour($tour, $tourInfo)
    {
        DB::beginTransaction();
        try {
            $tourId = self::add($tour); // 添加跟团游基础信息
            $tourInfo['tour_id'] = $tourId;
            TourInfo::add($tourInfo);
            for ($i = 1; $i <= $tour['schedule_days']; $i ++) {
                TourToTravel::add($tourId, $i, '', '', '', '', ''); // 初始化
            }
            // $priceDate = self::getPriceDate($tour['start_day'], $tour['end_day'], $tour['departure_type'], $tour['departure_day'], $tour['outdate_str']);
            // TourPriceDate::add($tourId, $tour['price'], $tour['child_price'], $tour['stock'], $priceDate); // 速度慢走队列
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return $tourId;
    }

    public static function updateTour($tour, $tourInfo, $tourId)
    {
        DB::beginTransaction();
        try {
            $data = self::find($tourId);
            self::updateById($tourId, $tour);
            $lang = App::getLocale();
            $update = [
                'desc_' . $lang => $tourInfo['desc'],
                'visit_view_' . $lang => $tourInfo['visit_view'],
                'route_feature_' . $lang => $tourInfo['route_feature'],
                'simple_route_' . $lang => $tourInfo['simple_route']
            ];
            if (App::getLocale() == 'zh_cn') {
                $update['desc_zh_tw'] = TransChinese::transToTw($tourInfo['desc']);
                $update['visit_view_zh_tw'] = TransChinese::transToTw($tourInfo['visit_view']);
                $update['route_feature_zh_tw'] = TransChinese::transToTw($tourInfo['route_feature']);
                $update['simple_route_zh_tw'] = TransChinese::transToTw($tourInfo['simple_route']);
            }
            TourInfo::where([
                'tour_id' => $tourId
            ])->update($update);
            $priceDate = [];
            /*
             * if ($tour['departure_type'] != $data->departure_type) { // 指定方式改变
             * $priceDate = self::getPriceDate($tour['start_day'], $tour['end_day'], $tour['departure_type'], $tour['departure_day'], $tour['outdate_str']);
             * } elseif ($tour['departure_type'] == 3) {
             * foreach ($tour['departure_day'] as $v) {
             * $newTourData[] = date('Y-m-d', $v);
             * $str = implode(',', $newTourData);
             * }
             * if ($data->departure_day != $str) {
             * $priceDate = self::getPriceDate($tour['start_day'], $tour['end_day'], $tour['departure_type'], $tour['departure_day'], $tour['outdate_str']);
             * }
             * } elseif ($tour['departure_type'] == 1) {
             * if ($data->start_day != $tour['start_day'] || $data->end_day != $tour['end_day']) {
             * $priceDate = self::getPriceDate($tour['start_day'], $tour['end_day'], $tour['departure_type'], $tour['departure_day'], $tour['outdate_str']);
             * }
             * } elseif ($tour['departure_type'] == 2) {
             * if ($data->start_day != $tour['start_day'] || $data->end_day != $tour['end_day'] || $data->departure_day != $tour['departure_day'])
             * $priceDate = self::getPriceDate($tour['start_day'], $tour['end_day'], $tour['departure_type'], $tour['departure_day'], $tour['outdate_str']);
             * }
             */
            // TourPriceDate::updateById($tourId, $tour['price'], $tour['child_price'], $priceDate); // 速度慢走队列
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    public static function updateById($tourId, $tour)
    {
        /*
         * if ($tour['departure_type'] == 2) { // 指定星期
         * $tour['departure_day'] = implode(',', $tour['outdate_str']);
         * } elseif ($tour['departure_type'] == 3) {
         * foreach ($tour['departure_day'] as $v) {
         * $newTourData[] = date('Y-m-d', $v);
         * }
         * $tour['departure_day'] = @implode(',', $newTourData);
         * }
         */
        $lang = App::getLocale();
        $destinations = self::getBelongAreaByDestination($tour['destination']);
        $update = [
            'name_' . $lang => $tour['name'],
            'schedule_days' => $tour['schedule_days'],
            // 'tour_status' => $tour['tour_status'],不更新
            'price' => Currency::getPriceById($tour['price'], $tour['currency']),
            'child_price' => Currency::getPriceById($tour['child_price'], $tour['currency']),
            'mtime' => time(),
            'leave_area' => $tour['leave_area'],
            'advance_day' => $tour['advance_day'],
            'type' => $tour['type'],
            'theme' => $tour['theme'],
            'lowest_people' => $tour['lowest_people'],
            'destination' => $tour['destination'],
            'area' => $tour['area'],
            // 'nights' => $tour['nights'],
            // 'days' => $tour['days'],
            // 'departure_type' => $tour['departure_type'],
            // 'departure_day' => $tour['departure_day'],
            // 'start_day' => $tour['start_day'],
            // 'end_day' => $tour['end_day'],
            'belong_destination' => $destinations
        ];
        if (App::getLocale() == 'zh_cn') {
            $update['name_zh_tw'] = TransChinese::transToTw($tour['name']);
        }
        self::where([
            'id' => $tourId
        ])->update($update);
    }

    public static function getPriceDate($startDay, $endDay, $departureType, $departureDay, $outdateStr)
    {
        $priceDate = [];
        $startDay = strtotime(date('Y-m-d', $startDay));
        $endDay = strtotime(date('Y-m-d', $endDay));
        switch ($departureType) {
            case 1: // 天天团发
                while ($endDay >= $startDay) {
                    $priceDate[] = $startDay;
                    $startDay += 86400;
                }
                break;
            case 2: // 指定星期
                if ($outdateStr) {
                    while ($endDay >= $startDay) {
                        if (in_array(date('w', $startDay), $outdateStr)) {
                            $priceDate[] = $startDay;
                        }
                        $startDay += 86400;
                    }
                }
                break;
            case 3: // 自定义日期
                $priceDate = $departureDay;
                break;
        }
        return $priceDate;
    }

    public static function add($tourData)
    {
        /*
         * if ($tourData['departure_type'] == 2) { // 指定星期
         * $tourData['departure_day'] = implode(',', $tourData['outdate_str']);
         * } elseif ($tourData['departure_type'] == 3) {
         * foreach ($tourData['departure_day'] as $v) {
         * $newTourData[] = date('Y-m-d', $v);
         * }
         * $tourData['departure_day'] = @implode(',', $newTourData);
         * }
         */
        $destinations = self::getBelongAreaByDestination($tourData['destination']);
        $tour = new self();
        $nameKey = 'name_' . App::getLocale();
        $tour->$nameKey = $tourData['name'];
        if (App::getLocale() == 'zh_cn') {
            $tour->name_zh_tw = TransChinese::transToTw($tourData['name']);
        }
        $tour->schedule_days = $tourData['schedule_days'];
        $tour->tour_status = - 1; // 默认审核不通过$tourData['tour_status'];
        $tour->price = Currency::getPriceById($tourData['price'], $tourData['currency']);
        $tour->child_price = Currency::getPriceById($tourData['child_price'], $tourData['currency']);
        $tour->booking_count = 0;
        $tour->ctime = time();
        $tour->mtime = time();
        $tour->leave_area = $tourData['leave_area'];
        $tour->advance_day = $tourData['advance_day'];
        $tour->type = $tourData['type'];
        $tour->theme = $tourData['theme'];
        $tour->lowest_people = $tourData['lowest_people'];
        $tour->nights = $tourData['nights'];
        $tour->days = $tourData['days'];
        $tour->area = $tourData['area'];
        // $tour->departure_type = $tourData['departure_type'];
        // $tour->departure_day = $tourData['departure_day'];
        // $tour->start_day = $tourData['start_day'];
        // $tour->end_day = $tourData['end_day'];
        $tour->destination = $tourData['destination'];
        $tour->belong_destination = $destinations;
        // $tour->stock = $tourData['stock'];
        if ($tour->save()) {
            return $tour->id;
        }
        return false;
    }

    private static function getBelongAreaByDestination($destinations)
    {
        $destinationsStr = '';
        if ($destinations) {
            $destinations = array_map('trim', explode(',', $destinations));
            if ($destinations) {
                foreach ($destinations as $areaId) {
                    $destinations = array_merge($destinations, Area::getAllParentId($areaId));
                }
                $destinationsStr = implode(',', array_unique($destinations));
            }
        }
        return $destinationsStr;
    }

    public static function countByDestination($areaId)
    {
        return self::orwhereRaw("FIND_IN_SET({$areaId},belong_destination)")->count('id');
    }

    /**
     * 获取产品信息
     *
     * @param integer $id            
     * @return type
     */
    public static function getPrdInfo($id)
    {
        $info = self::where('id', $id)->first();
        return $info;
    }
}
