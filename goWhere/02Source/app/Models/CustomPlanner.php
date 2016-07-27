<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Event;
use App\Events\UploadsChanged;

class CustomPlanner extends Model
{
    protected $table = 'custom_planners';
    public $timestamps = false;

    /**
     * 启用的作用域
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }

    /**
     * 获取随机数量的规划师信息
     * @param type $num
     */
    public static function getRandom($num)
    {
        $randomIds = $planners = [];
        $ids = self::enable()->select('id')->get()->pluck('id')->all();
        if($ids) {
            \shuffle($ids);
            $randomIds = \array_slice($ids, 0, $num);
            $planners = self::whereIn('id', $randomIds)->get();
        }
        return $planners;
    }

    public static function getPlanners($all=false)
    {
        $query = self::select('id', 'name', 'enable');
        if(!$all){
            $query = $query->enable();
        }
        $planners = $query->get()->keyBy('id')->all();
        return $planners;
    }

    /**
     * 添加规划师
     * @param array $data
     * @param array|false $avatar
     * @return mixed
     */
    public static function addPlanner($data, $avatar)
    {
        $new = new CustomPlanner();
        $new->name = $data['name'];
        $new->user_id = $data['user_id'];
        $new->desc = $data['desc'];
        $new->enable = $data['enable'];
        if($avatar && $avatar['path']){
            $new->avatar = $avatar['path'];
        } else {
            $new->avatar = $data['avatar_text'];
        }
        return $new->save() ? $new : false;
    }

    /**
     * 修改规划师
     * @param object $planner
     * @param mixed $avatar
     * @return mixed
     */
    public static function editPlanner($planner, $data, $avatar)
    {
        $planner->name = $data['name'];
        $planner->user_id = $data['user_id'];
        $planner->desc = $data['desc'];
        $planner->enable = $data['enable'];
        $oldAvatar = $planner->avatar;
        if ($avatar && $avatar['path']) {
            $planner->avatar = $avatar['path'];
        } else {
            $planner->avatar = $data['avatar_text'];
        }
        if($planner->save()) {
            Event::fire(new UploadsChanged($oldAvatar, $planner->avatar));
            return $planner;
        }
        return false;
    }
}
