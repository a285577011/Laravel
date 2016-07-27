<?php
use App\Helpers\Common;
use App\Models\Area;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
?>
@extends('layouts.master')
 @section('title',trans('common.order_package_tour'))

 @section('style') @parent
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet"
	type="text/css">
  <link rel="stylesheet" href="{{ asset('/css/lib/jquery.ad-gallery.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/src/package-tour-detail.css') }}">
@stop 
@section('navClass','ow-inner-nav')
@section('content')
<!--面包屑 begin -->
<section class="inner-crumbs">
  <div class="crumbs-items iBlock">
    <a class="f-crumbs" href="{{url('/')}}">{{trans('common.home')}}</a>
    <a href="{{url('tour/index')}}">{{trans('tour.gentuanyou')}}</a>
    <a href="{{url('tour/lists').'?'.http_build_query(['leave_area'=>$data['tour']['leave_area']])}}">{{App\Models\Area::getNameById(intval($data['tour']['leave_area']))}}</a>
    <a href="javascript:void(0)">{{$data['tour']['name']}}</a>
  </div>
</section>
<!--面包屑 end-->

<!-- detail begin -->
<section class="package-tour-detail-warp">
  <p class="pt-title">{{$data['tour']['name'].'('.$data['tour']['days'].trans('tour.tian').$data['tour']['nights'].trans('tour.nights').')'}}</p>
  <div class="clear">
    <div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
          @if($data['tour_to_pic'])
          @foreach($data['tour_to_pic'] as $v)
          <li>
              <a href="@storageAsset($v)">
                <img src="@storageAsset($v)" class="image0">
              </a>
            </li>
          @endforeach 
          @endif
          </ul>
        </div>
      </div>
    </div>
    <div class="pt-msg">
      <p class="p1">
        <span class="label">{{trans('tour.departure_city')}}:</span>
        						               <?php
            $leave_area = '';
            $areaArray=explode(',', $data['tour']['leave_area']);
            if($areaArray){
                foreach ($areaArray as $areaId){
                    $leave_area.=App\Models\Area::getNameById($areaId).',';
                }
            }
            ?>
        <span>{{rtrim($leave_area,',')}}</span>
      </p>
      <p class="p1">
        <span class="label">{{trans('tour.schedule_days')}}:</span>
        <span>{{$data['tour']['schedule_days']}}{{trans('tour.tian')}}</span>
      </p>
      <!--  <p class="p1">
        <span class="label">{{trans('tour.departure_day')}}:</span>
                        <?php
            $string = '';
            // Common::sqlDump();
            // print_r(App\Models\TourPriceDate::getDateById($v->id));die;
            $PriceDate = App\Models\TourPriceDate::getByTourAndDate($data['tour']['id'], strtotime(date('Y-m-d', strtotime("+{$data['tour']['advance_day']} days"))),3);
            if($PriceDate){
            foreach ($PriceDate as $k => $vs) {
                $string .= $k . ' ';
             }
            }
            ?>
        <span>{{rtrim($string,' ')}}</span>
      </p>-->
      @if($data['tour_info']->simple_route)
      <p class="p1">
        <span class="label">{{trans('tour.simple_route')}}:</span>
        <span>{!!$data['tour_info']->simple_route!!}</span>
      </p>
      @endif
      <div class="pt-price">
        <span class="mc">{{Common::getCurrencySymbol()}}</span>
        <span class="pt-b mc pt-adult">{{Common::getPriceByValue($priceArr['price'])}}</span>
        <span class="mc">{{trans('tour.up')}}/{{trans('tour.ren')}}</span>
        <span>({{trans('tour.child')}}{{Common::getCurrencySymbol()}}<span class="pt-child">{{Common::getPriceByValue($priceArr['child_price'])}}</span>)</span>
        <!--  <a>{{trans('tour.qijia_shuoming')}}</a>-->
      </div>
      <div class="itinerary-features">
        <p class="p-t">{{trans('tour.xingchengtese')}}</p>
        {!!$data['tour_info']->route_feature!!}
      </div>
    </div>
  </div>
  <form action="{{url('tour/booknext')}}" method="POST" id="bookForm">
  <div class="clear">
    <div class="pt-calendar"></div>
    <div class="pt-order">
      <div class="pt-order-item">
        <span class="label">{{trans('tour.departure_day')}}</span>
        <select class="pt-order-time" name="departure_date" id="departure_date">
        @if($tourPriceDate)
        @foreach($tourPriceDate as $k=>$v)
        <option data-begin="{{$k}}" data-end="{{date('Y-m-d',strtotime($k)+(($data['tour']->schedule_days-1)*86400))}}" data-ap="{{Common::getPriceByValue($v['price'],false)}}" data-cp="{{Common::getPriceByValue($v['child_price'],false)}}" value="{{$k}}" data-returnDate="{{date('Y-m-d',strtotime($k)+(($data['tour']->schedule_days-1)*86400))}}">{{$k.' '.config('tour.week_'.\App::getLocale())[date("w",strtotime($k))]}}</option>
        @endforeach
        @endif
        </select>
        <span class="pt-begin"><span class="time">{{$defaultDate}}</span>{{trans('tour.chufa')}}</span>
        <span class="pt-end"><span class="time">{{date('Y-m-d',strtotime($defaultDate)+(($data['tour']->schedule_days-1)*86400))}}</span>{{trans('tour.return')}}</span>
      </div>
      <div class="pt-order-item">
        <span class="label">{{trans('tour.schedule_renshu')}}</span>
        <div class="pt-num">
          <div class="minus changeAdultNum">-</div>
          <div class="adult num" data-num="0" data-type="adult">0</div>
          <div class="add changeAdultNum">+</div>
          <span>{{trans('tour.adult')}}</span>
        </div>
        <div class="pt-num">
          <div class="minus changeChildNum">-</div>
          <div class="child num" data-num="0" data-type="child" >0</div>
          <div class="add changeChildNum">+</div>
          <span>{{trans('tour.child')}}</span>
        </div>
        <input type="hidden" name="adult_num" value="0">
        <input type="hidden" name="child_num" value="0">
      </div>
      <div class="pt-order-item">
        <span class="label">{{trans('tour.total')}}</span>
        <span class="pt-order-price">{{Common::getCurrencySymbol()}}<span>0</span></span>
        <div class="order-ok">{{trans('tour.booksnow')}}</div>
      </div>
    </div>
  </div>
  {!! csrf_field() !!}
  <input type="hidden" name="tour_id" value="{{$id}}">
  </form>
  <div class="pt-arrange">
    <div class="tab clear">
            <?php $remark=json_decode($data['tour_info']->remark)?>
      <a class="tab-cur" href="#route">{{trans('tour.cankao_xingchneg')}}</a>
      @if($remark&&($remark->feeIncludes||$remark->feeNot))<a href="#fee">{{trans('tour.feiyong_shuoming')}}</a>@endif
      @if($remark&&$remark->preferentialPolicy)
      <a href="#bookings">{{trans('tour.yuding_xuzhi')}}</a>
      @endif
      @if($remark&&$remark->cancelPolicy)
      <a href="#visa">{{trans('tour.qianzheng_xinxi')}}</a>
      @endif
      @if($remark&&$remark->noteMatter)
      <a href="#notice">{{trans('tour.zhuyi_shixian')}}</a>
      @endif
    </div>
    <div class="tab-contain">
      <div id="route" class="route tab-item">
        <div class="tab-title">
          {{trans('tour.cankao_xingchneg')}}
        </div>
        <div class="clear">
          <ul class="route-date">
          @if($data['tour_to_travel'])
          @foreach($data['tour_to_travel'] as $k=>$v)
            <li @if($k==0) class="cur" @endif data-id="route{{$k+1}}">@if(\App::getLocale()=='zh_cn')第@endif{{$v['day']}}{{trans('tour.tian')}}</li>
          @endforeach
          @endif
          </ul>
          <div class="route-date-contain">
          @if($data['tour_to_travel'])
          @foreach($data['tour_to_travel'] as $k=>$v)
                        <div class="date-list" id="route{{$k+1}}">
              <div class="dl-line dl-item">
                <span class="s1">D{{$v['day']}}</span>
                <div class="dl-text">
                <?php 
                $string=$destinationStr='';
               //$destinationStr.=Area::getNameById($v['area']);
                if($v['area']){
                    if ($v['destination']) {
                        $newArr = [];
                        $array = explode(',', $v['destination']);
                        foreach ($array as $vc) {
                            $newArr[] = Area::getNameById($vc);
                        }
                        $destinationStr= '-'.implode('-', $newArr);
                    }
                    $areaArr=explode(',', $v['area']);
                    foreach ($areaArr as $k=>$areaId){
                        $string.=Area::getNameById($areaId).$destinationStr.'</br>';
                    }
                }
                ?>
                  <span class="s2">{!!$string!!}</span>
                </div>
              </div>
              <?php $desc=json_decode($v['desc']); ?>
              @if(isset($desc->jihe)&&$desc->jihe)
               <div class="collection-time dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-muster"></i>
                </div>
                <div class="dl-text">
                      {!!isset($desc->jihe)?$desc->jihe:''!!}
                </div>
              </div>
              @endif
              @if(isset($desc->jiaotong)&&$desc->jiaotong)
              <div class="traffic dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-car1"></i>
                </div>
                <div class="dl-text">
                  <p class="p1">{{trans('tour.jiaotong')}}</p>
                  <div class="dl-text-sub">
                  {!!isset($desc->jiaotong)?$desc->jiaotong:''!!}
                  </div>
                </div>
              </div>
              @endif
              @if(isset($desc->jingdian)&&$desc->jingdian)
              <div class="scenic-spot dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-travel"></i>
                </div>
                <div class="dl-text">
                  <span class="s2">景点： {!!isset($desc->jingdian)?$desc->jingdian:''!!}</span>
                </div>
              </div>
              @endif
              @if(isset($desc->xingcheng_jieshao)&&$desc->xingcheng_jieshao)
              <div class="tour-itinerary dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-summary"></i>
                </div>
                <div class="dl-text">
                  <p class="p1">{{trans('tour.xingcheng_jieshao')}}</p>
{!!isset($desc->xingcheng_jieshao)?$desc->xingcheng_jieshao:''!!}
                </div>
              </div>
              @endif
              @if(isset($desc->cangyin)&&$desc->cangyin)
              <div class="catering dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-norm"></i>
                </div>
                <div class="dl-text">
                  <span class="p1">{{trans('tour.cangyin')}}：{!!isset($desc->cangyin)?$desc->cangyin:''!!}</span>
                </div>
              </div>
              @endif
               @if(isset($desc->zhusu)&&$desc->zhusu)
              <div class="catering dl-item">
                <div class="dl-icon">
                  <i class="iconfont icon-stay"></i>
                </div>
                <div class="dl-text">
                  <p class="p1">{{trans('tour.zhusu_xinxi')}}</p>
                  <p class="p2">{!!isset($desc->zhusu)?$desc->zhusu:''!!}</p>
                </div>
              </div>
               @endif
            </div>
          @endforeach
          @endif
          </div>
        </div>
      </div>
       @if($remark&&($remark->feeIncludes||$remark->feeNot))
      <div id="fee" class="fee tab-item">
        <div class="tab-title">
       {{trans('tour.feiyong_shuoming')}}
        </div>
        @if($remark&&$remark->feeIncludes)
        <div class="tab-text">
          <p class="p1">【{{trans('tour.feiyong_baohan')}}】</p>
{!!$remark?$remark->feeIncludes:""!!}
        </div>
        @endif
         @if($remark&&$remark->feeNot)
        <div class="tab-text">
          <p class="p1">【{{trans('tour.feiyong_buhan')}}】</p>
{!!$remark?$remark->feeNot:''!!}
        </div>
        @endif
      </div>
      @endif
      @if($remark&&$remark->preferentialPolicy)
      <div id="bookings" class="bookings tab-item">
        <div class="tab-title">
          {{trans('tour.yuding_xuzhi')}}
        </div>
{!!$remark?$remark->preferentialPolicy:config('tour.preferentialPolicy')[0]!!}
      </div>
      @endif
      @if($remark&&$remark->cancelPolicy)
      <div id="visa" class="visa tab-item">
        <div class="tab-title">
          {{trans('tour.qianzheng_xinxi')}}
        </div>
{!!$remark?$remark->cancelPolicy:''!!}
      </div>
      @endif
      @if($remark&&$remark->noteMatter)
         <div id="notice" class="visa tab-item">
        <div class="tab-title">
          {{trans('tour.zhuyi_shixian')}}
        </div>
{!!$remark?$remark->noteMatter:''!!}
      </div>
      @endif
    </div>
  </div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/destinationSelect.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.ad-gallery.js')}}"></script>
<script src="{{ asset('/js/src/zzsc.js')}}"></script>
<script src="{{ asset('/js/src/package.tour.calendar.js')}}"></script>
<script src="{{ asset('/js/src/pt-detail.js')}}"></script>
<script>
//addAdultPrice(parseInt('{{floor(Common::getPriceByValue($data['tour']->price))}}'),'{{Common::getCurrencySymbol()}}');
//minusAdultPrice(parseInt('{{floor(Common::getPriceByValue($data['tour']->price))}}'),'{{Common::getCurrencySymbol()}}');
//addChildPrice(parseInt('{{floor(Common::getPriceByValue($data['tour']->child_price))}}'),'{{Common::getCurrencySymbol()}}');
//minusChildPrice(parseInt('{{floor(Common::getPriceByValue($data['tour']->child_price))}}'),'{{Common::getCurrencySymbol()}}');
//add();
//minus();
$('.order-ok').click(function() {
	var tour_id='{{$id}}';
	var departure_date=$('#departure_date').val();
	var child_num=$('.child').text();
	var adult_num=$('.adult').text();
	  $.ajax({
	         type: "POST",
	         url: "{{url('tour/bookcheck')}}",
	         //async: false,
	         data: {'tour_id':tour_id,'adult_num':adult_num,'child_num':child_num,'departure_date':departure_date,'_token':'{{csrf_token()}}'},
	         beforeSend : function(){
	    },
	             success: function(data){
		             if(data.status==1){
		            	 $('#bookForm').submit();
		            	// window.location.href='{{url('tour/booknext')}}?tour_id='+tour_id+'&adult_num='+adult_num+'&child_num='+child_num+'&departure_date='+departure_date;
			             }
		             else if(data.status==-1){
		            	 $('#goLogin').trigger("click"); 
			             }
		             else{
		            	 layer.msg(data.info,{icon: 2});
			             }
	             },
	     error: function(error){
		     console.log(error);
	     alert("系统繁忙");
	     }
	           });
});

(function () {
  $(document).ptCal({
      data:{!!$tourPriceDateJson!!},
  showMaxMonth:{{$showMaxMonth}}
      });
	$('.changeAdultNum').click(function() {
	      var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
	     // var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
		$('input[name="adult_num"]').val(adultNum);
		//$('input[name="child_num"]').val(adultNum);

			});
	$('.changeChildNum').click(function() {
	      //var adultNum = parseInt($(".num[data-type='adult']").attr("data-num"));
	      var childNum = parseInt($(".num[data-type='child']").attr("data-num"));
		//$('input[name="adult_num"]').val(adultNum);
		$('input[name="child_num"]').val(childNum);

			});
})();
</script>
@stop
