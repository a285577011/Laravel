<?php
namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Helpers\Common;
use App\Models\TourOrder;
use App\Models\Tour;
class OrderController extends AdminController
{

    public function tourOrderList(Request $request)
    {
        $status = intval($request->input('status'));
        $id = intval($request->input('id'));
        $status&&$where['status']=$status;
        $id && $where['id'] = $id;
        $where['type'] = 1; // 跟团游戏
        $data = Orders::orderBy('ctime', 'desc')->where($where)->paginate(\Config::get('admin.commonPageNum'));
        return view('admin.system.tourorder', [
            'data' => $data
        ]);
    }
    public function tourOrderDetail(Request $request){
        $data=[];
        $id=intval($request->input('orderId'));
        $data['orderData']=Orders::findOrFail($id);
        $data['tourOrderData']=TourOrder::where(['orders_id'=>$id])->first();
        $data['tourData']=Tour::where(['id'=>$data['tourOrderData']['tour_id']])->first();
        return view('admin.system.tourorderdetali', [
            'data' => $data
        ]);
    }
} 
