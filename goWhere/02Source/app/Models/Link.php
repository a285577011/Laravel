<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Event;
use App\Events\UploadsChanged;

class Link extends Model
{
    protected $table = 'links';
    public $timestamps = false;
    
    /**
     * 添加友链
     * @param array $data
     * @param object|false $logo
     * @return mixed
     */
    public static function addLink($data, $logo)
    {
        $new = new Link();
        $new->title = $data['title'];
        $new->url = $data['url'];
        $new->logo = $logo && $logo['path'] ? $logo['path'] : $data['logo_text'];
        $new->valid = $data['valid'];
        return $new->save() ? $new : false;
    }

    /**
     * 修改友链
     * @param object $link
     * @param array $data
     * @param object|false $logo
     * @return mixed
     */
    public static function editLink($link, $data, $logo)
    {
        $link->title = $data['title'];
        $link->url = $data['url'];
        $link->valid = $data['valid'];
        $oldLogo = $link->logo;
        if ($logo && $logo['path']) {
            $link->logo = $logo['path'];
        } elseif ($data['logo_text']) {
            $link->logo = $data['logo_text'];
        }
        if ($link->save()) {
            Event::fire(new UploadsChanged($oldLogo, $link->logo));
            return $link;
        }
        return false;
    }

}
