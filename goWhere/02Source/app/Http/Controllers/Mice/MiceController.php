<?php
namespace App\Http\Controllers\Mice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MiceCases;
use App\Models\MiceDest;
use Cache;
use App\Models\Recommend;
use function GuzzleHttp\json_encode;
use App\Helpers\Common;
use function GuzzleHttp\json_decode;

class MiceController extends Controller
{

    public function index(Request $request)
    {
        $data = [];
        // 成功案例
        $data['cases'] = $this->getCases();
        // 推荐目的地
        $data['recomDest'] = $this->getRecomDest();
        // $data['type']=\Config::get('mice.type');
        return view('mice.index', [
            'data' => $data
        ]);
    }

    public function getCases()
    {
        //$newData = Cache::store('file')->get('Mice:recom_cases');
        // $newData=[];
        // $data = MiceCases::getCases(5);
        // echo '<pre>';
        // print_r($data[2]['infoData']->toArray());die;
        //if (! $newData) {
            $data = MiceCases::getCases(6);
            $newData['cases'] = []; // JS数据
            if ($data) {
                foreach ($data as $k => $v) {
                    if ($v['image']) {
                        list ($picName, $extension) = explode('.', $v['image']);
                        $v['image'] = $picName . '_' . config('mice.case_thumb_size')[0] . '_' . config('mice.case_thumb_size')[1] . '.' . $extension;
                    }
                    $newData['cases'][$k]['caseImg'] = url(Common::getStoragePath($v['image']));
                    $newData['cases'][$k]['caseTitle'] = $v['infoData']['title'];
                    $newData['cases'][$k]['caseText'] = $v['infoData']['service_content'];
                    $newData['cases'][$k]['caseUrl'] = url('mice/casesdetail') . '/' . $v['id'];
                }
                // echo '<pre>';
                // print_r($newData);
                // echo '<pre>';
                // print_r($newData);die;
                // echo $newData;die;
               
              //  Cache::store('file')->add('Mice:recom_cases', $newData, 60);
            //} else {
            //   $newData = json_encode($newData);
           // }
        }
        $newData = json_encode($newData);
        return $newData;
    }

    public function getRecomDest()
    {
        //$data = Cache::store('file')->get('Mice:recom_dest');
       /// if (! $data) {
            $data = Recommend::where([
                'type' => 3
            ])->take(5)->get(); // MiceDest::where('is_recommend', 1)->take(4)->get();
           // if ($data->count()) {
              //  Cache::store('file')->add('Mice:recom_dest', $data, 60);
          //  }
       // }
        return $data;
    }
}
