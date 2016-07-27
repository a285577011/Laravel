@extends('layouts.master')
 @section('title',trans('common.order_package_tour'))

 @section('style') @parent
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet"
	type="text/css">
<link href="{{ asset('/css/src/package-tour.css') }}" rel="stylesheet"
	type="text/css">

@stop @section('content')
<section class="package-tour-bg"
	style="background-image: url('../images/package.jpg')">
	<div class="top-search-model">
		<form class="clear" action="{{url('tour/lists')}}">
			<div class="search-condition ts-destination">
				<input placeholder="{{trans('tour.travel_destination')}}" data-state="1" name="" id="city">
				<input type="hidden" value="{{Input::get('destinationId')}}" name="destinationId" id="cityId">
			</div>
			<div class="search-condition ts-begin-time">
				<span>{{trans('tour.departure_day')}}</span> <input class="datePick" placeholder=""
					name="go_date">
			</div>
			<div class="search-condition ts-day">
				<span>{{trans('tour.day')}}</span> <input class="" placeholder="1" name="schedule_days">
			</div>
			<button type="submit" class="ts-submit">{{trans('tour.submit')}}</button>
		</form>
	</div>
</section>

<section class="district">
	<div class="district-list">
	@if($data['islandData'])
	@foreach($data['islandData'] as $k=>$v)
			<div class="district-item" onclick="window.location.href='{{url('tour/lists').'?'.http_build_query(['destinationId'=>$k])}}'">
			<div class="district-img"></div>
			<a href="{{url('tour/lists').'?'.http_build_query(['destinationId'=>$k])}}">
			<p class="district-line">
				<span class="continent">{{$v['name']}}</span>
			</p>

			<p class="district-route">
				<span class="num">{{$v['count']}}</span> {{trans('tour.tiao_travel_xianlu')}} <i class="iconfont icon-right"></i>
			</p>
			</a>
		</div>
	@endforeach
	@endif
	</div>
</section>
<!-- 特别推荐 begin -->
<section class="special-recommend bg-fa">
	<div class="inner-title">
		<p class="p1">ESPECIALLY RECOMMEND</p>

		<div class="line"></div>
		<p class="p2">特别推荐</p>
	</div>
	<div id="box">
		<pre class="prev">prev</pre>
		<pre class="next">next</pre>
		<ul>
		@if($data['recomTour']->count())
		@foreach($data['recomTour'] as $k=>$v)	
			<li><a href="{{$v->url}}"> <img src="@storageAsset($v->image)" />
			</a></li>
		@endforeach
		@endif
		</ul>
	</div>
</section>
<!-- 特别推荐 end -->

<!-- 全球行 begin -->
<section class="global-tour">
	<div class="inner-title">
		<p class="p1">GLOBAL TOUR</p>

		<div class="line"></div>
		<p class="p2">全球行</p>
	</div>
	<div class="global-warp">
		<div class="global-item clear">
			<div class="global-left">
			<img src="{{asset('/images/qqx1.jpg')}}">
			</div>
			<div class="global-right">
		@if($data['newTour1']->count())
		@foreach($data['newTour1'] as $k=>$v)
			<div class="sub @if($k%2==0) pr @endif">
					<a href="{{url('tour/detail').'/'.$v->id}}"><img src="@storageAsset(App\Models\TourToPic::getOnePicByTourId($v->id))"></a>

					<div class="sub-text">
						<span>{{$v->name.'('.$v->days.trans('tour.tian').$v->nights.trans('tour.nights').')'}}</span>
					</div>
				</div>
		@endforeach	
		@endif

			</div>
		</div>
		<div class="global-item clear">
			<div class="global-left">
<img src="{{asset('/images/qqx2.jpg')}}">
			</div>
			<div class="global-right">
		@if($data['newTour2']->count())
		@foreach($data['newTour2'] as $k=>$v)
			<div class="sub @if($k%2==0) pr @endif">
					<a href="{{url('tour/detail').'/'.$v->id}}"><img src="@storageAsset(App\Models\TourToPic::getOnePicByTourId($v->id))"></a>

					<div class="sub-text">
						<span>{{$v->name.'('.$v->days.trans('tour.tian').$v->nights.trans('tour.nights').')'}}</span>
					</div>
				</div>
		@endforeach	
		@endif
			</div>
		</div>
	</div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/package-tour.js')}}"></script>
<script>
  (function () {
    new ZoomPic("box");
    $(document).on("click", ".datePick", function () {
      $(this).datepicker({
        dateFormat:"yy-mm-dd",
        numberOfMonths:2,
        showMonthAfterYear:true,
        showOtherMonths:true
      }).datepicker('show');
    });
    $('.destination-select').on('keyup', function() {
	     $.ajax({
	         type: "GET",
	         url: "{{url('area/search')}}",
	         data: {'name':$(this).val()},
	         beforeSend : function(){
	    },
	             success: function(data){
		             if(data.status){
			             var idStr='';
			             $.each(data.data, function (index, value) {
			            	 idStr+=value+',';
			             })
			             idStr=idStr.substring(0,idStr.length-1);
		                 $('input[name="areaId"]').val(idStr);
		             }     
	             },
	     error: function(){
	     alert("系统繁忙");
	     }
	           });
      });
  })();
</script>
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!App\Models\Area::getSelectJs()!!}
@stop
