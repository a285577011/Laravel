<?php

namespace App\Http\Controllers\Fair;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Common as CommonHelper;
use App\Models\Service;
use App\Models\Pavilion;
use App\Models\Recommend;
use App\Models\Fair;
use App\Models\Area;
use App\Models\FairIndustry;

class FairController extends Controller
{
    /**
     * 展会首页
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = \intval($request->input('year', \date('Y')));
        $month = \intval($request->input('month', \date('m')));
        $industry = \intval($request->input('industry', 1));
        // 获取大洲名称和id
        $continents = Area::getContinents();
        return view('fair.index', [
            // 获取展会服务
            'services' => Service::with('subService')->parent()->enable()->type(\Config('fair.serviceType'))->get(),
            // 获取首页推荐展会
            'recFairs'=>Recommend::getRecFairs(),
            // 获取日历数据
            'calendarData'=>Fair::getCalendarData($year, $month, $industry),
            'continents'=>$continents,
            // 按大洲获取知名展馆
            'famousPavilions'=>Pavilion::getFamousPavilionsByContinent(\array_keys($continents))
        ]);
    }

    /**
     * 更多展会
     * @param Request $request
     */
    public function more(Request $request)
    {
        \App\Helpers\Common::sqlDump();
        //查询条件
        //$condition = \App\Helpers\Fair::getFairSearchCdt($request);
        $fairIds = [1];
        //热门地区
        $hotAreas = [];
        //展会列表
        $fairList= Fair::getFairList($fairIds);
        foreach ($fairList as $fair) {
            var_dump($fair->fairInfo);
        }
        var_dump($fairList->toArray());exit;
        //行业类型
        return view('fair.more', [
            'searchType'=>[
                'hotAreas'=>$hotAreas,
                'industry'=>FairIndustry::getFairIndustry(),
                //年份
                'timeSlots'=> \App\Helpers\Fair::getFairTimeSlot(),
            ],
            //展会列表
            'fairList'=>$fairList
        ]);
    }

    /**
     * 展会详情
     * @param  int  $fairId
     */
    public function detail(Requests\Fair\Test $request, $fairId)
    {
        var_dump($fairId);
        \App\Helpers\Common::sqlDump();
        $fair = \App\Models\Fair::with('fairInfo')->findOrFail($fairId);
        var_dump($fair);
        return view('fair.detail', [
            'fair'=>$fair,
            'services'=> Service::type(\Config('fair.serviceType'))->where('parent_id', '>', 0)->get(),
            //同行展会
            'relevantFairs'=> Fair::where('industry_id', $fair->industry_id)
                ->take(\Config('fair.relevantFairsNum'))->get()
        ]);        
    }

    /**
     * 展会服务预订
     */
    public function reserve(Requests\Fair\AddReservationRequest $request, $fairId)
    {
        \App\Helpers\Common::sqlDump();
        $fair = Fair::findOrFail($fairId);
        echo csrf_token();
        if($request->isMethod('POST'))
        {
            if(! \App\Models\FairReservation::saveReservation($fair, $request)){
                throw \Exception(trans('operation_fail'));
            }
            return view('common.success');
        }
        // 服务列表
        $services = Service::type(\Config('fair.serviceType'))->where('parent_id', '>', 0)->get();
        var_dump($services->toArray());
        return view('fair.reserve', [
            
        ]);
    }

}
