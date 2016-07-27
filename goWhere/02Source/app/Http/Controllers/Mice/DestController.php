<?php
namespace App\Http\Controllers\Mice;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\MiceDest;
use App\Models\MiceCases;
use App\Helpers\Common;
use App\Models\MiceCasesInfo;
use App\Models\MiceDestInfo;

class DestController extends Controller
{

    public function detail($id)
    {
        $validator = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|numeric|integer|min:1'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $data = [];
        $data['baseData'] = MiceDest::findOrFail(intval($id));
        $destinationsId = $data['baseData']->area_id;
        $data['infoData'] = MiceDestInfo::where([
            'destinations_id' => $id
        ])->first();
        $data['cases'] = MiceCases::getCaseByDest($destinationsId, 5);
        return view('mice.destination', [
            'data' => $data
        ]);
    }
}
