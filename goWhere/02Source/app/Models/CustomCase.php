<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Event;
use App\Events\UploadsChanged;

class CustomCase extends Model
{
    protected $table = 'custom_cases';
    public $timestamps = false;

    /**
     * 启用的作用域
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }

    /**
     * 添加CustomCase
     * @param array $data
     * @param array|false $image
     * @return mixed
     */
    public static function add($data, $image)
    {
        $new = new static;
        $new->title = $data['title'];
        $new->content = $data['content'];
        $new->enable = $data['enable'];
        $new->lang = $data['lang'];
        $new->cost = $data['cost'];
        $new->image = $image && $image['path'] ? $image['path'] : $data['image_text'];
        $new->ctime = isset($data['ctime']) && $data['ctime'] ? \strtotime($data['ctime']) : \time();
        return $new->save() ? $new : false;
    }

    /**
     * 修改faq
     * @param object $model
     * @param array $data
     * @param array|false $image
     * @return mixed
     */
    public static function edit($model, $data, $image)
    {
        $model->title = $data['title'];
        $model->content = $data['content'];
        $model->enable = $data['enable'];
        $model->lang = $data['lang'];
        $model->cost = $data['cost'];
        $oldImage = $model->image;
        if ($image && $image['path']) {
            $model->image = $image['path'];
        } elseif ($data['image_text']) {
            $model->image = $data['image_text'];
        }
        if ($model->save()) {
            //Event::fire(new UploadsChanged($oldImage, $model->image));
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
        if(isset($searchCdt['lang']) && $searchCdt['lang']) {
            $query->where('lang', $searchCdt['lang']);
        }
        if(isset($searchCdt['title']) && $searchCdt['title']) {
            $query->where('title', 'like', '%'.$searchCdt['title'].'%');
        }
        if(isset($searchCdt['enable']) && $searchCdt['enable']!='') {
            $query->where('enable', $searchCdt['enable']);
        }
        $count = $query->count();
        $list = $query->orderBy('id', 'desc')->skip($skip)->take($take)->get();
        return [$list, $count];
    }

    /**
     * 获取随机数量的规划师信息
     * @param type $num
     */
    public static function getRandom($num)
    {
        $randomIds = $cases = [];
        $lang = \App\Helpers\Common::getDbLangType();
        $ids = self::enable()->where('lang', $lang)->lists('id')->all();
        if ($ids) {
            \shuffle($ids);
            $randomIds = \array_slice($ids, 0, $num);
            $cases = self::whereIn('id', $randomIds)->get();
        }
        return $cases;
    }

}
