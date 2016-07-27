<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomNeed extends Model
{
    protected $table = 'custom_needs';
    
    public $timestamps = false;

    /**
     * 保存定制需求
     * @param object $request
     * @return int
     */
    public static function saveRequests($request)
    {
        $need = new \App\Models\CustomNeed();
        $need->name = $request->input('name');
        $need->phone = $request->input('phone');
        $need->planner_id = $request->input('planner', 0);
        $need->gender = $request->input('gender');
        $need->contact_time = $request->input('contact_time');
        $need->email = $request->input('email');
        $need->destination = $request->input('destination');
        $need->departure_date = $request->input('departure');
        $need->from_city = $request->input('from');
        $need->budget = \intval($request->input('budget'));
        $need->subject = \intval($request->input('subject'));
        $need->airline = \intval($request->input('airline'));
        $need->hotel = \intval($request->input('hotel'));
        $need->dinner = $request->input('dinner');
        $need->people = $request->input('people');
        $need->duration = $request->input('duration');
        $need->attendant = \intval($request->input('attendant'));
        $need->visa = \intval($request->input('visa'));
        $need->extra = $request->input('extra');
        $need->save();
        return $need->id;
    }

    /**
     * 获取定制需求列表
     * @param int $page
     * @param int $pageNum
     * @param int $planner
     * @return array
     */
    public static function getList($page, $pageNum, $planner=null)
    {
        $query = self::skip(($page - 1) * $pageNum)->take($pageNum)->orderBy('id', 'desc');
        if($planner) {
            $query->where('planner_id', $planner);
        }
        return $query->get();
    }

    /**
     * 判断当前用户是否是指定的规划师或有相应权限
     * param int $plannerId 需求指定的规划师id
     */
    public static function authCheck($plannerId, $throwExp=false)
    {
        $user = Auth::user();
        if ($user->ability('admin', 'custom:handle-need-all')) {
            return true;
        }
        $userPlannerId = $user->getPlannerId();
        if ($userPlannerId && $userPlannerId == $plannerId)
        {
            return true;
        }
        if($throwExp) {
            abort(403, trans('admin.permission_denied'));
        }
        return false;
    }

    /**
     * 更新规划师ID
     * @param integer|array $oldPlannerId
     * @param integer $newPlannerId
     * @return
     */
    public static function changePlanner($oldPlannerId, $newPlannerId)
    {
        return \DB::table('custom_needs')->where('planner_id', $oldPlannerId)
            ->update(['planner_id' => $newPlannerId]);
    }
}
