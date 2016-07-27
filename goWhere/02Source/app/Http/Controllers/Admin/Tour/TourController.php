<?php
namespace App\Http\Controllers\Admin\Tour;

use Illuminate\Http\Request;
use App\Helpers\Common;
use App\Models\TourDictionary;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Tour;
use App\Models\TourToTravel;
use App\Helpers\Upload;
use App\Models\TourInfo;
use App\Models\TourToPic;
use App;
use Redirect;
use Validator;
use App\Models\TourPriceDate;
use App\Models\MiceCases;
use function GuzzleHttp\json_decode;
use App\Models\Area;
use Illuminate\Support\Facades\Redis;
use function GuzzleHttp\json_encode;
use App\Http\Controllers\Admin\System\ManageController;
use App\Models\Member;
use App\Models\AdminUser;

class TourController extends AdminController
{

    public function tourList(Request $request)
    {
        $getKeys = array_keys($request->all());
        $where = [];
        $id = intval($request->input('id'));
        $status = intval($request->input('status'));
        $name = $request->input('name');
        $id = intval($request->input('id'));
        $name = Common::filterStr($request->input('name'));
        $id && $where['id'] = $id;
        // $name && $where['name_' . App::getLocale()] = $name;
        $status && $where['tour_status'] = $status;
        // $param['type'] = intval($request->input('type'));
        // $param['theme'] = intval($request->input('theme'));
        // $param['destination'] = intval($request->input('destination'));
        $query = Tour::where($where);
        $name && $query->where('name_' . App::getLocale(), 'like', '%' . $name . '%');
        $data = $query->orderBy('ctime', 'desc')->paginate(\Config::get('admin.commonPageNum'));
        return view('admin.tour.tourlist', [
            'data' => $data
        ]);
    }

    public function addTour(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'leave_area' => 'required',
                'price' => 'required|numeric',
                'child_price' => 'required|numeric',
                'lowest_people' => 'required|numeric|integer',
                'advance_day' => 'required|numeric',
                'currency' => 'required|numeric',
                // 'start_day' => 'date',
                // 'end_day' => 'date',
                // 'departure_type' => 'required|numeric',
                // 'type' => 'required|numeric',
                'area' => 'required|numeric',
                'theme' => 'required|numeric',
                // 'stock' => 'required|numeric',
                // 'schedule_days' => 'required|numeric',
                'advance_day' => 'required|numeric',
                'status' => 'required|numeric',
                'nights' => 'required|numeric',
                'days' => 'required|numeric|min:1'
            ]);
            // 'desc' => 'required',
            // 'visit_view' => 'required',
            // 'route_feature' => 'required',
            // 'simple_route' => 'required'
            
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->all()[0]);
            }
            $tour['nights'] = intval($request->input('nights'));
            $tour['days'] = intval($request->input('days'));
            $tour['name'] = Common::filterStr($request->input('name'));
            $tour['leave_area'] = $this->getDestinationStr($request->input('leave_area')); // 途经城市 逗号隔开ID
            $tour['price'] = floatval($request->input('price'));
            $tour['child_price'] = floatval($request->input('child_price'));
            $tour['lowest_people'] = intval($request->input('lowest_people'));
            $tour['advance_day'] = intval($request->input('advance_day'));
            $tour['currency'] = intval($request->input('currency'));
            $tour['start_day'] = strtotime($request->input('start_day'));
            $tour['end_day'] = strtotime($request->input('end_day'));
            // $tour['departure_type'] = intval($request->input('departure_type'));
            // $tour['departure_day'] = $request->input('departure_day');
            $tour['type'] = 7; // 跟团游
            $tour['area'] = intval($request->input('area'));
            $tour['theme'] = intval($request->input('theme'));
            // $tour['stock'] = intval($request->input('stock'));
            $tour['schedule_days'] = $tour['days'] > $tour['nights'] ? $tour['days'] : $tour['nights'];
            $tour['tour_status'] = - 1; // 默认不通过//intval($request->input('status'));
            $tour['destination'] = $this->getDestinationStr($request->input('destination')); // 途经城市 逗号隔开ID
                                                                                             // print_r($tour);die;
            /*
             * $tour['outdate_str'] = $tour['departure_type'] == 2 ? array_map('intval', $request->input('outdate_str')) : '';
             * if ($tour['departure_type'] == 3) {
             * $tour['departure_day'] = @explode(',', $request->input('departure_day'));
             * if ($tour['departure_day']) {
             * $tour['departure_day'] = array_filter(array_map('strtotime', $tour['departure_day']));
             * }
             * } else {
             * $tour['departure_day'] = '';
             * }
             * if ($tour['departure_type'] == 3 && ! $tour['departure_day']) {
             * return $this->error('请输入正确的时间格式');
             * }
             */
            // $tour['weekday'] = intval($request->input('weekday'));
            $tourInfo['desc'] = htmlspecialchars_decode($request->input('desc'));
            $tourInfo['visit_view'] = htmlspecialchars_decode($request->input('visit_view'));
            $tourInfo['route_feature'] = htmlspecialchars_decode($request->input('route_feature'));
            $tourInfo['simple_route'] = htmlspecialchars_decode($request->input('simple_route'));
            $id = Tour::addTour($tour, $tourInfo);
            if (request()->ajax()) {
                return \Response::json(array(
                    'status' => 1,
                    'info' => '添加成功',
                    'toUrl' => route('admin::updateTour', [
                        'id' => $id,
                        'step' => 2
                    ])
                ));
            }
            return Redirect::route('admin::updateTour', [
                'id' => $id,
                'step' => 2
            ]);
        } else {
            return view('admin.tour.addtour');
        }
    }

    public function updateTour(Request $request)
    {
        // echo Redis::hget(config('tour.calendar_redis_key') .'2016-08-11',config('tour.calendar_redis_field_key_total').'145');
        // die;
        // print_r(TourPriceDate::getByTourAndDate(126, 0));die;
        $tourId = intval($request->input('id'));
        $step = intval($request->input('step'));
        if ($request->isMethod('post')) {
            switch ($step) {
                case 1:
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'leave_area' => 'required',
                        'price' => 'required|numeric',
                        'child_price' => 'required|numeric',
                        'lowest_people' => 'required|numeric|integer',
                        'advance_day' => 'required|numeric',
                        'currency' => 'required|numeric',
                        // 'start_day' => 'date',
                        // 'end_day' => 'date',
                        // 'departure_type' => 'required|numeric',
                        // 'type' => 'required|numeric',
                        'area' => 'required|numeric',
                        'theme' => 'required|numeric',
                        // 'stock' => 'required|numeric',
                        // 'schedule_days' => 'required|numeric',
                        'advance_day' => 'required|numeric',
                        'status' => 'required|numeric',
                        'nights' => 'required|numeric',
                        'days' => 'required|numeric|min:1'
                    ]);
                    // 'nights'=>'required|numeric',
                    // 'days'=>'required|numeric|min:1',
                    // 'desc' => 'required',
                    // 'visit_view' => 'required',
                    // 'route_feature' => 'required',
                    // 'simple_route' => 'required'
                    
                    if ($validator->fails()) {
                        throw new \Exception($validator->errors()->all()[0]);
                    }
                    $tour['nights'] = intval($request->input('nights'));
                    $tour['days'] = intval($request->input('days'));
                    $tour['name'] = Common::filterStr($request->input('name'));
                    $tour['leave_area'] = $this->getDestinationStr($request->input('leave_area')); // 途经城市 逗号隔开ID
                    $tour['price'] = floatval($request->input('price'));
                    $tour['child_price'] = floatval($request->input('child_price'));
                    $tour['lowest_people'] = intval($request->input('lowest_people'));
                    $tour['advance_day'] = intval($request->input('advance_day'));
                    $tour['nights'] = intval($request->input('nights'));
                    $tour['currency'] = intval($request->input('currency'));
                    $tour['start_day'] = strtotime($request->input('start_day'));
                    $tour['end_day'] = strtotime($request->input('end_day'));
                    // $tour['departure_type'] = intval($request->input('departure_type'));
                    // $tour['departure_day'] = $request->input('departure_day');
                    $tour['type'] = 7; // 跟团游
                    $tour['area'] = intval($request->input('area'));
                    $tour['theme'] = intval($request->input('theme'));
                    // $tour['stock'] = intval($request->input('stock'));
                    $tour['schedule_days'] = $tour['days'] > $tour['nights'] ? $tour['days'] : $tour['nights'];
                    $tour['tour_status'] = - 1; // 默认不通过intval($request->input('status'));
                    $tour['destination'] = $this->getDestinationStr($request->input('destination')); // 途经城市 逗号隔开ID
                    /*
                     * $tour['outdate_str'] = $tour['departure_type'] == 2 ? array_map('intval', $request->input('outdate_str')) : '';
                     * if ($tour['departure_type'] == 3) {
                     * $tour['departure_day'] = @explode(',', $request->input('departure_day'));
                     * if ($tour['departure_day']) {
                     * $tour['departure_day'] = array_filter(array_map('strtotime', $tour['departure_day']));
                     * }
                     * } else {
                     * $tour['departure_day'] = '';
                     * }
                     * if ($tour['departure_type'] == 3 && ! $tour['departure_day']) {
                     * return $this->error('请输入正确的时间格式');
                     * }
                     */
                    // $tour['weekday'] = intval($request->input('weekday'));
                    $tourInfo['desc'] = htmlspecialchars_decode($request->input('desc'));
                    $tourInfo['visit_view'] = htmlspecialchars_decode($request->input('visit_view'));
                    $tourInfo['route_feature'] = htmlspecialchars_decode($request->input('route_feature'));
                    $tourInfo['simple_route'] = htmlspecialchars_decode($request->input('simple_route'));
                    Tour::updateTour($tour, $tourInfo, $tourId);
                    break;
                default:
                    return $this->success('非法操作');
            }
            if (request()->ajax()) {
                return \Response::json(array(
                    'status' => 1,
                    'info' => '修改成功',
                    'toUrl' => route('admin::updateTour', [
                        'id' => $tourId,
                        'step' => 1
                    ])
                ));
            }
        } else {
            Tour::findOrFail($tourId);
            switch ($step) {
                case 1:
                    // App::setLocale('zh_tw');
                    // echo App::getLocale();
                    $data['baseData'] = Tour::findOrFail($tourId);
                    $data['name'] = Tour::where([
                        'id' => $tourId
                    ])->value('name_zh_cn');
                    // print_r($data['baseData']->toArray());die;
                    $data['infoData'] = TourInfo::where([
                        'tour_id' => $tourId
                    ])->first();
                    break;
                case 2:
                    // Common::sqlDump();
                    $data['list'] = TourToTravel::orderBy('creat_time', 'desc')->where([
                        'tour_id' => $tourId
                    ])->paginate(\Config::get('admin.commonPageNum'));
                    $data['name'] = Tour::where([
                        'id' => $tourId
                    ])->value('name_zh_cn');
                    break;
                case 3:
                    $remark = TourInfo::where([
                        'tour_id' => $tourId
                    ])->value('remark_' . App::getLocale());
                    $data = json_decode($remark);
                    break;
                case 4:
                    $data['list'] = TourToPic::orderBy('id', 'desc')->where([
                        'tour_id' => $tourId
                    ])->paginate(\Config::get('admin.commonPageNum'));
                    // print_r($data['list']->toArray());die;
                    $data['name'] = Tour::where([
                        'id' => $tourId
                    ])->value('name_zh_cn');
                    // break;
                    break;
                default:
                case 5:
                    $startTime = TourPriceDate::orderBy('price_date', 'asc')->where([
                        'tour_id' => $tourId
                    ])
                        ->take(1)
                        ->value('price_date');
                    $endTime = TourPriceDate::orderBy('price_date', 'desc')->where([
                        'tour_id' => $tourId
                    ])
                        ->take(1)
                        ->value('price_date');
                    $startTime or $startTime = time();
                    $endTime or $endTime = time();
                    $year1 = date("Y", $startTime);
                    $month1 = date("m", $startTime);
                    $year2 = date("Y", $endTime);
                    $month2 = date("m", $endTime);
                    $data['selectMonth'] = [];
                    // 相差的月份
                    $monthNum = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
                    for ($i = 0; $i <= $monthNum; $i ++) {
                        $data['selectMonth'][] = $year1 . '-' . ($month1 + $i);
                        // echo $year1 . '-' . ($month1 + $monthNum);
                    }
                    //echo $year2.$month2;die;
                    // echo date('Y-m-01', strtotime("+1 months", strtotime($calendarTime)));die;
                    $calendarTime = $request->input('calendarTime');
                     $calendarTime or $calendarTime = $data['selectMonth'][0];
                    // print_r(strtotime($calendarTime));die;
                    // Common::sqlDump();
                    $data['list'] = TourPriceDate::orderBy('price_date', 'desc')->where([
                        'tour_id' => $tourId
                    ])
                        ->where('price_date', '<', strtotime(date('Y-m-01', strtotime("+1 months", strtotime($calendarTime)))))
                        ->where('price_date', '>=', strtotime(date('Y-m-01', strtotime($calendarTime))))
                        ->get();
                    // print_r($data['list']->toArray());die;
                    $data['name'] = Tour::where([
                        'id' => $tourId
                    ])->value('name_zh_cn');
                    
                    break;
                default:
                    break;
            }
            return view('admin.tour.updatetour' . $step, [
                'data' => $data
            ]);
        }
    }

    public function delTour(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        \DB::beginTransaction();
        try {
            Tour::whereIn('id', $ids)->update([
                'tour_status' => - 3
            ]);
            // MiceCasesInfo::whereIn('cases_id', $ids)->delete();
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

    public function addTourToTravel(Request $request)
    {
        // print_r($request->all());die;
        $destination = $request->input('destination');
        $transport = $request->input('transport');
        $newtransportStr = ''; // $this->getTransportStr($transport); // 转化为ID
        $newDestinationStr = $this->getDestinationStr($destination); // 转化为ID
        
        $tourId = intval($request->input('tourId'));
        Tour::findOrFail($tourId);
        $day = intval($request->input('day'));
        $upload = new Upload();
        $res = $upload->save();
        if (! $res || $res['error']) {
            $image = '';
        } else {
            $image = $res['success'][0]['path'];
        }
        $tourId = intval($request->input('tourId'));
        $area = $this->getDestinationStr($request->input('area')); // 转化为ID$request->input('area'));
        $all = $request->all();
        unset($all['_token'], $all['destination'], $all['transport'], $all['tourId'], $all['day'], $all['file'], $all['area']);
        // print_r();
        // unset($all('_token'));
        // print_r($all);die;
        // unset($all('destination'),$all('transport'),$all('tourId'),$all('day'),$all('file'),$all('area'));
        $all = array_map('htmlspecialchars_decode', $all);
        $desc = json_encode($all);
        if (TourToTravel::add($tourId, $day, $image, $desc, $area, $newDestinationStr, $newtransportStr)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '添加成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '添加失败'
        ));
    }

    public function getTransportStr($transport)
    {
        $newtransportStr = '';
        if ($transport) {
            $newtransport = [];
            $transport = @explode(',', $transport);
            foreach ($transport as $v) {
                if (! $newtransport[] = array_search(trim($v), config('tour.transport_' . \App::getLocale()))) {
                    throw new \Exception('交通工具:' . $v . '不存在');
                }
            }
            // $newtransport = array_filter($newtransport);
            $newtransportStr = implode(',', $newtransport);
        }
        return $newtransportStr;
    }

    public function getDestinationStr($destination)
    {
       // print_r(Area::getAll());
        $newDestinationStr = '';
        if ($destination) {
            $newDestination = [];
            $destination = @explode(',', $destination);
            foreach ($destination as $v) {
               // echo htmlspecialchars_decode($v);
                //Common::sqlDump();
                if (! $newDestination[] = Area::getIdByName(trim(htmlspecialchars_decode($v)), 'zh_cn')) {
                    echo json_encode([
                        'status' => 0,
                        'info' => '地区:' . $v . '不存在'
                    ]);
                    exit();
                    throw new \Exception('地区:' . $v . '不存在');
                }
            }
            // $newDestination = array_filter($newDestination);
            $newDestinationStr = implode(',', $newDestination);
        }
        return $newDestinationStr;
    }

    public function getTravelById($travelId)
    {
        $data = TourToTravel::findOrFail($travelId);
        if ($data->destination) {
            $newArr = [];
            $array = explode(',', $data->destination);
            foreach ($array as $v) {
                $newArr[] = Area::getById($v)['name_' . \App::getLocale()];
            }
            $data->destination = $newArr;
        }
        if ($data->area) {
            $newArr = [];
            $array = explode(',', $data->area);
            foreach ($array as $v) {
                $newArr[] = Area::getById($v)['name_' . \App::getLocale()];
            }
            $data->area = $newArr;
        }
        $data = $data->toArray();
        $data['desc'] = json_decode($data['desc']);
        return \Response::json(array(
            'status' => 1,
            'data' => $data
        ));
    }

    public function updateTourToTravel(Request $request)
    {
        $id = intval($request->input('id'));
        // Tour::findOrFail($tourId);
        $destination = $request->input('destination');
        $transport = $request->input('transport');
        // if (count(explode(',', $destination)) != count(explode(',', $transport))) {
        // return $this->error('目的地跟交通工具数量不对应！');
        // }
        $newtransportStr = ''; // $this->getTransportStr($transport); // 转化为ID
        $newDestinationStr = $this->getDestinationStr($destination); // 转化为ID
        $day = intval($request->input('day'));
        $upload = new Upload();
        $res = $upload->save();
        if (! $res || $res['error']) {
            $image = '';
        } else {
            $image = $res['success'][0]['path'];
        }
        $area = $this->getDestinationStr($request->input('area'));
        $all = $request->all();
        unset($all['_token'], $all['destination'], $all['transport'], $all['tourId'], $all['day'], $all['file'], $all['area'], $all['id']);
        // unset($all('destination'),$all('transport'),$all('tourId'),$all('day'),$all('file'),$all('area'),$all('id'));
        $all = array_map('htmlspecialchars_decode', $all);
        $desc = json_encode($all);
        // $desc = $request->input('desc');
        // print_r($desc);die;
        if (TourToTravel::updateById($id, $area, $day, $image, $desc, $newDestinationStr, $newtransportStr) >= 0) {
            return \Response::json(array(
                'status' => 1,
                'info' => '修改成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '修改失败'
        ));
    }

    public function delTourToTravel(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (TourToTravel::destroy($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    public function addTourRemark(Request $request)
    {
        $tourId = intval($request->input('tourId'));
        Tour::findOrFail($tourId);
        $feeIncludes = $request->input('fee_includes'); // 费用包含
        $feeNot = $request->input('fee_not'); // 费用不含
        $preferentialPolicy = $request->input('preferential_policy'); // 预定须知//优惠条框
        $cancelPolicy = $request->input('cancel_policy'); // 签证信息
        $noteMatter = $request->input('note_matter'); // 注意事项
        $remark = $request->input('remark'); // 备注
        $array = [
            'feeIncludes' => $feeIncludes,
            'feeNot' => $feeNot,
            'preferentialPolicy' => $preferentialPolicy,
            'cancelPolicy' => $cancelPolicy,
            'noteMatter' => $noteMatter,
            'remark' => $remark
        ];
        $array = array_map('htmlspecialchars_decode', $array);
        // print_r($array['feeIncludes']);die;
        $json = json_encode($array);
        if (TourInfo::updaterRemark($tourId, $json) >= 0) {
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }

    public function addTourImage(Request $request)
    {
        $tourId = intval($request->input('tourId'));
        Tour::findOrFail($tourId);
        $upload = new Upload();
        $res = $upload->save();
        if (! $res) {
            $image = '';
        } else {
            foreach ($res['success'] as $v) {
                $image[] = $v;
            }
            // $image = $res['success'][0]['info'];
        }
        $info = '';
        foreach ($image as $v) {
            TourToPic::add($tourId, $v['path']);
        }
        return $this->success('图片上传成功');
    }

    public function delTourImage(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (TourToPic::destroy($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    public function ueditorUpload(Request $request)
    {
        $action = $request->input('action');
        $result = json_encode(array(
            'state' => '请求地址出错'
        ));
        if ($action == 'uploadimage') {
            $upload = new Upload();
            $res = $upload->save();
            if (! $res) {
                $image = '';
            } else {
                $image = $res['success'][0]['path'];
                // $image = $res['success'][0]['info'];
            }
            // $up = new Uploader($fieldName, $config, $base64);
            
            /**
             * 得到上传文件所对应的各个参数,数组结构
             * array(
             * "state" => "", //上传状态，上传成功时必须返回"SUCCESS"
             * "url" => "", //返回的地址
             * "title" => "", //新文件名
             * "original" => "", //原始文件名
             * "type" => "" //文件类型
             * "size" => "", //文件大小
             * )
             */
            $info = [];
            $info['state'] = $image ? 'SUCCESS' : 'FAIL';
            $info['url'] = url(Common::getStoragePath($image));
            $info['title'] = $upload->saveName;
            $info['original'] = $upload->oriName;
            $info['type'] = $upload->extension;
            $info['size'] = $upload->fileSize;
            /* 返回数据 */
            $result = json_encode($info);
        } elseif ($action == 'config') {
            $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("admin/components/utf8-php/php/config.json")), true);
            $result = json_encode($config);
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
                exit();
            } else {
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
                exit();
            }
        } else {
            echo $result;
            exit();
        }
    }

    public function addPriceDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tourId' => 'required|numeric',
            'price' => 'required|numeric',
            'child_price' => 'required|numeric',
            'start_day' => 'date',
            'end_day' => 'date',
            'departure_type' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $departureType = $request->input('departure_type');
        $departureDay = $request->input('departure_day');
        $outdateStr = $departureType == 2 ? array_map('intval', $request->input('outdate_str')) : '';
        if ($departureType == 3) {
            $departureDay = @explode(',', $departureDay);
            if ($departureDay) {
                $departureDay = array_filter(array_map('strtotime', $departureDay));
            }
        } else {
            $departureDay = '';
        }
        if ($departureType == 3 && ! $departureDay) {
            return $this->error('请输入正确的时间格式');
        }
        $priceDate = Tour::getPriceDate(strtotime($request->input('start_day')), strtotime($request->input('end_day')), $departureType, $departureDay, $outdateStr);
        TourPriceDate::add($request->input('tourId'), $request->input('price'), $request->input('child_price'), $request->input('stock'), $priceDate);
        return $this->success('添加成功');
    }

    public function getPriceDateById(Request $request)
    {
        $id = $request->input('id');
        $data = TourPriceDate::findOrFail($id);
        $data->price_date = date('Y-m-d', $data->price_date);
        return \Response::json(array(
            'status' => 1,
            'data' => $data
        ));
    }

    /**
     * 批量
     *
     * @param Request $request            
     */
    public function updatePriceDate(Request $request)
    {
        $priceData = $request->input('pirceData');
        if (! $priceData) {
            return $this->error('参数错误');
        }
        \DB::beginTransaction();
        try {
            foreach ($priceData as $k => $v) {
                
                $price = floatval($v['price']);
                $cPrice = floatval($v['child_price']);
                $stock = intval($v['stock']);
                $where = [];
                $price && $where['adult_price'] = $price;
                $cPrice && $where['child_price'] = $cPrice;
                $stock && $where['stock'] = $stock;
                TourPriceDate::where([
                    'id' => $k
                ])->update($where);
                $data = TourPriceDate::find($k);
                $date = date('Y-m-d', $data->price_date);
                $cPrice && Redis::hset(config('tour.calendar_redis_key') . $date, config('tour.calendar_redis_field_key_child_price') . $data->tour_id, $cPrice);
                $price && Redis::hset(config('tour.calendar_redis_key') . $date, config('tour.calendar_redis_field_key_price') . $data->tour_id, $price);
                $stock && Redis::hset(config('tour.calendar_redis_key') . $date, config('tour.calendar_redis_field_key_total') . $data->tour_id, $stock);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->error($e->getMessage());
        }
        return $this->success('修改成功');
    }

    public function delPriceDate(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (TourPriceDate::del($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    public function checkTour(Request $request)
    { // 审核跟团游
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        $status = intval($request->input('status'));
        if (! array_key_exists($status, config('tour.tour_status'))) {
            throw new \Exception('状态错误');
        }
        if ($status == 1) {
            foreach ($ids as $id) {
                $TourTravelData = TourToTravel::where([
                    'tour_id' => $id
                ])->get();
                foreach ($TourTravelData as $TourTravelDataC) {
                    if (! $TourTravelDataC->area) {
                        return \Response::json(array(
                            'status' => 0,
                            'info' => '详细行程第' . $TourTravelDataC->day . '天未填写完成'
                        ));
                        break;
                    }
                }
                if (! TourToPic::where([
                    'tour_id' => $id
                ])->first()) {
                    return \Response::json(array(
                        'status' => 0,
                        'info' => '线路图片未上传，请上传'
                    ));
                    break;
                }
                if (! TourPriceDate::where([
                    'tour_id' => $id
                ])->first()) {
                    return \Response::json(array(
                        'status' => 0,
                        'info' => '线路价格日期未填写'
                    ));
                    break;
                }
            }
        }
        if ($ids) {
            if (Tour::whereIn('id', $ids)->update([
                'tour_status' => $status
            ])) {
                \Log::info(json_encode([
                    'action' => 'checkTour',
                    'user' => AdminUser::where([
                        'id' => \Auth::id()
                    ])->value('username'),
                    'userId' => \Auth::id(),
                    'tourId' => @implode(',', $ids)
                ]));
                return \Response::json(array(
                    'status' => 1,
                    'info' => '操作成功'
                ));
            }
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '操作失败'
        ));
    }
} 
