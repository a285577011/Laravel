<?php
namespace App\Http\Controllers\Admin\Mice;

use App\Models\MiceCases;
use Config;
use App\Http\Requests\Mice\MiceCaseRequest;
use App\Http\Requests\Mice\MiceDestinationsRequest;
use App\Models\MiceDest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Recommend;
use App\Models\MiceCasesInfo;
use App\Helpers\Common;
use Illuminate\Http\Request;
use Validator;
use App\Models\MiceNeeds;
use App\Models\MiceDestInfo;

class MiceController extends AdminController
{

    public function needsList(Request $request)
    {
        $status = intval($request->input('status'));
        $id = intval($request->input('id'));
        $where['status'] = $status;
        $id && $where['id'] = $id;
        $data = MiceNeeds::orderBy('creat_time', 'desc')->where($where)->paginate(\Config::get('admin.commonPageNum'));
        return view('admin.mice.needs', [
            'data' => $data
        ]);
    }

    public function updateNeed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|integer',
            'status' => 'required|numeric|between:0,2'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        if (is_int(MiceNeeds::where([
            'id' => $request->input('id')
        ])->update([
            'status' => $request->input('status')
        ]))) {
            \Log::info(json_encode([
                'action'=>'updateNeed',
                'user' => \Auth::user(),
                'status' => $request->input('status')
            ]));
            echo '<script>alert("修改成功");javascript:history.back(-1);</script>';
            exit();
        }
        echo '<script>alert("修改失败");javascript:history.back(-1);</script>';
        exit();
    }

    public function casesList(Request $request)
    {
        // \App::setLocale('en_us');
        // echo \App::getLocale();
        $id = intval($request->input('id'));
        $where = [];
        $id && $where['mice_cases.id'] = $id;
        $data = MiceCasesInfo::join('mice_cases', function ($join) {
            $join->on('mice_cases_info.cases_id', '=', 'mice_cases.id');
        })->where($where)
            ->orderBy('mice_cases.creat_time', 'desc')
            ->paginate(\Config::get('admin.commonPageNum'));
        // $data = self::formatLang($data);
        return view('admin.mice.cases', [
            'data' => $data
        ]);
    }

    public function casesDetail($casesId)
    {
        $baseData = MiceCases::findOrFail($casesId);
        $baseData->start_time = date('Y-m-d', $baseData->start_time);
        $infoData = MiceCasesInfo::where([
            'cases_id' => $casesId
        ])->first();
        // $data = self::formatLang($data);
        return \Response::json(array(
            'status' => 1,
            'data' => [
                'baseData' => $baseData,
                'infoData' => $infoData
            ]
        ));
        // return view('admin.mice.casesDetail', [
        // 'baseData' => $baseData,
        // 'infoData' => $infoData,
        // ]);
    }

    public function addCases(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|numeric|integer',
            'day_num' => 'required|numeric|integer',
            'start_time' => 'required|date',
            'destination' => 'required|numeric|integer',
            'people_num' => 'required|numeric|integer',
            'cost' => 'required|numeric',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }        
        if (MiceCases::add(array_map('htmlspecialchars_decode', $request->all()))) {
            echo '<script>alert("添加成功");javascript:history.back(-1);</script>';
            exit();
            //
        }
    }

    public function updateCases(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|numeric|integer',
            'day' => 'required|numeric|integer',
            'start_time' => 'required|date',
            'destination' => 'required|numeric|integer',
            'people_num' => 'required|numeric|integer',
            'cost' => 'required|numeric',
            'email' => 'required|email'
        ]);
        // if ($validator->fails()) {
        // echo 11;die;
        // $this->error('参数错误!');
        // throw new \Exception('参数错误!');
        // }
        if (MiceCases::updateById(array_map('htmlspecialchars_decode', $request->all()))) {
            echo '<script>alert("修改成功");javascript:history.back(-1);</script>';
            exit();
            //
        }
        $data = MiceCases::findOrFail($casesId);
    }


    public function delCases(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        \DB::beginTransaction();
        try {
            MiceCases::destroy($ids);
            MiceCasesInfo::whereIn('cases_id', $ids)->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return \Response::json(array(
                'status' => 0,
                'info' => $e->getMessage()
            ));
        }
        return \Response::json(array(
            'status' => 1,
            'info' => '删除成功'
        ));
    }

    public function getCasesById(Request $request)
    {
        $data = MiceCases::findOrFail(intval($request->input('id')));
        if ($request->ajax()) {
            return \Response::json(array(
                'status' => 1,
                'data' => $data
            ));
        }
    }

    public function destList(Request $request)
    {
        $id = intval($request->input('id'));
        $where = [];
        $id && $where['id'] = $id;
        $data = MiceDest::orderBy('creat_time', 'desc')->where($where)->paginate(\Config::get('admin.commonPageNum'));
        // if ($data->count()) {
        // foreach ($data as $k => $v) {
        // $data->destInfoData = MiceDestInfo::where([
        // 'destinations_id' => $v->id
        // ])->first();
        // }
        // }
        return view('admin.mice.dest', [
            'data' => $data
        ]);
    }

    public function getDestById($destId)
    {
        $baseData = MiceDest::findOrFail($destId);
        // $baseData->start_time = date('Y-m-d', $baseData->start_time);
        $infoData = MiceDestInfo::where([
            'destinations_id' => $destId
        ])->first();
        // $data = self::formatLang($data);
        return \Response::json(array(
            'status' => 1,
            'data' => [
                'baseData' => $baseData,
                'infoData' => $infoData
            ]
        ));
        // return view('admin.mice.casesDetail', [
        // 'baseData' => $baseData,
        // 'infoData' => $infoData,
        // ]);
    }

    public function addDest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meeting_area' => 'required|numeric|integer',
            'confer_center' => 'required|numeric|integer',
            'hotel_num' => 'required|numeric|integer',
            'destination' => 'required|numeric|integer',
            'hotel_rooms' => 'required|numeric|integer'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        if (MiceDest::add(array_map('htmlspecialchars_decode', $request->all()))) {
            echo '<script>alert("添加成功");javascript:history.back(-1);</script>';
            exit();
        }
        echo '<script>alert("添加失败");javascript:history.back(-1);</script>';
        exit();
    }

    public function updateDest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meeting_area' => 'required|numeric|integer',
            'confer_center' => 'required|numeric|integer',
            'hotel_num' => 'required|numeric|integer',
            'destination' => 'required|numeric|integer',
            'hotel_rooms' => 'required|numeric|integer'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        if (MiceDest::updateById(array_map('htmlspecialchars_decode', $request->all()))) {
            echo '<script>alert("修改成功");javascript:history.back(-1);</script>';
            exit();
        }
        echo '<script>alert("修改失败");javascript:history.back(-1);</script>';
        exit();
    }

    public function delDest(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        \DB::beginTransaction();
        try {
            MiceDest::destroy($ids);
            MiceDestInfo::whereIn('destinations_id', $ids)->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return \Response::json(array(
                'status' => 0,
                'info' => $e->getMessage()
            ));
        }
        return \Response::json(array(
            'status' => 1,
            'info' => '删除成功'
        ));
    }
}
