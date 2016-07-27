<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Fair extends Model
{

    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;
    use \App\Traits\Column\LocalDesc;

    protected $appends = ['name'];

    /**
     * 定义与fair_info表的对应关系
     */
    public function fairInfo()
    {
        return $this->hasOne('\App\Models\FairInfo', 'fair_id');
    }

    /**
     * 定义与fair_reservation表的对应关系
     */
    public function fairReservation()
    {
        return $this->hasMany('\App\Models\FairReservation', 'fair_id');
    }

    /**
     * 定义与pavilions表的关联
     */
    public function pavilions()
    {
        return $this->belongsTo('\App\Models\Pavilions', 'pavilion_id');
    }

    /**
     * 定义推荐状态关联
     */
    public function recommends()
    {
        return $this->hasOne('\App\Models\Recommend', 'item_id');
    }

    /**
     * 获取展会推荐状态的作用域
     */
    public function scopeRecStatus($query)
    {
        return $query->with(['recommends' => function($query) {
                        $query->where('item_type', 1);
                    }]);
    }
    /**
     * 只包含启用的作用域
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }
    
    /**
     * 获取日历数据
     * @param int $year 年份
     * @param int $month 月份
     * @param int $industry 行业ID
     * @return array
     */
    public static function getCalendarData($year, $month, $industry)
    {
        $calendarData = Cache::remember('fair:calendarData:'.$year.':'.$month.':'.$industry, 60,
            function () use ($year, $month, $industry) {
                $startTime = \strtotime($year.'-'.$month.'-01');
                $endTime = \strtotime($year.'-'.$month.'-01 +1 month')-1;
                return self::enable()->where('industry_id', $industry)
                    ->where('start_time', '>=', $startTime)
                    ->where('end_time', '<=', $endTime)->get();
        });
        return $calendarData;
    }
    
    /**
     * 获取展会列表
     * @param array $ids
     * @param int $skipNum
     * @param int $takeNum
     * @return array
     */
    public static function getFairList($ids)
    {
        return self::with(['fairInfo'=>function($query){
            return $query->select('fair_id', 'description');
        }])->enable()->whereIn('id',$ids)->get();
    }

    /**
     * 根据展馆id获取展会计划
     * @param int $pavilionId 展馆ID
     * @param int $year 年份
     * @param int $num 数量
     */
    public static function getFairPlanByPavilion($pavilionId, $year, $num)
    {
        return self::enable()->select('name_zh_cn', 'name_en_us', 'start_time', 'end_time')
                ->where('id', $pavilionId)
                ->where('start_time', '>=', \strtotime($year.'-01-01'))
                ->where('start_time', '<=', \strtotime($year.'-12-31'))
                ->take($num)->get();
    }
}
