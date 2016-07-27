<?php
namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Tour;
use App\Models\TourOrder;
use App\Helpers\Common;
use App\Models\TourPriceDate;
use App\Http\Requests\Tour\TourAddOrderRequest;
use App\Http\Requests\Tour\TourDetailRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Orders;
use App\Models\Area;
use function GuzzleHttp\head;
use App\Models\TourInfo;
use App\Models\TourToTravel;
use App\Models\TourToPic;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\json_decode;
use Omnipay\Omnipay;
use App\Models\Recommend;
use Redirect;
use App\Helpers\TransChinese;

class TourController extends Controller
{

    public static function checkLogin()
    {
        if (! \Auth::id()) {
            throw new \Exception(trans('common.need_login'));
        }
        return \Auth::id();
    }

    public function index()
    {
        //print_r(Area::getAll());die;
        $data = [];
        // 获取推荐路线
        $data['recomTour'] = $this->getRecomTour();
        // 获取当前最近几个线路
        $data['newTour1'] = $this->getNewTour(0, 4);
        $data['newTour2'] = $this->getNewTour(4, 4);
        $data['islandData'] = $this->getislandData(); // 获取各个州的线路个数
                                                      // die;
        return view('tour.index', [
            'data' => $data
        ]);
    }

    public function getislandData()
    {
        $data = [];
        $areaData = Area::getAll();
        $continent = [];
        $i = 0;
        foreach ($areaData as $k => $v) {
            if ($v['type'] == 0) {
                if (in_array($v['name_zh_cn'], config('tour.index_tuijian_zhou'))) {
                    $continent[$v['id']] = $v['name_' . \App::getLocale()];
                    if ($i >= 3) {
                        break;
                    }
                    $i ++;
                }
            }
        }
        foreach ($continent as $k => $v) {
            $ids = Tour::whereRaw("FIND_IN_SET({$k},belong_destination)")->where([
                'tour_status' => 1
            ])->lists('id');
            if ($ids) {
                foreach ($ids as $ks => $id) {
                    if (! TourPriceDate::where([
                        'tour_id' => $id
                    ])->first()) {
                        unset($ids[$ks]);
                    }
                }
            }
            $data[$k] = [
                'name' => $v,
                'count' => count($ids)
            ];
        }
        return $data;
    }

    public function lists(Request $request)
    {
        // Common::sqlDump();
        $validator = Validator::make($request->all(), [
            'go_date' => 'date',
            'adult' => 'numeric|integer|min:0',
            'child' => 'numeric|integer|min:0',
            'schedule_days' => 'numeric|integer|min:0',
            'startPrice' => 'numeric|min:0',
            'endPrice' => 'numeric|min:0',
            'page' => 'numeric|min:1',
            'leave_area'=>'numeric',
            'destinationId'=>'numeric'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $param['areaId'] = $request->input('destinationId');
        $param['goDate'] = strtotime($request->input('go_date'));
        $param['adultNum'] = intval($request->input('adult'));
        $param['childNum'] = intval($request->input('child'));
        // $areaId && $param['areaId'] = $areaId;
        $param['scheduleDay'] = intval($request->input('schedule_days'));
        $param['page'] = intval($request->input('page', 1));
        $param['sort'] = Common::filterStr($request->input('sort'));
        $param['startPrice'] = floatval($request->input('startPrice'));
        $param['endPrice'] = floatval($request->input('endPrice'));
        $param['startPrice'] = Common::getPriceByValue($param['startPrice']);
        $param['endPrice'] = Common::getPriceByValue($param['endPrice']);
        $param['leaveArea'] = $request->input('leave_area');
        // Common::sqlDump();
        list ($data, $leaveCity, $scheduleDays, $paginator) = Tour::getList($param);
        $orderField = $orderby = '';
        $order = $this->filterOrder($param['sort'], array(
            'price',
            'day',
            'salenum'
        ), array(
            'asc',
            'desc'
        ));
        if (is_array($order) && $order) {
            list ($orderField, $orderby) = $order;
        }
        list ($priceSort, $daySort, $salenumSort) = $this->getSort($orderField, $orderby);
        return view('tour.lists', [
            'data' => $data,
            'leaveCity' => $leaveCity,
            'scheduleDays' => $scheduleDays,
            'order' => [
                'priceSort' => $priceSort,
                'daySort' => $daySort,
                'salenumSort' => $salenumSort
            ],
            'paginator' => $paginator,
            'areaId' => $param['areaId']
        ]);
    }

    /**
     * 获取排序
     *
     * @param unknown $orderField            
     * @param unknown $orderby            
     * @return multitype:string
     */
    public function getSort($orderField, $orderby)
    {
        $priceSort = $daySort = $salenumSort = '';
        switch ($orderField) {
            case 'price':
                if ($orderby == 'asc') {
                    $priceSort = 'desc';
                } elseif ($orderby == 'desc') {
                    $priceSort = 'asc';
                }
                break;
            case 'day':
                if ($orderby == 'asc') {
                    $daySort = 'desc';
                } elseif ($orderby == 'desc') {
                    $daySort = 'asc';
                }
                break;
            case 'salenum':
                if ($orderby == 'asc') {
                    $salenumSort = 'desc';
                } elseif ($orderby == 'desc') {
                    $salenumSort = 'asc';
                }
                break;
            default:
                break;
        }
        return array(
            $priceSort,
            $daySort,
            $salenumSort
        );
    }

    /**
     * 过滤排序
     *
     * @param unknown $sort            
     * @param array $allowfiled            
     * @param array $orderRule            
     * @return boolean multitype:unknown
     */
    public function filterOrder($sort, array $allowfiled, array $orderRule)
    {
        if ($sort) {
            if (count(explode('-', $sort)) != 2) {
                return false;
            }
            list ($orderField, $order) = explode('-', $sort);
            if (! in_array($orderField, $allowfiled) || ! in_array(strtolower($order), $orderRule)) {
                return false;
            }
            return array(
                $orderField,
                $order
            );
        }
        return false;
    }

    /**
     * 获取推荐路线
     *
     * @return unknown
     */
    public function getRecomTour()
    {
        $data = \Cache::store('file')->get('Tour:recom_tour');
        if (! $data) {
            $data = Recommend::where('type', 8)->take(3)->get();
            \Cache::store('file')->add('Tour:recom_tour', $data, 60); // 缓存一个小时
        }
        return $data;
    }

    /**
     * 获取全球行
     *
     * @return unknown
     */
    public function getNewTour($limitStart, $num)
    {
        $data = \Cache::store('file')->get('Tour:new_tour_' . $limitStart);
        if (! $data) {
            $data = Tour::orderBy('ctime', 'desc')->where([
                'tour_status' => 1
            ])
                ->take($num)
                ->offset($limitStart)
                ->get();
            \Cache::store('file')->add('Tour:new_tour_' . $limitStart, $data, 60); // 缓存一个小时
        }
        return $data;
    }

    public function detail(TourDetailRequest $request)
    {
        $id = intval($request->input('id'));
        $data['tour'] = Tour::where([
            'id' => $id,
            'tour_status' => 1
        ])->first();
        if (! $data['tour']) {
            abort(404);
        }
        // 获取日期旅游
        $data['tour_info'] = TourInfo::getByTourId($id);
        $data['tour_to_travel'] = TourToTravel::getByTourId($id);
        if ($data['tour_to_travel']->count()) {
            $data['tour_to_travel'] = $data['tour_to_travel']->toArray();
            $daySort = [];
            foreach ($data['tour_to_travel'] as $v) {
                $daySort[] = $v['day'];
            }
            array_multisort($daySort, SORT_ASC, $data['tour_to_travel']);
        }
        $data['tour_to_pic'] = TourToPic::getPicById($id);
        $tourPriceDate = $this->getTourDateData($id, $data['tour']->advance_day);
        if (! $tourPriceDate) {
            abort(404);
        }
        list ($tourPriceDateJson, $showMaxMonth) = $this->formatJson($tourPriceDate);
        $defaultDate = key($tourPriceDate);
        $priceArr = [
            'price' => '',
            'child_price' => ''
        ];
        $tourPriceDate && $priceArr = TourPriceDate::getPriceByIdDate($id, strtotime($defaultDate));
        return view('tour.detail', [
            'data' => $data,
            'tourPriceDateJson' => $tourPriceDateJson,
            'tourPriceDate' => $tourPriceDate,
            'id' => $id,
            'showMaxMonth' => $showMaxMonth,
            'priceArr' => $priceArr,
            'defaultDate' => $defaultDate
        ]);
    }

    public function getPriceByIdDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'tourId' => 'required|numeric|min:1'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $id = $request->input('tourId');
        $date = strtotime($request->input('date'));
        $priceArr = TourPriceDate::getPriceByIdDate($id, $date);
        if ($priceArr) {
            return \Response::json(array(
                'status' => 1,
                'data' => $priceArr
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => 'error'
        ));
    }

    public function formatJson($data)
    {
        $newData = [];
        $time = [];
        if ($data) {
            foreach ($data as $k => $v) {
                $time[] = strtotime($k);
                $newData[$k]['surplus'] = trans('tour.yu') . $v['total'] . trans('tour.wei');
                $newData[$k]['price'] = Common::getCurrencySymbol() . common::getPriceByValue($v['price']) . trans('tour.up');
            }
            $max = max($time);
            $min = time();
            $year1 = date("Y", $min);
            $month1 = date("m", $min);
            $year2 = date("Y", $max);
            $month2 = date("m", $max);
            // 相差的月份
            $monthNum = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
            // echo $month2;die;
            return array(
                json_encode($newData),
                $monthNum + 1
            );
        }
        return [
            null,
            null
        ];
    }

    public static function getToken()
    {
        return md5(microtime(true));
    }

    public function getTourDateData($id, $advanceDay)
    {
        $startDay = strtotime(date('Y-m-d', strtotime("+{$advanceDay} days")));
        return TourPriceDate::getByTourAndDate($id, $startDay);
    }

    public function addOrder(TourAddOrderRequest $request)
    {
        self::checkLogin();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'departure_date' => 'required|date',
                'contact_gender' => 'required|numeric|integer|between:1,2',
                'contact_email' => 'required|email',
                'child_num' => 'numeric|min:0',
                'adult_num' => 'required|numeric|min:1',
                'tour_id' => 'required|numeric|min:1',
                'isNeedFapiao' => 'required|numeric|between:1,2',
                'contact_phone' => array(
                    'required',
                    'regex:/(^1(3|4|5|7|8)[0-9]{9}$)|(^(\d{3})[-]?(\d{8})$|^(\d{4})[-]?(\d{7,8})$)/'
                )
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->all()[0]);
            }
            $order['order_sn'] = $this->build_order_no();
            $order['prd_id'] = intval($request->input('tour_id'));
            // 检查产品
            if (! $tourData = Tour::getOneById($order['prd_id'])) {
                throw new \Exception(trans('tour.product_not_found'));
            }
            $order['members_id'] = \Auth::id() ?: 0; // $session
            $order['currency'] = 1;
            $order['type'] = 1; // 跟团游
            $order['from'] = 1; // 1 web
            $order['payment'] = 0;
            $order['status'] = 1;
            $order['ctime'] = time();
            $order['mtime'] = time();
            $order['paytime'] = 0;
            $order['remark'] = '';
            $order['departure_date'] = $tourOrder['departure_date'] = strtotime($request->input('departure_date'));
            if (! $priceData = TourPriceDate::getPriceByIdDate($order['prd_id'], $tourOrder['departure_date'])) {
                throw new \Exception(trans('tour.schedule_not_found'));
            }
            $tourOrder['insurance_id'] = $request->input('insurance_id');
            $tourOrder['adult_num'] = intval($request->input('adult_num'));
            $tourOrder['child_num'] = intval($request->input('child_num'));
            $insuranceMoney = 0;
            $tourOrder['insurance_num']=0;
            if ($tourOrder['insurance_id']) {
                foreach (@explode(',', $tourOrder['insurance_id']) as $k => $v) {
                    $insuranceMoney += ($tourOrder['adult_num'] + $tourOrder['child_num']) * config('tour.insurance')[$v]['price'];
                    $tourOrder['insurance_num']+=$tourOrder['adult_num'] + $tourOrder['child_num'];
                }
            }
            $tourOrder['total_price'] = $order['money'] = $insuranceMoney + ($tourOrder['adult_num'] * $priceData['price']) + ($priceData['child_price'] * $tourOrder['child_num']);
            $tourOrder['invoice'] = intval($request->input('isNeedFapiao'));
            $tourOrder['invoice_info'] = json_encode([
                'fapiao_taitou' => Common::filterStr($request->input('fapiao_taitou')),
                'address' => Common::filterStr($request->input('address'))
            ]);
            $tourOrder['currency'] = 1;
            $tourOrder['contact_name'] = Common::filterStr($request->input('contact_name'));
            $tourOrder['contact_gender'] = intval($request->input('contact_gender'));
            $tourOrder['contact_phone'] = $request->input('contact_phone');
            $tourOrder['contact_email'] = $request->input('contact_email');
            $touristInfo = $request->input('tourist');
            $array = [];
            if (isset($touristInfo['child']) && is_array($touristInfo['child'])) {
                $keys = array_keys($touristInfo['child']);
                $count = count($touristInfo['child'][$keys[0]]);
                for ($i = 0; $i < $count; $i ++) {
                    foreach ($keys as $k) {
                        if (! $touristInfo['child'][$k][$i]) {
                            throw new \Exception('请填写全部旅客信息');
                        }
                        $array['child'][$i][$k] = $touristInfo['child'][$k][$i];
                    }
                }
            }
            if (isset($touristInfo['adult']) && is_array($touristInfo['adult'])) {
                $keys = array_keys($touristInfo['adult']);
                $count = count($touristInfo['adult'][$keys[0]]);
                for ($i = 0; $i < $count; $i ++) {
                    foreach ($keys as $k) {
                        if (! $touristInfo['adult'][$k][$i]) {
                            throw new \Exception('请填写全部旅客信息');
                        }
                        $array['adult'][$i][$k] = $touristInfo['adult'][$k][$i];
                    }
                }
            }
            $tourOrder['tourist_info'] = json_encode($array);
            $this->check($request);
            list ($orderId, $tourOrderId) = TourOrder::addOrder($order, $tourOrder);
            return Redirect::to('tour/pay?orderId=' . \Crypt::encrypt($orderId));
        }
    }

    public function pay(Request $request)
    {
        self::checkLogin();
        $orderId = $request->input('orderId');
        try {
            $orderId = intval(\Crypt::decrypt($orderId));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            throw new \Exception('无效订单');
            //
        }
        if (! $tourOrderData = TourOrder::where([
            'orders_id' => $orderId
        ])->first()) {
            abort(404);
        }
        if ($tourOrderData->departure_date < time()) {
            throw new \Exception('订单已经过期');
        }
        $orderData = Orders::where([
            'id' => $orderId,
            'members_id' => self::checkLogin()
        ])->first(); // 获取订单详情
        if (! $orderData) {
            throw new \Exception('没有可付款的订单');
        }
        if ($orderData->status != 1) {
            throw new \Exception('订单状态不正确!');
        }
        $tourData = Tour::findOrFail($tourOrderData->tour_id);
        $array = json_decode($tourOrderData->tourist_info, true);
        // $tourOrderId
        $comeBackDate = date('Y-m-d', $tourOrderData['departure_date'] + $tourData->schedule_days * 86400);
        return view('tour.pay', [
            'tourData' => $tourData,
            'touristData' => $array,
            'contactsDate' => [
                'contact_name' => $tourOrderData['contact_name'],
                'contact_gender' => $tourOrderData['contact_gender'],
                'contact_phone' => $tourOrderData['contact_phone'],
                'contact_email' => $tourOrderData['contact_email']
            ],
            'adult_num' => $tourOrderData['adult_num'],
            'child_num' => $tourOrderData['child_num'],
            'comeBackDate' => $comeBackDate,
            'departureDate' => date('Y-m-d', $tourOrderData['departure_date']),
            'invoiceInfo' => [
                'invoice' => $tourOrderData['invoice'],
                'fapiao_taitou' => json_decode($tourOrderData['invoice_info'], true)['fapiao_taitou'],
                'address' => json_decode($tourOrderData['invoice_info'], true)['address']
            ],
            'totalPrice' => $tourOrderData['total_price'],
            'orderId' => \Crypt::encrypt($tourOrderData->id)
        ]);
    }

    private function check($request)
    {
        $url = $_SERVER['HTTP_REFERER'];
        $param = parse_url($url);
        $tokenKey = md5($param['path']);
        if (\Session::get($tokenKey) == $request->input('token') || ! $request->input('token')) {
            throw new \Exception(trans('common.repeat_order'));
        }
        \Session::put($tokenKey, $request->input('token'));
    }

    private function checkOper()
    {}

    private function build_order_no()
    {
        return (date('y') + date('m') + date('d')) . str_pad((time() - strtotime(date('Y-m-d'))), 5, 0, STR_PAD_LEFT) . substr(microtime(), 2, 6) . sprintf('%03d', rand(0, 999));
    }

    public function toPay(Request $request)
    {
        abort(404);
        self::checkLogin();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'orderId' => 'required',
                'payType' => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->all()[0]);
            }
            $tourOrderId = $request->input('orderId');
            try {
                $tourOrderId = intval(\Crypt::decrypt($tourOrderId));
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                throw new \Exception('无效订单');
                //
            }
            $type = $request->input('payType');
            $tourOrderData = TourOrder::findOrFail($tourOrderId);
            if ($tourOrderData->departure_date < time()) {
                throw new \Exception('订单已经过期');
            }
            $tourData=Tour::findOrFail($tourOrderData['tour_id']);
            $goodsName =$tourData['name_' . \App::getLocale()].'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')';
            if (! array_key_exists($type, config('laravel-omnipay.gateways'))) {
                throw new \Exception('非法操作');
            }
            $orderData = Orders::where([
                'id' => $tourOrderData['orders_id'],
                'members_id' => self::checkLogin()
            ])->first(); // 获取订单详情
            if (! $orderData) {
                throw new \Exception('没有可付款的订单');
            }
            if ($orderData->status != 1) {
                throw new \Exception('订单状态不正确!');
            }
            switch ($type) {
                case 'alipay':
                    $gateway = Omnipay::create('Alipay_Express');
                    $gateway->setPartner(config('laravel-omnipay.gateways')['alipay']['options']['partner']);
                    $gateway->setKey(config('laravel-omnipay.gateways')['alipay']['options']['key']);
                    $gateway->setSellerEmail(config('laravel-omnipay.gateways')['alipay']['options']['sellerEmail']);
                    $gateway->setReturnUrl(config('laravel-omnipay.gateways')['alipay']['options']['returnUrl']);
                    $gateway->setNotifyUrl(config('laravel-omnipay.gateways')['alipay']['options']['notifyUrl']);
                    $options = [
                        'out_trade_no' => $orderData['order_sn'],
                        'subject' => $goodsName.trans('tour.adult') . '-' . trans('tour.child') . trans('tour.num') . ':' . $tourOrderData->adult_num . '-' . $tourOrderData->child_num,
                        'total_fee' => $orderData['money']
                    ]; // $orderData['money']
                       // print_r($options);die;
                    $response = $gateway->purchase($options)->send();
                    $response->redirect();
                    break;
            }
        }
    }

    public function payNotify($payType)
    {
        \Log::info('支付异步回调');
        if (! array_key_exists($payType, config('laravel-omnipay.gateways'))) {
            throw new \Exception('非法操作');
        }
        switch ($payType) {
            case 'alipay':
                if ($outTradeNo = $this->alipayNotify()) {
                    \Log::info('支付异步回调成功');
                    if ($this->complatePay($outTradeNo)) {
                        echo 'success';
                        exit();
                    }
                }
                echo 'fail';
                exit();
                break;
        }
    }

    public function alipayNotify()
    {
        \Log::info(json_encode([
            'action' => 'tourPay',
            'payType' => 'alipay',
            'user' => \Auth::id(),
            Input::get()
        ]));
        $gateway = Omnipay::create('Alipay_Express');
        $gateway->setPartner(config('laravel-omnipay.gateways')['alipay']['options']['partner']);
        $gateway->setKey(config('laravel-omnipay.gateways')['alipay']['options']['key']);
        $gateway->setSellerEmail(config('laravel-omnipay.gateways')['alipay']['options']['sellerEmail']);
        
        // For 'Alipay_MobileExpress', 'Alipay_WapExpress'
        // $gateway->setAlipayPublicKey('/such-as/alipay_public_key.pem');
        $options = [
            'request_params' => Input::get()
        ]; // Don't use $_REQUEST for may contain $_COOKIE
        $response = $gateway->completePurchase($options)->send();
        if ($response->isSuccessful() && $response->isTradeStatusOk()) {
            \Log::info('成功订单,订单号:' . Input::get('out_trade_no'));
            return Input::get('out_trade_no');
            // Paid success, your statements go here.
            
            // For notify, response 'success' only please.
            // die('success');
        } else {
            \Log::info('失败订单,订单号:' . Input::get('out_trade_no'));
            return false;
            // For notify, response 'fail' only please.
            // die('fail');
        }
    }

    public function payReturn($payType)
    {
        if (! array_key_exists($payType, config('laravel-omnipay.gateways'))) {
            throw new \Exception('非法操作');
        }
        switch ($payType) {
            case 'alipay':
                if ($outTradeNo = $this->alipayNotify()) {
                    $this->complatePay($outTradeNo);
                    // Orders::paySuccessUp($outTradeNo, 2, 1);
                    $orderId = \Crypt::encrypt($outTradeNo);
                    return Redirect::to('tour/paysuccess?orderId=' . $orderId);
                } else {
                    throw new \Exception(trans('common.pay_fail'));
                }
                break;
        }
    }

    public function bookCheck(Request $request)
    {
        if (! \Auth::id()) {
            return \Response::json(array(
                'status' => - 1,
                'info' => trans('common.need_login')
            ));
        }
        $tourId = intval($request->input('tour_id'));
        $adultNnum = intval($request->input('adult_num'));
        $childNum = intval($request->input('child_num'));
        $departureDate = $request->input('departure_date');
        if ($adultNnum <= 0) {
            return \Response::json(array(
                'status' => 0,
                'info' => trans('tour.adult') . trans('tour.piaoshu_least1')
            ));
        }
        $validator = Validator::make($request->all(), [
            'tour_id' => 'numeric|integer|min:1',
            'adult_num' => 'numeric|integer|min:1',
            'child_num' => 'numeric|integer|min:0',
            'departure_date' => 'required|date'
        ]);
        if ($validator->fails()) {
            return \Response::json(array(
                'status' => 0,
                'info' => $validator->errors()->all()[0]
            ));
        }
        if (! TourPriceDate::checkNum($tourId, strtotime($departureDate), $adultNnum, $childNum)) {
            return \Response::json(array(
                'status' => 0,
                'info' => trans('tour.schedule_not_found')
            ));
        }
        return \Response::json(array(
            'status' => 1,
            'info' => ''
        ));
    }

    public function bookNext(Request $request)
    {
        self::checkLogin();
        header('Cache-control: private, must-revalidate');
        $validator = Validator::make($request->all(), [
            'tour_id' => 'numeric|integer|min:1',
            'adult_num' => 'numeric|integer|min:1',
            'child_num' => 'numeric|integer|min:0',
            'departure_date' => 'required|date'
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->all()[0]);
        }
        $tourId = intval($request->input('tour_id'));
        $adultNnum = intval($request->input('adult_num'));
        $childNum = intval($request->input('child_num'));
        $departureDate = $request->input('departure_date');
        $tourDateData = TourPriceDate::getPriceByIdDate($tourId, strtotime($departureDate));
        if (! $tourDateData) {
            throw new \Exception(trans('tour.schedule_not_found'));
        }
        $tourData = Tour::findOrFail($tourId);
        $comeBackDate = date('Y-m-d', strtotime($departureDate . ' + ' . ($tourData->schedule_days - 1) . ' days'));
        $tourDate = $this->getTourDateData($tourId, $tourData->advance_day); // TourPriceDate::getDateById($tourId);
        return view('tour.booknext', [
            'token' => self::getToken(),
            'tourId' => $tourId,
            'adultNnum' => $adultNnum,
            'childNum' => $childNum,
            'tourData' => $tourData,
            'comeBackDate' => $comeBackDate,
            'departureDate' => $departureDate,
            'tourDate' => $tourDate,
            'tourDateData' => $tourDateData
        ]);
    }

    public function paySuccess(Request $request)
    {
        try {
            $orderSno = \Crypt::decrypt($request->input('orderId'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            throw new \Exception('无效订单');
            //
        }
        $orderId = Orders::where([
            'order_sn' => $orderSno,
            'status' => 2,
            'members_id' => self::checkLogin()
        ])->value('id');
        if (! $orderId) {
            throw new \Exception('system error');
        }
        $tourOrderData = TourOrder::where([
            'orders_id' => $orderId
        ])->first();
        $tourData = Tour::findOrFail($tourOrderData['tour_id']);
        $similarTour = $this->getSimilarTour($tourData['type']);
        return view('tour.paysuccess', [
            'tourData' => $tourData,
            'sno' => $orderSno,
            'orderId' => $orderId,
            'tourOrderData' => $tourOrderData,
            'similarTour' => $similarTour
        ]);
    }

    public function getSimilarTour($type)
    {
        $data = \Cache::store('file')->get('Tour:similar_tour_type:' . $type);
        if (! $data) {
            $data = Tour::where([
                'type' => $type,
                'tour_status' => 1
            ])->take(3)->get();
            if ($data->count()) {
                foreach ($data as $k => $v) {
                    $data[$k]->infoData = TourInfo::where([
                        'tour_id' => $v['id']
                    ])->first();
                }
            }
            \Cache::store('file')->add('Tour:similar_tour_type:' . $type, $data, 60); // 缓存一个小时
        }
        return $data;
    }

    public function complatePay($outTradeNo)
    { // //支付成功处理
        \DB::beginTransaction();
        try {
            $orderData = Orders::where([
                'order_sn' => $outTradeNo
            ])->select('id','status')->first();
            if ($orderData['status'] == 1) {
                Orders::paySuccessUp($orderData['id'], 2, 1);
                $TourOrderData = TourOrder::where([
                    'orders_id' => $orderData['id']
                ])->first();
                \DB::table('tour')->where([
                    'id' => $TourOrderData->tour_id
                ])->increment('booking_count'); // 更新预订数量
                \DB::table('tour_price_date')->where(['tour_id'=>$TourOrderData['tour_id'],'price_date'=>$TourOrderData['departure_date']])->where('stock', '>=', $TourOrderData['adult_num']+$TourOrderData['child_num'])
                ->decrement('stock',$TourOrderData['adult_num'] + $TourOrderData['child_num']); // 更新门票数量
                // 更新redis
                \LaravelRedis::hIncrBy(config('tour.calendar_redis_key') . date('Y-m-d',$TourOrderData['departure_date']), config('tour.calendar_redis_field_key_total') . $TourOrderData->tour_id, - ($TourOrderData['adult_num'] + $TourOrderData['child_num']));
                $tourData=Tour::findOrFail($TourOrderData->tour_id);
                $goodsName =$tourData['name_' . \App::getLocale()].'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')';
                \PhpSms::make()->to($TourOrderData->contact_phone)
                    ->template(config('common.smsTourTemplate'))
                    ->data([
                    'name' => $goodsName
                ])
                    ->send(); // 发送短信
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::info(json_encode([
                'action' => 'payNotify',
                'payType' => 'alipay',
                'msg' => $e->getMessage()
            ]));
            return false;
        }
        return true;
    }
}
