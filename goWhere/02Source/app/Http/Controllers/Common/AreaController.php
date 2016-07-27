<?php
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Common;
use App\Models\Area;

class AreaController extends Controller
{

    public function getById(Request $request)
    {
        $id = $request->input('id');
        if (! $id) {
            return \Response::json(array(
                'status' => 0,
                'info' => trans('common.area_not_found')
            ));
        }
        if (Area::getById($id)) {
            return \Response::json(array(
                'status' => 1,
                'data' => $id
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => trans('common.area_not_found')
        ));
    }

    /**
     * citylist js code
     * @return type
     */
    public function getCityLists()
    {
        $list = \json_encode(Area::getAllCityForSelect());
        return response()->view('common.citylists', [
            'cityList' => $list,
            'hotCities' => json_encode(Area::getHotCityIdForSelect()),
            'asiaList' => json_encode(Area::getByIslandNameForSelect('亚洲')),
            'europeList' => json_encode(Area::getByIslandNameForSelect('欧洲')),
            'americaList' => json_encode(Area::getByIslandNameForSelect('美洲')),
            'africaList' => json_encode(Area::getByIslandNameForSelect('非洲')),
        ])->header('Content-Type', 'application/javascript');
    }
}
