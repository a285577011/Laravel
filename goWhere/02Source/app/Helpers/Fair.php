<?php

namespace App\Helpers;

use Carbon\Carbon;

class Fair
{
    /**
     * 生产搜索条件的的时间选项
     * @param int $num 数量
     * @return array
     */
    public static function getFairTimeSlot($num=9)
    {
        $timeSlots = [];
        $startDate = new Carbon(\date('Y-m-01'));
        for ($i=0; $i<$num; $i++) {
            $timeSlots[] = clone $startDate->addMonth();
        }
        return $timeSlots;
    }
}
