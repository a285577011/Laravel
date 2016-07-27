<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Common as CommonHelper;
use App\Models\Orders;
use App\Helpers\Order as OrderHelper;

class OrderController extends Controller
{
    protected $member;

    public function __construct()
    {
        $this->middleware('auth');
        $this->member = \Auth::user();
    }

    /**
     * 全部订单
     */
    public function index(Requests\Member\SearchOrderRequest $request)
    {
        $request->merge(['type' => 0]);
        $view = 'member.orderlist';
        $viewData = [
            'title'=> trans('member.all_orders'),
        ];
        return $this->search($request, $view, $viewData);
    }

    /**
     * 酒店订单
     * @param \App\Http\Requests\Member\SearchOrderRequest $request
     * @return
     */
    public function hotel(Requests\Member\SearchOrderRequest $request)
    {
        $request->merge(['type' => 3]);
        $view = 'member.orderlist';
        $viewData = [
            'title'=> trans('member.hotel_orders'),
            'noSearchType' => 1,
            'submitUrl' => url('member/order/hotel')
        ];
        return $this->search($request, $view, $viewData);
    }

    /**
     * 机票订单
     * @param \App\Http\Requests\Member\SearchOrderRequest $request
     * @return
     */
    public function flight(Requests\Member\SearchOrderRequest $request)
    {
        $request->merge(['type' => 4]);
        $view = 'member.orderlist';
        $viewData = [
            'title' => trans('member.flight_orders'),
            'noSearchType' => 1,
            'submitUrl' => url('member/order/flight')
        ];
        return $this->search($request, $view, $viewData);
    }

    /**
     * 跟团游订单
     * @param \App\Http\Requests\Member\SearchOrderRequest $request
     * @return
     */
    public function tour(Requests\Member\SearchOrderRequest $request)
    {
        $request->merge(['type' => 1]);
        $view = 'member.orderlist';
        $viewData = [
            'title' => trans('member.tour_orders'),
            'noSearchType' => 1,
            'submitUrl' => url('member/order/tour'),
        ];
        return $this->search($request, $view, $viewData);
    }

    /**
     * 定制游订单
     * @param \App\Http\Requests\Member\SearchOrderRequest $request
     * @return
     */
    public function customization(Requests\Member\SearchOrderRequest $request)
    {
        $request->merge(['type' => 2]);
        $view = 'member.orderlist';
        $viewData = [
            'title'=> trans('member.cust_orders'),
            'noSearchType' => 1,
            'submitUrl' => url('member/order/customazation'),
        ];
        return $this->search($request, $view, $viewData);
    }

    /**
     * 订单搜索
     * @param \App\Http\Requests\Member\SearchOrderRequest $request
     * @param string $view
     * @return
     */
    public function search(Requests\Member\SearchOrderRequest $request, $view=null, $appendViewData=[])
    {
        $condition = [
            'type' => $request->input('type', 0),
            'date_start' => $request->input('date_start', ''),
            'date_end' => $request->input('date_end', ''),
            'status_cfc' => $request->input('status_cfc', 'all'),
        ];
        // 根据快捷搜索修改搜索时间
        if ($request->input('period')) {
            $condition = OrderHelper::getPeriodCdt($request->input('period'), $condition);
        }
        // 根据状态分类修改搜索条件
        $condition = OrderHelper::getStatusCfcCdt($condition);
        $page = $request->input('page', 1);
        $pageNum = config('order.orderListNum');
        $user = $this->member;
        list($count, $list) = Orders::getUserOrder($user->id, $page, $pageNum, $condition);
        list($items, $images) = Orders::getOrderItems($list);
        $viewData = [
            'list' => $list,
            'items' => $items,
            'paginator' => new \Illuminate\Pagination\LengthAwarePaginator(
                $list, $count, $pageNum, $page, [
                'path' => url('member/order/search')
                ]
            ),
            'condition' => $condition,
            'submitUrl' => url('member/order/search'),
        ];
        $viewData = array_merge($viewData, $appendViewData);
        if($request->ajax()) {
            $view = (string) view('member.orderlist-table', $viewData);
            return $this->ajaxReturn(['view' => $view, 'condition' => $condition]);
        }
        return view($view, $viewData);
    }

    /**
     * 取消订单
     * @param \App\Http\Requests\Member\CancelOrderRequest $request
     */
    public function cancel(Requests\Member\CancelOrderRequest $request)
    {
        $ordersn = $request->input('ordersn');
        if(Orders::cancelOrder($ordersn, $this->member->id)) {
            return $this->success();
        }
        return $this->error();
    }

    /**
     * 订单详情
     */
    public function detail(Requests\Member\OrderDetailRequest $request)
    {
        $ordersn = $request->input('ordersn');
        $order = Orders::getUserOrderBySn($ordersn, $this->member->id);
        if(!$order) {
            return $this->error(trans('message.invalid_ordersn'), 'errors/error');
        }
        $order->extraInfo->tourist_info = \json_decode($order->extraInfo->tourist_info);
        $order->extraInfo->invoice_info = \json_decode($order->extraInfo->invoice_info);
        $order->prdInfo->leave_area_name = \App\Models\Area::getNameById($order->prdInfo->leave_area);
        return view('member.orderdetail_'.$order->type, [
            'order' => $order,
            'orderStatusConf' => config('order.orderStatus'),
            'credentialTypeConf' => config('common.credentialType'),
        ]);
    }

}
