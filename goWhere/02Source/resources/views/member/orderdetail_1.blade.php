@extends('layouts.master')

@section('title', trans('member.order_detail'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/order.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/personal.css')}}">
@endsection

@section('content')
<section class="pc-warp clear">
    @include('member.left-sidebar')
    <div class="order-pay my-order-warp">
        <div class="order-pay-step">
            <p class="order-pay-title">{{trans('member.order_detail')}}</p>
            <div class="user-order-detail clear">
                <div class="fl">
                    <p class="p1">{{trans('member.order_sn')}}:{{$order->order_sn}} ({{trans('member.order_created_at',['date'=>\date('Y-m-d', $order->ctime)])}})</p>
                    <p class="p1">{{trans('member.order_status2')}}:@transLang($orderStatusConf[$order->status])</p>
                </div>
                <div class="fr">
                    {{trans('member.order_total_price')}}:<span class="s1">{{$order->localMoney['symbol']}}{{$order->localMoney['money']}}</span>
                </div>
            </div>
            <div class="order-pay-msg">
                <div class="order-pay-msg-title">
                    <span>{{trans('member.order_line_info')}}</span>
                </div>
                <p class="p1">{{$order->prdInfo->name}}</p>
                <span class="s1">{{trans('tour.departure_city')}}：<span>{{$order->prdInfo->leave_area_name}}</span></span>
                <span class="s1">{{trans('member.tour_adult_child_num')}}：<span>{{$order->extraInfo->adult_num}}-{{$order->extraInfo->child_num}}</span></span>
                <span class="s1">{{trans('tour.departure_day')}}：<span>{{date('Y-m-d', $order->extraInfo->departure_date)}}</span><span>{{trans('common.week_zhou_'.date('w', $order->extraInfo->departure_date))}}</span></span>
                <span class="s1">{{trans('tour.return_day')}}：<span>{{date('Y-m-d', $order->extraInfo->return_date)}}</span><span>{{trans('common.week_zhou_'.date('w', $order->extraInfo->return_date))}}</span></span>
            </div>
            <div class="order-pay-msg">
                <div class="order-pay-msg-title">
                    <span>{{trans('tour.lvke_xinxi')}}</span>
                </div>
                @if(isset($order->extraInfo->tourist_info->adult) && $order->extraInfo->tourist_info->adult)
                @foreach($order->extraInfo->tourist_info->adult as $adult)
                <p class="s2">{{trans('tour.lvke')}}：{{$adult->name}} {{$adult->englishName.' '.$adult->englishXing}}，{{trans('tour.adult')}}，@transLang($credentialTypeConf[$adult->zhengjianType])：{{$adult->zhengjian}}，{{$adult->phone}}</p>
                @endforeach
                @endif
                @if(isset($order->extraInfo->tourist_info->child) && $order->extraInfo->tourist_info->child)
                @foreach($order->extraInfo->tourist_info->child as $child)
                <p class="s2">{{trans('tour.lvke')}}：{{$child->name}} {{$child->englishName.' '.$child->englishXing}}，{{trans('tour.child')}}，@transLang($credentialTypeConf[$child->zhengjianType])：{{$child->zhengjian}}，{{$child->phone}}</p>
                @endforeach
                @endif
            </div>
            <div class="order-pay-msg">
                <div class="order-pay-msg-title">
                    <span>{{trans('tour.lianxi_info')}}</span>
                </div>
                <span class="s1">{{trans('common.name')}}：<span>{{$order->extraInfo->contact_name}}</span></span>
                @if($order->extraInfo->contact_phone)<span class="s1">{{trans('common.tel')}}：<span>{{$order->extraInfo->contact_phone}}</span></span>@endif
                @if($order->extraInfo->contact_email)<span class="s1">{{trans('common.email')}}：<span>{{$order->extraInfo->contact_email}}</span></span>@endif
            </div>
            <div class="order-pay-msg" @if($order->status!=1) style="border-bottom:none;" @endif>
                <div class="order-pay-msg-title">
                    <span>{{trans('tour.fapiao_xinxi')}}</span>
                </div>
                @if($order->extraInfo->invoice == 2)
                <span class="s1">{{trans('tour.xiyao_fapiao')}}：<span>{{trans('common.no')}}</span></span>
                @else
                <span class="s1">{{trans('tour.xiyao_fapiao')}}：<span>{{trans('common.yes')}}（{{$order->extraInfo->invoice_info->fapiao_taitou}}）</span></span>
                <span class="s1">{{trans('tour.xiangxi_dizhi')}}：<span>{{$order->extraInfo->invoice_info->address}}</span></span>
                @endif
            </div>
            @if($order->status == 1)
            <a class="user-turn-pay" href="{{\App\Helpers\Order::getPayLink($order)}}">{{trans('member.order_goto_pay')}}</a>
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/personal.js')}}"></script>
@endsection

@section('inner-script')

@endsection
