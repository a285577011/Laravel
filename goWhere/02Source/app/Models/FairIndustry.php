<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class FairIndustry extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;

    protected $appends = ['name'];
    protected $table = 'fair_industry';

    /**
     * 获取行业名称数组
     * @return array [id=>行业名称]
     */
    public static function getFairIndustry(){
        $industries = Cache::remember('fair:industries', 60, function () {
            $industries = self::select('id','name_zh_cn','name_en_us')->get();
            $industries = $industries->pluck('name', 'id')->all();
            return $industries;
        });
        return $industries;
    }

}
