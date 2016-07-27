@extends('layouts.master')

@section('title', trans('index.my_orangeway'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/lib/slick.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/personal.css')}}">
@endsection

@section('content')
<section class="pc-warp clear">
    @include('member.left-sidebar')
    <!-- 个人中心 主页内容 begin -->
    <div class="pc-main">
        <div class="pc-main-item">
            <div class="pc-title">
                <span>{{trans('member.my_orders')}}</span>
            </div>
            @forelse($orders as $order)
            <div class="pc-order-item clear">
                <img @if(isset($orderImages[$order->type][$order->prd_id])) src="@storageAsset($orderImages[$order->type][$order->prd_id])" @endif>
                      <div class="fl">
                    <p class="p1">{{$orderItems[$order->type][$order->prd_id]->name}}</p>
                    <p class="p2">{{trans('member.order_created_time')}} {{date('Y-m-d H:i:s', $order->ctime)}}</p>
                </div>
                <div class="fr">
                    <span class="s1">{{$order->localMoney['symbol']}} {{$order->localMoney['money']}}</span>
                    <a href="{{url('member/order/detail', ['ordersn'=>$order->order_sn])}}">{{trans('member.view_detail')}}</a>
                </div>
            </div>
            @empty
            <div class="no-order-result">
                <img src="../img/no-order.jpg">
                <span>{{trans('member.no_relevant_orders_now')}}</span>
            </div>
            @endforelse
        </div>
    </div>
    <!-- 个人中心 主页内容 end -->

    <!-- 个人中心 右侧信息 begin -->
    <div class="pc-msg">
        <div class="personal-inf">
            <div class="pc-title">
                <span>{{trans('common.personal_info')}}</span>
            </div>
            <div class="avatar">
                <img @if($member->avatar) src="@storageAsset($member->avatar)" @else src="{{config('common.memberDefaultAvatar')}}" @endif>
                      <span>{{\App\Helpers\Common::getLoginUserName()}}</span>
            </div>
            <div class="p-inf-item clear">
                <div class="fl">
                    <span class="s1">{{trans('common.phone')}}</span>
                    <span class="s2">{{$member->phone}}</span>
                </div>
                <div class="fr">
                    <a href="{{url('member/account')}}">{{trans('common.modify')}}</a>
                </div>
            </div>
            <!--
            <div class="p-inf-item clear">
                <div class="fl">
                    <span class="s1">{{trans('member.id_authentication')}}</span>
                    <span class="s2">{{$member->id_verify ? trans('member.id_authenticated') : trans('member.id_unauthenticated')}}</span>
                </div>
                @unless($member->id_verify)
                <div class="fr">
                    <a href="">{{trans('member.id_authenticate_now')}}</a>
                </div>
                @endunless
            </div>
            -->
        </div>
    </div>
    <!-- 个人中心 右侧 begin -->
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/personal.js')}}"></script>
@endsection

@section('inner-script')

@endsection
