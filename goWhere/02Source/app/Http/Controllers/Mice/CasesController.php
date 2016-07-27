<?php
namespace App\Http\Controllers\Mice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MiceCases;
use App\Helpers\Common;
use Config;
use App\Models\Area;
use App\Models\MiceCasesInfo;

class CasesController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'numeric|integer',
            'page' => 'numeric|integer|min:0'
        ]);
        if ($validator->fails()) {
            throw new \Exception(trans('common.param_error'));
        }
        $type = intval($request->input('type'));
        $where = [];
        $type && $where['type'] = $type;
        $data = MiceCases::where($where)->orderBy('creat_time', 'desc')->paginate(config('mice.page'));
        if ($data->count()) {
            foreach ($data as $k => $v) {
                $data[$k]->infoData = MiceCasesInfo::where([
                    'cases_id' => $v->id
                ])->first();
            }
        }
        return view('mice.caseindex', [
            'data' => $data
        ]);
    }

    public function detail($id)
    {
        $validator = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|numeric|integer|min:1'
        ]);
        if ($validator->fails()) {
            throw new \Exception(trans('common.param_error'));
        }
        $data['baseData'] = MiceCases::findOrFail(intval($id));
        $data['infoData'] = MiceCasesInfo::where([
            'cases_id' => $data['baseData']->id
        ])->first();
        return view('mice.casedetail', [
            'data' => $data
        ]);
    }
}
