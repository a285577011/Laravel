<?php
use App\Helpers\Common;
?>
@extends('layouts.master')
 @section('title',trans('common.order_hotel'))
@section('navClass','ow-inner-nav') @section('content')
 @section('style') @parent
  <link rel="stylesheet" href="{{ asset('/css/src/hotel-inner.css') }}">
	<style>
.order-pay-step {
    border-bottom: 1px solid #e6e6e6;
    padding: 20px;
}
.order-pay-step .order-pay-title {
    color: #333;
    font-size: 24px;
    margin-bottom: 25px;
}
.order-pay-step .p2 {
    color: #f58220;
    font-size: 20px;
    margin-bottom: 15px;
    margin-left: 20px;
}
.order-pay-step .order-pay-type {
    margin-left: 20px;
}
.order-pay-step .order-pay-type .p3 {
    border-bottom: 1px dashed #c5c5c5;
    color: #666;
    font-size: 14px;
    padding-bottom: 5px;
}
.order-pay-step .order-pay-type .radio-warp {
    display: inline-block;
    margin-right: 50px;
    margin-top: 20px;
    padding-left: 20px;
    position: relative;
}
.order-pay-step .order-pay-type .radio-warp .radio {
    left: 0;
    position: absolute;
    top: 10px;
}
.order-pay-step .order-pay-type .radio-warp .pay-type-img.alipay {
    background-image: url("../../images/alipay.jpg");
}
.order-pay-step .order-pay-type .radio-warp .pay-type-img {
    display: inline-block;
    height: 40px;
    width: 140px;
}
.pay-btns {
   margin-top: 26px;
   margin-bottom: 26px;
    text-align: center;
}
.pay-btns .pay-ok {
    background-color: #f58220;
}
.pay-btns button {
    border: medium none;
    border-radius: 2px;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-size: 16px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    width: 120px;
}
</style>
@stop @section('content')
<section class="hotel-search">
  <div class="hotel-search-warp">
    <div class="hotel-search-title clear">

    </div>
  </div>
</section>
<!-- 进度条 begin -->
<section class="order-step clear">
  <div class="order-bar-x1 mr2"></div>
  <div class="order-bar-x2 mr3"></div>
  <div class="order-bar-x3 mr5"></div>
  <div class="order-step-bar order-step-bar-cur">
    <div class="order-step-num">1</div>
    <div class="order-step-text">{{trans('tour.tianxie_order')}}</div>
  </div>
  <div class="order-step-bar order-step-bar-cur">
    <div class="order-step-num">2</div>
    <div class="order-step-text">{{trans('tour.zaixian_zhifu')}}</div>
  </div>
  <div class="order-step-bar mr5">
    <div class="order-step-num">3</div>
    <div class="order-step-text">{{trans('tour.wancheng_yuding')}}</div>
  </div>
  <div class="order-bar-x3 mr3"></div>
  <div class="order-bar-x2 mr2"></div>
  <div class="order-bar-x1"></div>
</section>
 <form class="order-write-form" action="{{url('hotel/topay')}}" method="post" id="payForm">
  {!! csrf_field() !!}
<section class="hotel-order-confirm">
  <div class="hotel-order-confirm-warp ">
    <p class="hotel-order-confirm-title">确认订单</p>

    <div class="hotel-order-confirm-part">
      <div class="order-write-msg-title">
        <img src="../img/border-left.png">
          <span>
            预定信息
          </span>
      </div>
      <div class="hotel-order-confirm-part-item">
        <div class="w100 clear">
          <div class="fl">
            <p>
              <span class="fs18 c_blue mr16">Moni Gallery Hostel(莫尼画廊旅馆)</span>
             <span class="order-view-star">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
             </span>
            </p>
            <p class="fs14 c6 lh26">263 Lavender Street,新加坡,338795,新加坡</p>
          </div>
          <p class="fr">
            <span class="mr16 fs18 c6">订单总价</span>
            <span class="fs26 main-color mr40">￥1398</span>
          </p>
        </div>
        <div>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('hotel.room_type')}}：</span>
            <span class="fs14 c6">标准单人房（无窗）-不含早（预付）</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('tour.adult')}}-{{trans('tour.child').trans('tour.num')}}：</span>
            <span class="fs14 c6">4-1</span>
          </p>
        </div>
        <div>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('hotel.check-in-out_date')}}：</span>
            <span class="fs14 c6">2015.09.12 - 2015.09.13（1晚）</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('hotel.room_num')}}：</span>
            <span class="fs14 c6">2间</span>
          </p>
        </div>
      </div>
    </div>
    <div class="hotel-order-confirm-part mt20">
      <div class="order-write-msg-title">
        <img src="../img/border-left.png">
          <span>
            {{trans('hotel.guest_info')}}
          </span>
      </div>
      <div class="hotel-order-confirm-part-item">
        <div>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('hotel.guest_info')}}1：</span>
            <span class="fs14 c6">张三，13605921489</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">住客2：</span>
            <span class="fs14 c6">张三，13605921489</span>
          </p>
        </div>
        <div>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('common.remark')}}：</span>
            <span class="fs14 c6">有窗户，无烟房</span>
          </p>
        </div>
      </div>
    </div>
    <div class="hotel-order-confirm-part mt20">
      <div class="order-write-msg-title">
        <img src="../img/border-left.png">
          <span>
            {{trans('tour.lianxi_info')}}
          </span>
      </div>
      <div class="hotel-order-confirm-part-item">
        <div>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('common.name')}}：</span>
            <span class="fs14 c6">张三</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('common.phone')}}：</span>
            <span class="fs14 c6">13605921489</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('common.email')}}：</span>
            <span class="fs14 c6">56897@qq.com</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('mice.qq_wechat')}}：</span>
            <span class="fs14 c6">-</span>
          </p>
          <p class="hotel-order-confirm-p">
            <span class="fs14 c9">{{trans('tour.xiyao_fapiao')}}：</span>
            <span class="fs14 c6">是（安庆旺旺食品有限公司）</span>
          </p>
          <p class="iBlock">
            <span class="fs14 c9">详细地址：</span>
            <span class="fs14 c6">安徽省安庆市安庆长江大桥综合经济开发区</span>
          </p>
        </div>
      </div>
    </div>
            <div class="order-pay-step">
    <p class="order-pay-title">{{trans('common.pay_online')}}</p>
    <p class="p2">{{trans('common.choose_pay')}}</p>
    <div class="order-pay-type">
      <p class="p3">{{trans('common.third_party_payment')}}</p>
            <div class="iBlock">
            @foreach(config('laravel-omnipay.gateways') as $k=>$v)
        <div class="radio-warp">
          <span class="radio @if($k='alipay') cur @endif" data-val="{{$k}}">
            <i class="iconfont wxz icon-unselected3"></i>
            <i class="iconfont xz icon-selected3"></i>
          </span>
          <div class="pay-type-img {{$k}}"></div>
        </div>
        <input class="hide" name="payType" value="alipay">
      @endforeach
            </div>
    </div>
  </div>
    <input class="hide" name="orderId" value="">
  </div>
        <div class="pay-btns">
      <button class="pay-ok" type="submit">{{trans('common.pay_now')}}</button>
    </div>
    </form>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/package-order.js')}}"></script>
@stop