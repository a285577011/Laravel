<?php
namespace App\Http\Controllers\Mice;

use App\Http\Requests\Mice\MiceNeedRequest;
use App\Http\Requests\Mice\MiceNeedAllRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Common;
use App\Models\MiceNeeds;
use App\Models\Area;
use Illuminate\Http\Request;
use Validator;

class NeedsController extends Controller
{

    public function addNeeds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area' => 'required|numeric',
            'people_num' => 'required|numeric|integer|between:1,8',
            'budget' => 'required|numeric|integer|between:1,13',
            'type' => 'required|numeric|integer|between:1,2',
            'name' => 'required|max:30',
            'phone' => 'required|regex:/^1[34578][0-9]{9}$/'
        ]);
        if ($validator->fails()) {
            return \Response::json(array(
                'status' => 0,
                'info' => $validator->errors()->all()[0]
            ));
        }
        if (! Area::getById($request->input('area'))) {
            return \Response::json(array(
                'status' => 0,
                'info' => trans('common.area_not_found')
            ));
        }
        $miceNeeds = new MiceNeeds();
        $miceNeeds->destinations_id = $request->input('area');
        $miceNeeds->num = intval($request->input('people_num'));
        $miceNeeds->budget = intval($request->input('budget'));
        $miceNeeds->type = intval($request->input('type'));
        $miceNeeds->name = Common::filterStr($request->input('name'));
        $miceNeeds->phone = $request->input('phone');
        $miceNeeds->creat_time = time();
        if ($miceNeeds->save()) {
            return \Response::json(array(
                'status' => 1,
                'info' => trans('common.submit_success')
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => trans('common.submit_fail')
        ));
        // return view('mice.index');
    }

    public function addNeedsAll(Request $request)
    {
        $messsages = array(
            'area.required' => trans('validation.mice.destination'),
            'area.numeric' => trans('validation.mice.destination'),
            'name.required' => trans('validation.mice.name'),
            'people_num.required' => trans('validation.mice.people_num'),
            'budget.required' => trans('validation.mice.budget'),
            'type.required' => trans('validation.mice.type'),
            'phone.required' => trans('validation.mice.phone'),
            'phone.regex' => trans('validation.mice.isMobile'),
            'departure_date.required' => trans('validation.mice.departure_date'),
            'duration.required' => trans('validation.mice.duration'),
            'email.required' => trans('validation.mice.email'),
            'email.email' => trans('validation.mice.isEmail'),
            'qq_wechat.required' => trans('validation.mice.QQorWeixin'),
            'qq_wechat.regex' => trans('validation.mice.isQQorWeixin'),
        );
        $validator = Validator::make($request->all(), [
            'area' => 'required|numeric',
            'people_num' => 'required|numeric|integer|between:1,8',
            'budget' => 'required|numeric|integer|between:1,13',
            'type' => 'required|numeric|integer|between:3,13',
            'name' => 'required|max:30',
            'phone' => 'required|regex:/^1[34578][0-9]{9}$/',
            'departure_date' => 'required|date',
            'duration' => 'required|numeric|integer|min:1',//出行人数
            // 'services' => 'integer',
            'remark' => 'max:255',
            // 'hotel_level'=>'required|numeric|integer|between:0,5',
            // 'hotel_rooms'=>'required|numeric|integer|min:1',
            'email' => 'required|email',
            'qq_wechat' => array(
                'required',
                'regex:/([1-9][0-9]{4,})|(^[a-zA-Zd_]{5,}$)/'
            )
        ], $messsages);
        if ($validator->fails()) {
            return \Response::json(array(
                'status' => 0,
                'info' => $validator->errors()->all()[0]
            ));
        }
        if (! Area::getById($request->input('area'))) {
            return \Response::json(array(
                'status' => 0,
                'info' => trans('common.area_not_found')
            ));
        }
        $miceNeeds = new MiceNeeds();
        $miceNeeds->destinations_id = $request->input('area');
        $miceNeeds->num = intval($request->input('people_num'));
        $miceNeeds->budget = intval($request->input('budget'));
        $miceNeeds->type = intval($request->input('type'));
        $miceNeeds->name = Common::filterStr($request->input('name'));
        $miceNeeds->phone = $request->input('phone');
        $miceNeeds->departure_date = strtotime($request->input('departure_date'));
        $services = trim($request->input('services'));
        // 首页表单无此字段
        // if (! $services) {
        // return \Response::json(array(
        // 'status' => 0,
        // 'info' => trans('mice.services_error')
        // ));
        // }
        $miceNeeds->services = $services;
        $miceNeeds->remark = Common::filterStr($request->input('remark'));
        $miceNeeds->hotel_level = intval($request->input('hotel_level'));
        $miceNeeds->hotel_rooms = intval($request->input('hotel_rooms'));
        $miceNeeds->email = $request->input('email');
        $miceNeeds->qq_wechat = $request->input('qq_wechat');
        $miceNeeds->status = 0;
        $miceNeeds->duration = intval($request->input('duration'));
        $miceNeeds->creat_time = time();
        if ($miceNeeds->save()) {
            return \Response::json(array(
                'status' => 1,
                'info' => trans('common.submit_success')
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => trans('common.fail')
        ));
        // return view('mice.index');
    }
}
