<?php

namespace App\Http\Controllers\Customization;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CustomPlanner;
use App\Models\CustomNeed;
use App\Models\CustomCase;

class CustomController extends Controller
{
    /**
     * 定制游首页
     */
    public function index()
    {
        // 获取旅行规划师
        $planners = CustomPlanner::getRandom(\Config('customization.plannerNum'));
        $cases = CustomCase::getRandom(\Config('customization.caseNum'));
        return view('customization.index', [
            'planners'=>$planners,
            'cases' => $cases,
        ]);
    }

    /**
     * 定制旅游
     */
    public function submit(Requests\Customization\SubmitRequest $request)
    {
        if($request->isMethod('POST'))
        {
            if(!CustomNeed::saveRequests($request))
            {
                throw \Exception(trans('operation_fail'));
            }
            return view('common.success', [
                'msg' => trans('customization.need_submitted'),
                'url' => url('customization/index'),
            ]);
        }
        // 获取规划师列表
        $planners = CustomPlanner::enable()->select('id', 'name')->get();
        return view('customization.submit', [
            'planners'=>$planners,
            'contactTimeConf' => config('customization.contactTime'),
            'subjectConf' => config('customization.subject'),
            'airLineConf' => config('customization.airline'),
            'hotelConf' => config('customization.hotel'),
            'dinnerConf' => config('customization.dinner'),
            'attendantConf' => config('customization.attendant'),
            'visaConf' => config('customization.visa'),
        ]);
    }
}
