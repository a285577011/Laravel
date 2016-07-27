<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class FaqCategory extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;
    
    protected $appends = ['name'];

    protected $table = 'faq_category';
    public $timestamps = false;

    /**
     * 定义与faqs表的对应关系
     */
    public function faq()
    {
        return $this->hasOne('\App\Models\Faq', 'category_id');
    }
    
    /**
     * 添加faq分类
     * @param array $data
     * @param object|false $logo
     * @return mixed
     */
    public static function add($data)
    {
        $new = new static;
        $new->name_zh_cn = $data['name_zh_cn'];
        $new->name_zh_tw = $data['name_zh_tw'];
        $new->name_en_us = $data['name_en_us'];
        $new->parent_id = $data['parent_id'];
        $new->sort = $data['sort'];
        return $new->save() ? $new : false;
    }

    /**
     * 修改faq分类
     * @param object $model
     * @param array $data
     * @return mixed
     */
    public static function edit($model, $data)
    {
        $model->name_zh_cn = $data['name_zh_cn'];
        $model->name_zh_tw = $data['name_zh_tw'];
        $model->name_en_us = $data['name_en_us'];
        $model->parent_id = $data['parent_id'];
        $model->sort = $data['sort'];
        if ($model->save()) {
            return $model;
        }
        return false;
    }

    /**
     * 获取列表
     */
    public function getList($skip, $take)
    {
        $query = $this->newQuery();
        $count = $query->count();
        $list = $query->orderBy('sort', 'desc')->skip($skip)->take($take)->get();
        return [$list, $count];
    }

    /**
     * 获取所有分类
     * @return type
     */
    public static function getAll()
    {
//        return Cache::rememberForever('faq:category:all', 60, function(){
            $categories = self::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            $tree = \App\Helpers\Common::listToTree($categories);
            return $tree;
//        });
    }

    /*
     * 获取顶级分类
     */
    public static function getTopCateList()
    {
        return self::where('parent_id', 0)->get()->keyBy('id')->toArray();
    }
    
    public function save(array $options = [])
    {   //both inserts and updates
        $result = parent::save($options);
        Cache::forget('faq:category:all');
        return $result;
    }

    public function delete(array $options = [])
    {   //soft or hard
        $result = parent::delete($options);
        Cache::forget('faq:category:all');
        return $result;
    }

    public function restore()
    {   //soft delete undo's
        $result = parent::restore();
        Cache::forget('faq:category:all');
        return $result;
    }

}
