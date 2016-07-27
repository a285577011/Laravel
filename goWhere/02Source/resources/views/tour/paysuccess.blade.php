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
  <div class="progress-step-bar mr5 progress-step-bar-cur">
    <div class="progress-step-num">3</div>
    <div class="progress-step-text">{{trans('tour.wancheng_yuding')}}</div>
  </div>
  <div class="progress-bar-x3 mr3"></div>
  <div class="progress-bar-x2 mr2"></div>
  <div class="progress-bar-x1"></div>
</section>
<!-- 进度条 end -->
<section class="order-success">
  <div class="success-msg">
    <div class="success-mark">
      <i class="iconfont icon-checked"></i>
    </div>
    <p class="p1">{{trans('common.book_success_msg')}}</p>
    <p class="p2">
      <span>{{trans('common.order_num')}}：{{$sno}}</span>
      <a class="view-order" href="{{url('member/order/tour')}}">{{trans('common.look_order')}}</a>
    </p>
    <p class="p2">{{trans('common.pay_success_thanks')}}</p>
  </div>
  <div class="success-order-msg">
    <p class="p1">{{$tourData['name'].'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')'}}</p>
    <span class="s1">{{trans('tour.departure_city')}}：<span>{{App\Models\Area::getNameById(intval($tourData['leave_area']))}}</span></span>
    <span class="s1">{{trans('tour.adult')}}-{{trans('tour.child').trans('tour.num')}}：<span>{{$tourOrderData['adult_num']}}-{{$tourOrderData['child_num']}}</span></span>
    <span class="s1">{{trans('tour.departure_day')}}：<span>{{date('Y-m-d',$tourOrderData['departure_date'])}}</span><span>{{config('tour.week_'.\App::getLocale())[date("w",$tourOrderData['departure_date'])]}}</span></span>
    <span class="s1">{{trans('tour.return_day')}}：<span>{{date('Y-m-d',$tourOrderData['departure_date']+$tourData['schedule_days']*86400)}}</span><span>{{config('tour.week_'.\App::getLocale())[date("w",$tourOrderData['departure_date']+$tourData['schedule_days']*86400)]}}</span></span>
  </div>
</section>

  <section class="other-relevant">
  <div class="other-relevant-warp">
    <div class="other-relevant-options clear">
     <!-- <div class="other-relevant-option other-relevant-option-cur mr100" data-val="hotel">
        <p>{{trans('common.relate_hotels')}}</p>
        <hr>
      </div>-->
      <div class="other-relevant-option" data-val="tour">
        <p>{{trans('common.relate_travel')}}</p>
        <hr>
      </div>
    </div>
    <!--  
    <ul class="hotel-relevant hide">
      <li>
        <a>
          <img src="../img/hotel01.jpg">
          <div class="hotel-relevant-detail">
            <p class="p1">日本 · 科纳礁城堡酒店</p>
            <div class="clear">
              <div class="fl p2">
                <span class="s1">
                  ￥
                <span>999</span>
                </span>
                起订
              </div>
              <div class="fr p2">
                <span>九龙/经济</span>
              </div>
            </div>
          </div>
        </a>
      </li>
    </ul>-->
    <ul class="tour-relevant clear">
    @if($similarTour->count())
    @foreach($similarTour as $k=>$v)
          <li class="clear" onclick="window.open('{{url('tour/detail').'/'.$v->id}}')">
        <img class="mr20" src="@storageAsset(App\Models\TourToPic::getOnePicByTourId($v->id))">
        <div class="tour-relevant-detail">
          <p class="fs18 c3">{{$v['name']}}</p>
          @if($v->destination)
          <?php 
          $string='';
          $arr=explode(',', $v->destination);
          foreach ($arr as $areaId){
              $string.=App\Models\Area::getNameById($areaId).'-';
          }
          ?>
          <p class="fs12 c6"> {{rtrim($string,'-')}}</p>
          @endif
          <p class="fs12 c6 mt15">{!!$v->infoData->simple_route!!}</p>
        </div>
        <div class="tour-relevant-detail-btn">
          <p class="fs12 main-color">{{Common::getCurrencySymbol()}}<span class="fs24">{{floor(Common::getPriceByValue($v['price']))}}</span></p>
          <a class="tour-relevant-btn" >{{trans('tour.look')}}</a>
        </div>
      </li>
    @endforeach
    @endif
    </ul>
  </div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/destinationSelect.js')}}"></script>
<script src="{{ asset('/js/src/package-order.js')}}"></script>
<script>

$(function(){
	$('#departure_date').change(function() {
				var text = $(this).val();
				var returnDate = $('#departure_date').find("option:selected")
						.attr("data-returnDate");
				$('.pt-begin').text(text);
				$('.pt-end').text(returnDate);
			});
});
</script>
@stop
