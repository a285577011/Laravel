<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pavilion extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;
    use \App\Traits\Column\LocalAddress;
    protected $appends = ['name', 'address'];

    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'pavilions';
    
    /**
     * 定义与pavilion_info的关联
     */
    public function pavilionInfo()
    {
        return $this->hasOne('\App\Models\PavilionInfo', 'pavilion_id');
    }

    /**
     * 定义与area表的关联
     */
    public function area()
    {
        return $this->belongsTo('\App\Models\Area', 'area_id');
    }

    /**
     * 定义与fairs表的关联
     */
    public function fairs()
    {
        return $this->hasMany('\App\Models\Fair', 'pavilion_id');
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
     * 只包含知名展馆的作用域
     */
    public function scopeFamous($query)
    {
        return $query->where('is_famous', 1);
    }

    /**
     * 按大洲获取知名展馆
     * @param array $continets 大洲
     * @param int $perNum 每个大洲获取的数量
     * @return array
     */
    public static function getFamousPavilionsByContinent(Array $continets, $perNum=4)
    {
        $results = $pavilions = [];
        foreach ($continets as $c) {
            $data = self::enable()->where('continent', $c)->famous()->take($perNum)->get();
            if($data->count()){
                $results[$c] = $data;
            }
        }
        return $results;
    }

    /**
     * 根据ID获取列表数据
     * @param array $ids
     * @return array
     */
    public static function getList($ids)
    {
        return self::with(['pavilionInfo'=>function($query){
            return $query->select('pavilion_id', 'description');
            // 获取区域信息
        }])->with(['area'=>function($query){
            return $query->select('id', 'name_zh_cn', 'name_en_us');
        }])->with(['fairs'=>function($query){
            return $query->select('id', 'name_zh_cn', 'name_en_us', 'pavilion_id')
                    ->orderBy('start_time', 'desc')->take(1);
        }])->enable()->whereIn('id',$ids)->get();
    }
}
