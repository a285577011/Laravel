<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Event;
use App\Events\UploadsChanged;

class Advertisement extends Model
{

    protected $table = 'advertisements';
    public $timestamps = false;

    // 添加一个广告
    public static function addAd($data, $attachment)
    {
        $new = new Advertisement();
        $new->title = $data['title'];
        $new->module = $data['module'];
        $new->type = $data['type'];
        $new->position = $data['position'];
        $new->sort = $data['sort'];
        $new->size = $data['size'];
        $new->href = $data['href'];
        $new->desc = $data['desc'];
        $new->attachment = $attachment && $attachment['path'] ? $attachment['path'] : $data['attachment_text'];
        return $new->save() ? $new : false;
    }

    /**
     * 获取广告列表
     * @param int $skip
     * @param int $take
     * @param int $module
     * @param int $type
     * @param int $title
     * @return object
     */
    public static function getList($skip, $take, $module, $type, $title)
    {
        $query = self::skip($skip)->take($take);
        $module ? $query->where('module', $module) : '';
        $type ? $query->where('type', $type) : '';
        $title ? $query->where('title', 'like', '%'.$title.'%') : '';
        return $query->orderBy('sort', 'desc')->get();
    }

    /**
     * 修改广告
     * @param object $ad
     * @param array $data
     * @param array $attachment
     * @return boolean
     */
    public static function editAd($ad, $data, $attachment)
    {
        $ad->title = $data['title'];
        $ad->module = $data['module'];
        $ad->type = $data['type'];
        $ad->position = $data['position'];
        $ad->sort = $data['sort'];
        $ad->size = $data['size'];
        $ad->href = $data['href'];
        $ad->desc = $data['desc'];
        $oldAttachment = $ad->attachment;
        if($attachment && $attachment['path']) {
            $ad->attachment = $attachment['path'];
        }elseif($data['attachment_text']){
            $ad->attachment = $data['attachment_text'];
        }
        if($ad->save()) {
            Event::fire(new UploadsChanged($oldAttachment, $ad->attachment));
            return $ad;
        }
        return false;
    }

}
