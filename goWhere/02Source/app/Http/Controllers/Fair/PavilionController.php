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

class PavilionController extends Controller
{
    /**
     * 更多展馆
     * @param Request $request
     */
    public function more(Requests\Fair\SearchPavilionRequest $request, $hotArea)
    {
        echo 'in';
        \App\Helpers\Common::sqlDump();
        //查询条件
        //$condition = \App\Helpers\Fair::getFairSearchCdt($request);
        $pavilionIds = [1];
        //热门地区
        $hotAreas = [];
        //展馆列表
        $pavilionList= Pavilion::getList($pavilionIds);
        foreach ($pavilionList as $pavilion) {
            var_dump($pavilion->pavilionInfo);
        }
        var_dump($pavilionList->toArray());exit;
        //最新举办
        //$fairList = Fair::getLastFairByPavilions($pavilionIds);
        return view('fair.pavilions', [
            'searchType'=>[
                'hotAreas'=>$hotAreas,
            ],
            //展馆列表
            'pavilionList'=>$pavilionList
        ]);
    }

    /**
     * 展会详情
     * @param  int  $fairId
     */
    public function detail(Requests\Common\GetIdRequest $request, $id)
    {
        var_dump($id);
        \App\Helpers\Common::sqlDump();
        $pavilion = \App\Models\Pavilion::with('pavilionInfo')->findOrFail($id);
        // 获取展会计划
        $fairPlan = Fair::getFairPlanByPavilion($id, \date('Y'), \Config('fair.pavilionPlanNum'));
        var_dump($id);
        if(!$request->ajax()) {
            return view('fair.pavilion', [
                'pavilion'=>$pavilion,
            ]);
        }
        return $fairPlan->toJson();
    }

}
