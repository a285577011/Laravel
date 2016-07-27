<?php
use App\Helpers\Common;
?>
@extends('layouts.master')
 @section('title',trans('common.order_package_tour'))
@section('navClass','ow-inner-nav') @section('content')
 @section('style') @parent
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet"
	type="text/css">
<link href="{{ asset('/css/src/order.css') }}" rel="stylesheet"
	type="text/css">
	<link href="{{ asset('/css/lib/slick.css') }}" rel="stylesheet"
	type="text/css">
@stop @section('content')
<!-- 进度条 begin -->
<section class="progress-step clear">
  <div class="progress-bar-x1 mr2"></div>
  <div class="progress-bar-x2 mr3"></div>
  <div class="progress-bar-x3 mr5"></div>
  <div class="progress-step-bar progress-step-bar-cur">
    <div class="progress-step-num">1</div>
    <div class="progress-step-text">{{trans('tour.tianxie_order')}}</div>
  </div>
  <div class="progress-step-bar progress-step-bar-cur">
    <div class="progress-step-num">2</div>
    <div class="progress-step-text">{{trans('tour.zaixian_zhifu')}}</div>
  </div>
  <div class="progress-step-bar mr5">
    <div class="progress-step-num">3</div>
    <div class="progress-step-text">{{trans('tour.wancheng_yuding')}}</div>
  </div>
  <div class="progress-bar-x3 mr3"></div>
  <div class="progress-bar-x2 mr2"></div>
  <div class="progress-bar-x1"></div>
</section>
<!-- 进度条 end -->
 <form class="order-write-form" action="{{url('tour/topay')}}" method="post" id="payForm">
 {!! csrf_field() !!}
<section class="order-pay">
  <div class="order-pay-step">
    <p class="order-pay-title">{{trans('common.sure_order')}}</p>
    <div class="order-pay-msg">
      <div class="order-pay-msg-title">
        <span>{{trans('tour.xianlu_xinxi')}}</span>
      </div>
      <p class="p1">{{$tourData['name'].'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')'}}</p>
      <span class="s1">{{trans('tour.departure_city')}}：<span>{{App\Models\Area::getNameById(intval($tourData['leave_area']))}}</span></span>
      <span class="s1">{{trans('tour.adult')}}-{{trans('tour.child').trans('tour.num')}}：<span>{{$adult_num}}-{{$child_num}}</span></span>
      <span class="s1">{{trans('tour.departure_day')}}：<span>{{$departureDate}}</span><span>{{config('tour.week_'.\App::getLocale())[date("w",strtotime($departureDate))]}}</span></span>
      <span class="s1">{{trans('tour.return_day')}}：<span>{{$comeBackDate}}</span><span>{{config('tour.week_'.\App::getLocale())[date("w",strtotime($comeBackDate))]}}</span></span>
    </div>
    <div class="order-pay-msg">
    @foreach($touristData['adult'] as $k=>$v)
    @if($v)
      <div class="order-pay-msg-title">
        <span>{{trans('tour.lvke_xinxi')}}</span>
      </div>
      <p class="s2">{{trans('tour.lvke')}}：{{$v['name']}} {{trans('tour.adult')}} {{config('common.sex')[$v['sex']?:1][\App::getLocale()]}} {{trans('tour.english_xing')}}:{{$v['englishXing']}} {{trans('tour.english_name')}}:{{$v['englishName']}} {{trans('tour.zhengjian_info')}}({{config('tour.zhengjian')[$v['zhengjianType']][\App::getLocale()]}}):{{$v['zhengjian']}} {{trans('tour.birther_day')}}:{{$v['birther_day']}} {{trans('tour.phone')}}:{{$v['phone']}}</p>
      @endif
    @endforeach
    @if(isset($touristData['child']))
        @foreach($touristData['child'] as $k=>$v)
    @if($v)
      <div class="order-pay-msg-title">
        <span>{{trans('tour.lvke_xinxi')}}({{trans('tour.child')}})</span>
      </div>
      <p class="s2">{{trans('tour.lvke')}}：{{$v['name']}} {{trans('tour.child')}} {{config('common.sex')[$v['sex']?:1][\App::getLocale()]}} {{trans('tour.english_xing')}}:{{$v['englishXing']}} {{trans('tour.english_name')}}:{{$v['englishName']}} {{trans('tour.zhengjian_info')}}:{{config('tour.zhengjian')[$v['zhengjianType']][\App::getLocale()]}}:{{$v['zhengjian']}} {{trans('tour.birther_day')}}:{{$v['birther_day']}} {{trans('tour.phone')}}:{{$v['phone']}}</p>
      @endif
    @endforeach
     @endif
    </div>
    <div class="order-pay-msg">
      <div class="order-pay-msg-title">
        <span>{{trans('tour.lianxi_info')}}</span>
      </div>
      <span class="s1">{{trans('tour.name')}}：<span>{{$contactsDate['contact_name']}}</span></span>
      <span class="s1">{{trans('tour.phone')}}：<span>{{$contactsDate['contact_phone']}}</span></span>
      <span class="s1">{{trans('tour.email')}}：<span>{{$contactsDate['contact_email']}}</span></span>
    </div>
    <div class="order-pay-msg">
      <div class="order-pay-msg-title">
        <span>{{trans('tour.fapiao_xinxi')}}</span>
      </div>
      @if($invoiceInfo['invoice']==1)
      <span class="s1">{{trans('tour.xiyao_fapiao')}}：<span>{{trans('tour.yes')}} {{$invoiceInfo['fapiao_taitou']}}</span></span>
      <span class="s1">{{trans('tour.xiangxi_dizhi')}}：<span>{{$invoiceInfo['address']}}</span></span>
      @else
      <span class="s1">{{trans('tour.xiyao_fapiao')}}：<span>{{trans('tour.no')}}</span></span>
      @endif
    </div>
    <p class="order-pay-money">
     {{trans('tour.yinfu_quane')}}:<span>{{Common::getCurrencySymbol()}}{{round(Common::getPriceByValue($totalPrice),2)}}</span>
    </p>
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
  
  <input class="hide" name="orderId" value={{$orderId}}>
      <div class="pay-btns">
      <button class="pay-ok" type="submit">{{trans('common.pay_now')}}</button>
    </div>
</section>
</form>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/package-order.js')}}"></script>
@stop