<table class="my-order-result">
    @if($list->count())
    <tr style="background-color: #f5f5f5">
        <td>{{trans('member.order_sn')}}</td>
        <td>{{trans('member.order_type')}}</td>
        <td>{{trans('member.product_name')}}</td>
        <td>{{trans('member.order_status')}}</td>
        <td>{{trans('member.order_created_time')}}</td>
        <td>{{trans('member.order_price')}}</td>
        <td>{{trans('common.operation')}}</td>
    </tr>
    @foreach($list as $l)
    <tr>
        <td>{{$l->order_sn}}</td>
        <td>@transLang($typeShortConf[$l->type])</td>
        <td>{{$items[$l->type][$l->prd_id]->name}}</td>
        <td>@transLang($orderStatusConf[$l->status])</td>
        <td>{{date('Y-m-d H:i', $l->ctime)}}</td>
        <td>{{$l->localMoney['symbol']}}{{$l->localMoney['money']}}</td>
        <td>
            <a href="{{url('member/order/detail', ['ordersn'=>$l->order_sn])}}">{{trans('common.detail')}}</a>
            @if($l->status == '1')
            <a href="{{\App\Helpers\Order::getPayLink($l)}}" target="_blank">{{trans('common.pay')}}</a>
            <a class="cancel-order" data-val="{{$l->order_sn}}">{{trans('common.cancel')}}</a>
            @endif
        </td>
    </tr>
    @endforeach
    @else
    <tr><td colspan="7">{{trans('member.no_relevant_orders_now')}}</td></tr>
    @endif
</table>
{!! (new \App\Extensions\Page\MemberOrderListPresenter($paginator))->render() !!}