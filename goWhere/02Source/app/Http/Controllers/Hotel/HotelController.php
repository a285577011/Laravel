<?php
/**
 * 酒店相关功能
 * 
 * @author xiening 2016-06-30
 */
namespace App\Http\Controllers\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\Common;
use Illuminate\Support\Facades\Input;
use App\Models\Area;
use function GuzzleHttp\head;
use function GuzzleHttp\json_encode;
use Omnipay\Omnipay;
use App\Models\Recommend;
use Redirect;
use DB;
use App\Models\HotelOrder;
use App\Models\Orders;
class HotelController extends Controller
{

    public static function checkLogin()
    {
        if (! \Auth::id()) {
            throw new \Exception(trans('common.need_login'));
        }
        return \Auth::id();
    }

    /**
     * 首页
     */
    public function index()
    {
        return view('hotel.index', []);
    }

    /**
     * 酒店列表
     */
    public function lists(Request $request)
    {
        //print_r($request->all());die;
        $validator = Validator::make($request->all(), [
        	//目的地：必填，城市id
        	'destination' => 'required|numeric ',
            'checkin' => 'required|date ',
        	'checkout'=> 'required|date',
            'adult' => 'required|numeric|integer|min:0',
            'child' => 'required|numeric|integer|min:0',
            'page' => 'numeric|min:1'
        ]);
//         if ($validator->fails()) {
//             throw new \Exception($validator->errors()->all()[0]);
//         }
        $param['destination'] = intval($request->input('destination'));
        $param['checkin'] = strtotime($request->input('checkin'));
        $param['checkout'] = strtotime($request->input('checkout'));
        $param['adultNum'] = intval($request->input('adult'));
        $param['childNum'] = intval($request->input('child'));
        $param['page'] = intval($request->input('page', 1));
        //测试环境，直接从数据库中读取数据
        $status = "dev";
        if ($status == "dev") {
        	//测试环境目的地全部定为57175		有2000+个酒店
        	$param['destination'] = 58383;
        	$pageSize = 10;
        	$total = DB::connection('hotel')->select("select count(id) as num from t_hotel where city_id = {$param['destination']} ");
        	$total = $total[0]->num;
        	
//         	$data = DB::connection('hotel')->select("select t1.id,
//         													t2.`name` as countryname ,
//         													t3.`name` as provicename ,
//         													t1.`name`,t1.address,
//         													t1.introduction,
// 										        			t1.longitude,
// 										        			t1.latitude from t_hotel t1 
// 																join t_dict_country t2 on t1.country_code =t2.`code`
// 																join t_dict_province t3 on t1.province_id=t3.id
// 															where city_id = {$param['destination']} limit {$param['page']},  {$pageSize}");
        	
        	$data = DB::connection('hotel')->select("select id,`name`,address,stars,longitude,latitude,introduction,image_url_list from t_hotel 
        			where city_id = {$param['destination']} limit {$param['page']},  {$pageSize}");
        	
        	
        	
        } else {
        	//正式环境，走ota平台的api
        }
        
        
        if (!empty($data)) {
        	$latLng = array();
        	foreach ($data as $key => $record) {
        		$tempArray = array();
        		$tempArray['num'] = $key;
        		$tempArray['lat'] = $record->latitude;
        		$tempArray['lng'] = $record->longitude;
        		
        		//显示在地图上的酒店的编号
        		if ($key < 10) {
        			$keyStr = '0'.$key;
        		}else {
        			$keyStr = $key;
        		}
        		
        		$tempArray['marker_blue'] = "../images/map_marker/map_blue_".$keyStr.".png";
        		$tempArray['marker_cur'] = "../images/map_marker/map_orange_".$keyStr.".png";
        		$tempArray['hotel_name'] = $record->name;
        		
        		//取回酒店图片集中的第一张图片
        		if (!empty($record->image_url_list)) {
        			$imgArray = explode("|",$record->image_url_list);
        			$hotel_img = $imgArray[0];
        		} else {
        			$hotel_img = '';
        		}
        		
        		$tempArray['hotel_img'] = $hotel_img;
        		$data[$key]->hotel_img = $hotel_img;
        	}
        	//地图
        	$maker = array('latLng'=>$latLng);
        } else {
        	$maker = array('latLng'=>array());
        }
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator('', $total, config('hotel.pageSize'), $param['page'], [
        		'path' => '/hotel/list'
        		]);
        return view('hotel.lists', [
        	'data' => $data,
        	//翻页控件
        	'paginator'=>$paginator,
        	//	
        	'latLng'=>$maker
        ]);
    }

    /**
     * 酒店详情
     */
    public function detail(Request $request)
    {
    	
    	return view('hotel.detail', []);
    	/**
    	$validator = Validator::make($request->all(), [
    			//目的地：必填，城市id
    			'destination' => 'required|numeric ',
    			'checkin' => 'required|date ',
    			'checkout'=> 'required|date',
    			'adult' => 'required|numeric|integer|min:0',
    			'child' => 'required|numeric|integer|min:0',
    			'hotel_id' => 'required|numeric '
    	]);
    	**/
    	
    	//测试数据
    	$otaid = 1;
    	$timeout = 600;	//暂时定6秒超时
    	$checkin = "2016-07-08";
    	$checkout = "2016-07-09";
    	$hotelIds = array(2);
    	
    	
    	
    	
    	
    	
    	
    }
    
    
    /**
     * 下单页面
     * hotel-order.html
     */
    public function order(Request $request)
    {
    	//self::checkLogin();
    	header('Cache-control: private, must-revalidate');
    	
    	$validator = Validator::make($request->all(), [
    			'hotel_id' 	=> 'required|numeric|integer|min:1',				//所属酒店id
    			'room_id' 	=> 'required|numeric|integer|min:1',				//房型id
    			'adult_num' => 'required|numeric|integer|min:1',				
    			'child_num' => 'required|numeric|integer|min:0',
    			'checkin' 	=> 'required|date',
    			'checkout' 	=> 'required|date'
    			]);
//     	if ($validator->fails()) {
//     		throw new \Exception($validator->errors()->all()[0]);
//     	}
    	
    	
    	$hotelId = $request->input('hotel_id');
    	$roomId = intval($request->input('room_id'));
    	$adultNum = intval($request->input('adult_num'));
    	$childNum = intval($request->input('child_num'));
    	$checkin = $request->input('checkin');
    	$checkout = $request->input('checkout');
    	//入住天数
    	$days = strtotime($checkout) - strtotime($checkin);
    	if ($days <= 0) {
    		throw new \Exception(trans('hotel.date_error'));
    	}
    	//天数向上取整
    	$days = ceil($days);
    	
    	//查看下单时房间是否还存在，因为ota平台的api未未完成，因此暂时不检测
    	$roomInfo = $this -> roomcheck($hotelId,$roomId,$adultNum,$childNum,$checkin,$checkout);
    	if (! $roomInfo) {
    		throw new \Exception(trans('hotel.room_not_found'));
    	}
    	
    	
    	return view('hotel.order', [
//     			'token' => self::getToken(),
    			'hotelId' 	=> $hotelId,
    			'hotelName'	=> $roomInfo['hotelName'],
    			'roomId' 	=> $roomId,
    			'roomName'	=> $roomInfo['roomName'],
    			'adultNum' 	=> $adultNum,
    			'childNum' 	=> $childNum,
    			'checkin' 	=> $checkin,
    			'checkout' 	=> $checkout,
    			'price' 	=> $roomInfo['price'],
    			'days' 		=> $days
    			]);
    }
    
    /**
     * 提交订单
     * 
     */
    public function addOrder(Request $request)
    {
    	/**
    	var_dump($request->all());
    	return false;
    	
    	
    	self::checkLogin();
    	$rule = array(
    			'hotel_id' 	=> 'required|numeric|integer',				//酒店id
    			'room_id' 	=> 'required|numeric|integer',				//房型id
    			'adult_num' => 'required|numeric|integer|min:1',
    			'child_num' => 'required|numeric|integer|min:0',
    			'room_num'	=> 'required|numeric|integer|min:1',				//房间数
    			'checkin' 	=> 'required|date',
    			'checkout' 	=> 'required|date',
    			
    			//联系人信息
    			'contact_name' => 'required',
    			'contact_gender' => 'required|numeric|integer|between:1,2',
    			'contact_email' => 'required|email',
    			'contact_phone' => 'required|phone_cn',
    			'contact_wx' => array(
    					'required',
    					'regex:/(^[a-zA-Z\d_]{5,}$)/'			//最低5位数包含字母数字下划线
    			),
    			
    			//发票信息
    			'isNeedFapiao' => 'required|numeric|between:1,2'
    			);
    	if ($request->isMethod('post')) {
    		//住客信息
    		$tenants = $request->input('tenants');
    		// partner 必须是非空数组
    		if (!is_array($tenants) || empty($tenants)) {
    			throw new \Exception(trans('hotel.tenants_error'));
    		}
    		$qty = count($tenants);
    		$adultNum = intval($request->input('adult_num'));
    		$childNum = intval($request->input('child_num'));
    		if ($adultNum + $childNum != $qty) {
    			throw new \Exception(trans('hotel.tenants_num_error'));
    		}
    		for ($i = 0; $i < $qty; $i++) {
    			$rules["tenants.$i.firstName"] = 'required|max:32';
    			$rules["tenants.$i.lastName"] = 'required|max:32';
    			$rules["tenants.$i.phone"] = 'required|phone_cn';
    		}
    	}
    		
    	$validator = Validator::make($request->all(), $rule);
    	if ($validator->fails()) {
    		throw new \Exception($validator->errors()->all()[0]);
    	}
		//房间数量
    	$roomNum = intval($request->input('adult_num'));
    	
    	//验证房型是否存在
    	$roomInfo = $this->roomcheck($hotelId,$roomId,$adultNum,$childNum,$checkin,$checkout);
    	if (! $roomInfo) {
    		throw new \Exception(trans('hotel.room_not_found'));
    	}
    		
    		
    	//order表数据
    	$order['order_sn'] 		= $this->build_order_no();
    	$order['prd_id'] 		= 0 ;							//酒店订单时为0	
    	$order['prd_time'] 		= 0 ;
    	$order['members_id'] 	= \Auth::id() ?: 0; 			// $session
   		$order['currency'] 		= 1;							//人民币	
   		$order['type'] 			= 3; 							//订单类型：1 跟团游；2 定制游；3 酒店订单； 4 机票订单
    	$order['from'] 			= 1; 							//1 web
   		$order['payment'] 		= 1;							//支付方式：1;支付宝
    	$order['status'] 		= 1;							//订单状态：1 未支付；2 支付成功；3 取消支付； 4 已退款；
    	$order['ctime'] 		= time();
    	$order['mtime'] 		= time();
   		$order['paytime'] 		= 0;
    	$order['remark'] 		= '';
    	//
    	$order['departure_date'] 		= 0;					//字段不数据库中不存在 ，为了兼容Model/order
    	$order['money']			=	$roomNum * $roomInfo['price'];	//总价
    	
   		//hotelorder表数据
   		$hotelOrder['hotel_id'] 		=	intval($request->input('hotel_id'));
   		$hotelOrder['hotel_name'] 		=	$roomInfo['hotelName'];
    	$hotelOrder['room_id'] 			=	intval($request->input('room_id'));
    	$hotelOrder['room_name'] 		=	$roomInfo['roomName'];
    	
   		$hotelOrder['room_price'] 		=	$roomInfo['price'];
    	$hotelOrder['room_num'] 		=	intval($request->input('room_num'));
    	$hotelOrder['adult_num'] 		=	intval($request->input('adult_num'));
    	$hotelOrder['child_num'] 		=	intval($request->input('child_num'));
    	$hotelOrder['checkin'] 			=	$request->input('checkin');
    	$hotelOrder['checkout'] 		=	$request->input('checkout');
    	$hotelOrder['invoice'] 			=	intval($request->input('invoice'));
    		
   		//发票信息
   		if ($hotelOrder['invoice'] == 1) {
   			$hotelOrder['invoice_info'] = json_encode([
   				'fapiao_taitou' => Common::filterStr($request->input('fapiao_taitou')),
    			'address' => Common::filterStr($request->input('address'))
    			]);
    	}else {
    		$hotelOrder['invoice_info'] = '';
    	}
    		
   		//联系人
    	$hotelOrder['contact_name'] 	= Common::filterStr($request->input('contact_name'));
    	$hotelOrder['contact_gender'] 	= intval($request->input('contact_gender'));
    	$hotelOrder['contact_phone'] 	= $request->input('contact_phone');
    	$hotelOrder['contact_email'] 	= $request->input('contact_email');
    	$hotelOrder['contact_wx'] 		= $request->input('contact_wx');
    	$hotelOrder['notice'] 			= Common::filterStr($request->input('notice'));
    	//住户信息
    	$tenantsinfo = array();
    	for ($i = 0; $i < $qty; $i++) {
    		$tenantsinfo[] = array(
    				'fn'	=>	$request->input("tenants.$i.firstName"),
    				'ln'	=>	$request->input("tenants.$i.lastName"),
    				'ph'	=>	$request->input("tenants.$i.phone")
    				);
    	}		
    	$hotelOrder['tenants_info'] =	json_encode($tenantsinfo);
    	$hotelOrder['currency'] 			= 1;														//币种
    	$hotelOrder['total_price'] 			= $hotelOrder['room_price']*$hotelOrder['room_num'];		//总价
    	**/
    	/**
    	 * 测试数据
    	 */	
    	//order表数据		共15个字段
    	$order['order_sn'] 		= $this->build_order_no();
    	$order['prd_id'] 		= 0 ;							//酒店订单时为0
    	$order['prd_time'] 		= 0 ;
    	$order['members_id'] 	= \Auth::id() ?: 0; 			// $session
    	$order['currency'] 		= 1;							//人民币
    	$order['type'] 			= 3; 							//订单类型：1 跟团游；2 定制游；3 酒店订单； 4 机票订单
    	$order['from'] 			= 1; 							//1 web
    	$order['payment'] 		= 1;							//支付方式：1;支付宝
    	$order['status'] 		= 1;							//订单状态：1 未支付；2 支付成功；3 取消支付； 4 已退款；
    	$order['ctime'] 		= time();
    	$order['mtime'] 		= time();
    	$order['paytime'] 		= 0;
    	$order['remark'] 		= '';
    	$order['money'] 		= 100.02;
    	$order['departure_date'] 		= '';
    	
    		//测试数据		共21字段
    		$hotelOrder['hotel_id'] 		=	1;
    		$hotelOrder['hotel_name']		=	'hotel_name_test1';
    		$hotelOrder['room_id'] 			=	1;
    		$hotelOrder['room_name']		=	'room_name_test1';
    		$hotelOrder['room_price'] 		=	100;
    		$hotelOrder['room_num'] 		=	2;
    		$hotelOrder['adult_num'] 		=	1;
    		$hotelOrder['child_num'] 		=	2;
    		$hotelOrder['checkin'] 			=	'2016-08-01';
    		$hotelOrder['checkout'] 		=	'2016-08-03';
    		$hotelOrder['invoice'] 			=	2;
    		$hotelOrder['invoice_info'] 		= 	'';
    		
    		$hotelOrder['contact_name'] 	= 'c_name';
    		$hotelOrder['contact_gender'] 	= 1;
    		$hotelOrder['contact_phone'] 	= 123456789;
    		$hotelOrder['contact_email'] 	= '123@126.com';
    		$hotelOrder['contact_wx'] 		= 'wx123456';
    		$hotelOrder['notice'] 			= ''; 
    		
    		$hotelOrder['currency'] 			= 1;
    		$hotelOrder['tenants_info'] 			= '';
    		$hotelOrder['total_price'] 			= $hotelOrder['room_price']*$hotelOrder['room_num'];
    		$HotelOrderModel = new HotelOrder();
    		list ($orderId, $hotelOrderId) = $HotelOrderModel->addOrder($order, $hotelOrder);
            return Redirect::to('hotel/pay?orderId=' . \Crypt::encrypt($orderId));
    	
    }
    
    
    /**
     * 付款页面
     */
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
        //检查order表
    	$orderData = Orders::where([
            'id' => $orderId
        ])->first(); // 获取订单详情
        if (! $orderData) {
            throw new \Exception('没有可付款的订单');
        }
        if ($orderData->status != 1) {
            throw new \Exception('订单状态不正确!');
        }
        
        if (! $hotelOrderData = HotelOrder::where([
            'orders_id' => $orderId
        ])->first()) {
            throw new \Exception('无效订单');
        }
        
        //下单1小时内不付款为过期
        if ($orderData->ctime < time()-3600) {
            throw new \Exception('订单已经过期');
        }
        
        return view('hotel.pay', [
        		//订单信息
        		'orderId' => \Crypt::encrypt($orderData->id),
        		'hotelId' => $hotelOrderData['hotel_id'],
        		'hotelName' => $hotelOrderData['hotel_name'],
        		'roomId' => $hotelOrderData['room_id'],
        		'roomName' => $hotelOrderData['room_name'],
        		'adultNum' => $hotelOrderData['adult_num'],
        		'childNum' => $hotelOrderData['child_num'],
        		'checkin' => $hotelOrderData['checkin'],
        		'checkout' => $hotelOrderData['checkout'],
        		'roomNum' => $hotelOrderData['room_num'],
        		'roomPrice' => $hotelOrderData['price'],
        		'totalPrice' => $hotelOrderData['total_price'],
        		
        		//联系人
        		'contactsDate' => [
	        		'contact_name' => $hotelOrderData['contact_name'],
	        		'contact_gender' => $hotelOrderData['contact_gender'],
	        		'contact_phone' => $hotelOrderData['contact_phone'],
	        		'contact_email' => $hotelOrderData['contact_email'],
	        		'contact_wx' => $hotelOrderData['contact_wx']
        		],
        		
        		//住客信息
        		
        		//发票
        		'invoiceInfo' => [
	        		'invoice' => $hotelOrderData['invoice'],
	        		'fapiao_taitou' => json_decode($hotelOrderData['invoice_info'], true)['fapiao_taitou'],
	        		'address' => json_decode($hotelOrderData['invoice_info'], true)['address']
        		]
        	]);
    }
    
    /**
     * 跳转支付页面
     * 
     * 目前只支付支付宝
     */
    public function toPay(Request $request)
    {
        self::checkLogin();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
//                 'orderId' => 'required',
                'payType' => 'required'
            ]);
//             if ($validator->fails()) {
//                 throw new \Exception($validator->errors()->all()[0]);
//             }
            
            $orderId = $request->input('orderId');
            $orderId = \Crypt::encrypt(242);
            try {
                $orderId = intval(\Crypt::decrypt($orderId));
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                throw new \Exception('无效订单');
                //
            }
            
            $type = $request->input('payType');
            //订单数据
            $orderData = Orders::where([
            		'id' => $orderId,
//             		'members_id' => self::checkLogin()
            		])->first(); // 获取订单详情
            //hotelOrder从表数据
            $hotelOrderData = HotelOrder::where([
            		'orders_id' => $orderId
            		])->first();
            if (! $orderData) {
            	throw new \Exception('没有可付款的订单');
            }
            if ($orderData->status != 1) {
            	throw new \Exception('订单状态不正确!');
            }
            
	        //下单1小时内不付款为过期
	        if ($orderData->ctime < time()-3600) {
	            throw new \Exception('订单已经过期');
	        }
			//住房时间(N晚)
	        $days = (strtotime($hotelOrderData->checkout) - strtotime($hotelOrderData->checkin))/(3600*24);
           
            switch ($type) {
                case 'alipay':
                    $gateway = Omnipay::create('Alipay_Express');
                    $gateway->setPartner(config('laravel-omnipay.hotel')['alipay']['options']['partner']);
                    $gateway->setKey(config('laravel-omnipay.hotel')['alipay']['options']['key']);
                    $gateway->setSellerEmail(config('laravel-omnipay.hotel')['alipay']['options']['sellerEmail']);
                    $gateway->setReturnUrl(config('laravel-omnipay.hotel')['alipay']['options']['returnUrl']);
                    $gateway->setNotifyUrl(config('laravel-omnipay.hotel')['alipay']['options']['notifyUrl']);
                    $options = [
                        'out_trade_no' => $orderId,
                        'subject' => $hotelOrderData->hotel_name .'-'.$hotelOrderData->room_name .':' . $days . trans('hotel.night') ,
                        'total_fee' => $orderData['money']
                    ]; // $orderData['money']
                       // print_r($options);die;
                    $response = $gateway->purchase($options)->send();
                    $response->redirect();
                    break;
            }
        }
    }
    
    /**
     * 支付成功异步回调
     */
    public function payNotify($payType)
    {
    	\Log::info('支付异步回调');
    	if (! array_key_exists($payType, config('laravel-omnipay.hotel'))) {
    		throw new \Exception('非法操作');
    	}
    	switch ($payType) {
    		case 'alipay':
    			if ($outTradeNo = $this->alipayNotify()) {
    				\Log::info('支付异步回调成功');
    				if ($this->complatePay($outTradeNo)) {
    					echo 'success';
    				}
    				exit();
    			}
    			echo 'fail';
    			exit();
    			break;
    	}
    }
   /**
    * 支付宝的异步回调
    */ 
    public function alipayNotify()
    {
    	\Log::info(json_encode([	
    			'action' => 'hotelPay',		//酒店订单支付
    			'payType' => 'alipay',
    			'user' => \Auth::id(),
    			Input::get()
    			]));
    	$gateway = Omnipay::create('Alipay_Express');
    	$gateway->setPartner(config('laravel-omnipay.hotel')['alipay']['options']['partner']);
    	$gateway->setKey(config('laravel-omnipay.hotel')['alipay']['options']['key']);
    	$gateway->setSellerEmail(config('laravel-omnipay.hotel')['alipay']['options']['sellerEmail']);
    
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
    	if (! array_key_exists($payType, config('laravel-omnipay.hotel'))) {
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
    /**
     * 支付成功业务逻辑
     */
    public function complatePay($outTradeNo)
    { // //支付成功处理
    \DB::beginTransaction();
    try {
    	$orderStatus = Orders::where([
    			'id' => $outTradeNo
    			])->value('status');
    	if ($orderStatus == 1) {
    		Orders::paySuccessUp($outTradeNo, 2, 1);
    		$hotelOrderData = HotelOrder::where([
    				'orders_id' => $outTradeNo
    				])->select('hotel_name','room_name','room_num','contact_phone')->first();
    	
    	//短信内容
    	$name = $hotelOrderData->hotel_name .'-'. $hotelOrderData->room_name;
    		
    		\PhpSms::make()->to($hotelOrderData->contact_phone)
    		->template(config('common.smsHotelTemplate'))
    		->data([
    				'name' => $name
    				])
    				->send(); // 发送短信
    	}
    	\DB::commit();
    } catch (\Exception $e) {
    	\DB::rollback();
    	\Log::info(json_encode([
    			'action' => 'payNotify',
    			'outTradeNo'=>$outTradeNo,
    			'payType' => 'alipay',
    			'msg' => $e->getMessage()
    			]));
    	return false;
    }
    return true;
    }
    
    
    
    public function paySuccess(Request $request)
    {
    	try {
    		$orderId = \Crypt::decrypt($request->input('orderId'));
    	} catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
    		throw new \Exception('无效订单');
    		//
    	}
    	$sno = Orders::where([
    			'id' => $orderId,
    			'status' => 2,
    			'members_id' => self::checkLogin()
    			])->value('order_sn');
    	if (! $sno) {
    		throw new \Exception('system error');
    	}
    	$hotelOrderData = HotelOrder::where([
    			'orders_id' => $orderId
    			])->first();
    	return view('hotel.paysuccess', [
    			'hotelOrderData' => $hotelOrderData,
    			'sno' => $sno,
    			'orderId' => $orderId
    			]);
    }
    
    
    
    /**
     * 查询房型是还可以下单
     */
    private function roomcheck($hotelId,$roomId,$adultNum,$childNum,$checkin,$checkout)
    {
    	$roomInfo = array(
    			'hotelId' =>'1',
    			'hotelName'	=>'hotelName',
    			'roomId'	=>'1',
    			'roomName'	=>'roomName',
    			'price'		=> 1000	
    	);
    	return $roomInfo;
    }
    
    
    
    /**
     * 生成订单号
     */
    private function build_order_no()
    {
    	return (date('y') + date('m') + date('d')) . str_pad((time() - strtotime(date('Y-m-d'))), 5, 0, STR_PAD_LEFT) . substr(microtime(), 2, 6) . sprintf('%03d', rand(0, 999));
    }
    
    /**
     * 
     */
    private function getToken()
    {
    	return md5(microtime(true));
    }

}
