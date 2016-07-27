<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Faq extends Model
{
    protected $table = 'faqs';
    public $timestamps = false;

    /**
     * 定义与faq_category表的对应关系
     */
    public function faqCategory()
    {
        return $this->belongsTo('\App\Models\FaqCategory', 'category_id');
    }

    /**
     * 修改分类id
     * @param array $old 旧分类id
     * @param int $new 新分类id
     */
    public static function changeCategory($old, $new)
    {
        return \DB::table('faqs')->whereIn('category_id', $old)->update([
            'category_id' => $new,
        ]);
    }
    
    /**
     * 添加faq
     * @param array $data
     * @param object|false $logo
     * @return mixed
     */
    public static function addFaq($data)
    {
        $new = new static;
        $new->title = $data['title'];
        $new->content = $data['content'];
        $new->category_id = $data['category_id'];
        $new->author = isset($data['author']) && $data['author']!='' ? $data['author'] : \Auth::user()->name;
        $new->sort = $data['sort'];
        $new->lang = $data['lang'];
        $new->ctime = isset($data['ctime']) && $data['ctime'] ? \strtotime($data['ctime']) : \time();
        return $new->save() ? $new : false;
    }

    /**
     * 修改faq
     * @param object $model
     * @param array $data
     * @return mixed
     */
    public static function editFaq($model, $data)
    {
        $model->title = $data['title'];
        $model->content = $data['content'];
        $model->category_id = $data['category_id'];
        isset($data['author']) && $data['author']!=''
            ? $model->author = $data['author']
            : '';
        isset($data['ctime']) && $data['ctime']!=''
            ? $model->ctime = \strtotime($data['ctime'])
            : '';
        $model->sort = $data['sort'];
        $model->lang = $data['lang'];
        if ($model->save()) {
            return $model;
        }
        return false;
    }

    /**
     * 获取列表
     */
    public function getList($skip, $take, $searchCdt)
    {
        $query = $this->newQuery();
        if(isset($searchCdt['category']) && $searchCdt['category']) {
            $query->where('category_id', $searchCdt['category']);
        }
        if(isset($searchCdt['lang']) && $searchCdt['lang']) {
            $query->where('lang', $searchCdt['lang']);
        }
        if(isset($searchCdt['title']) && $searchCdt['title']) {
            $query->where('title', 'like', '%'.$searchCdt['title'].'%');
        }
        $count = $query->count();
        $list = $query->orderBy('sort', 'desc')->skip($skip)->take($take)->get();
        return [$list, $count];
    }

}
