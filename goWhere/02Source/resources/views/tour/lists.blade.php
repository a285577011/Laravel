<?php
use App\Helpers\Common;
use App\Models\TourPriceDate;
use App\Models\Area;
?>
@extends('layouts.master')
 @section('title',trans('common.order_package_tour'))

 @section('style')
  @parent
<link href="{{ asset('/css/src/package-tour-list.css') }}"
	rel="stylesheet" type="text/css">
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet"
	type="text/css">
	<style>
	.pagination {
    float: right;
    margin-top: 30px;
}
.pagination a, .pagination span {
    border: 1px solid #dfdfdf;
    color: #666;
    cursor: pointer;
    float: left;
    font-size: 14px;
    height: 35px;
    line-height: 33px;
    text-align: center;
    width: 35px;
}
.pagination a:hover, .pagination span:hover {
    border-color: #f58220;
    color: #f58220;
}
.pagination .current {
    border-color: #f58220;
    color: #f58220;
}
.pagination .current.prev, .pagination .current.next {
    border-color: #eee;
    color: #eee;
    cursor: not-allowed;
}
.pagination .prev, .pagination .next {
    margin: 0 10px;
    width: 70px;
}
.pagination .prev i, .pagination .next i {
    font-size: 12px;
}
	</style>
@stop @section('navClass','ow-inner-nav') @section('content')
<!--面包屑 begin -->
<section class="inner-crumbs">
	@if($areaId) <span class="main-crumbs">{{Area::getNameById($areaId)}}</span>
	@endif
	<div class="crumbs-items iBlock">
		<a href="{{url('/')}}" class="f-crumbs">{{trans('common.home')}}</a> <a
			href="{{url('tour/index')}}">{{trans('tour.gentuanyou')}}</a>
    <?php
    $parentId = App\Models\Area::getParentId(intval($areaId));
    ?>
    @if($parentId)
    <a href="{{url('tour/lists').'?'.http_build_query(['destinationId'=>$parentId])}}">{{App\Models\Area::getNameById($parentId)}}</a>
	@endif
	</div>
</section>
<!--面包屑 end-->
<!-- search begin -->
<section class="package-tour-search-warp">
	<form class="clear" action="{{url('tour/lists')}}">
		<div class="group">
			<label>{{trans('tour.travel_destination')}}</label> <input id="city"
				class="l-input destination-select" data-state="1" name="" value="{{$areaId?Area::getNameById($areaId):''}}">
				<input type="hidden" value="{{Input::get('destinationId')}}" name="destinationId" id="cityId">
		</div>
		<div class="group">
			<label>{{trans('tour.departure_day')}}</label> <input
				value="{{Input::get('go_date')}}" class="l-input datePick"
				name="go_date">
		</div>
		<div class="group">
			<label>{{trans('tour.schedule_days')}}</label> <input
				value="{{Input::get('schedule_days')}}" name="schedule_days"
				class="s-input" onkeyup="this.value=this.value.replace(/\D/g,'')"
				onafterpaste="this.value=this.value.replace(/\D/g,'')">
		</div>
	<!--	<div class="group">
			<label>{{trans('tour.adult')}}</label> <input
				value="{{Input::get('adult')}}" name="adult" class="s-input"
				onkeyup="this.value=this.value.replace(/\D/g,'')"
				onafterpaste="this.value=this.value.replace(/\D/g,'')">
		</div>
		<div class="group">
			<label>{{trans('tour.child')}}</label> <input
				value="{{Input::get('child')}}" name="child" class="s-input"
				onkeyup="this.value=this.value.replace(/\D/g,'')"
				onafterpaste="this.value=this.value.replace(/\D/g,'')">
		</div>
		-->
		<div class="group">
			<button>{{trans('tour.submit')}}</button>
		</div>
	</form>
	<div class="other-condition">
		<label class="">{{trans('tour.departure_city')}}：</label>
		<ul class="clear j-condition">
			@if($leaveCity)
			<a
				href="{{url('tour/lists').'?'.http_build_query(Common::getAllGetParams(['leave_area','page']))}}">
				<li data-val="all"
				@if(!Input::get('leave_area')) style="background-color: #f58220; color: #fff;"
				@endif><span>{{trans('tour.buxian')}}</span></li>
			</a> @foreach($leaveCity as $k=>$v)
			<a
				href="{{url('tour/lists').'?'.http_build_query(array_merge(Common::getAllGetParams(['leave_area','page']),['leave_area'=>$v]))}}">
				<li data-val="all" @if(Input::get('leave_area')==$v)
				style="background-color: #f58220; color: #fff;" @endif><span>{{App\Models\Area::getNameById(intval($v))}}</span>
			</li>
			</a> @endforeach @endif
		</ul>
	</div>
	<div class="other-condition no-bottom-line">
		<label class="">{{trans('tour.schedule_days')}}：</label>
		<ul class="clear">
			@if($scheduleDays)
			<a
				href="{{url('tour/lists').'?'.http_build_query(Common::getAllGetParams(['schedule_days','page']))}}">
				<li
				@if(!Input::get('schedule_days')) style="background-color: #f58220; color: #fff;"
				@endif><span>{{trans('tour.buxian')}}</span></li>
			</a> @foreach($scheduleDays as $k=>$v)
			<a
				href="{{url('tour/lists').'?'.http_build_query(array_merge(Common::getAllGetParams(['schedule_days','page']),['schedule_days'=>$v]))}}">
				<li @if(Input::get('schedule_days')==$v)
				style="background-color: #f58220; color: #fff;" @endif><span>
        {{config('tour.schedule_days_'.\App::getLocale())[$v]}}</span></li>
			</a> @endforeach @endif
		</ul>
	</div>
</section>
<!-- search end -->

<!-- result begin -->
<section class="package-tour-result">
	<div class="total-result">
		<span>{{$data->count()}}</span>{{trans('tour.tiao_travel_xianlu')}}
	</div>
	<div class="search-result">
		<div class="search-sort clear">
			<div class="default-sort sort-item sort-cur">
				<span>{{trans('tour.tuijian_paixu')}}</span>
			</div>
			<a
				href="{{url('tour/lists').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'day-'.($order['daySort']?:'desc')]))}}">
				<div class="dayNum-sort sort-item">
					<span>{{trans('tour.day')}}</span>
					<div class="sort-icon">
						<i class="iconfont icon-up sort-up" @if($order['daySort']==
							'desc')style="color: #f58220;" @endif></i> <i
							class="iconfont icon-xiala sort-down" @if($order['daySort']==
							'asc') style="color: #f58220;" @endif></i>
					</div>
				</div>
			</a> <a
				href="{{url('tour/lists').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'salenum-'.($order['salenumSort']?:'desc')]))}}">
				<div class="dayNum-sort sort-item">
					<span>{{trans('tour.xiaoliang')}}</span>
					<div class="sort-icon">
						<i class="iconfont icon-up sort-up" @if($order['salenumSort']==
							'desc')style="color: #f58220;" @endif></i> <i
							class="iconfont icon-xiala sort-down" @if($order['salenumSort']==
							'asc')style="color: #f58220;" @endif></i>
					</div>
				</div>
			</a> <a
				href="{{url('tour/lists').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'price-'.($order['priceSort']?:'desc')]))}}">
				<div class="dayNum-sort sort-item">
					<span>{{trans('tour.price')}}</span>
					<div class="sort-icon">
						<i class="iconfont icon-up sort-up" @if($order['priceSort']==
							'desc')style="color: #f58220;" @endif></i> <i
							class="iconfont icon-xiala sort-down" @if($order['priceSort']==
							'asc')style="color: #f58220;" @endif></i>
					</div>
				</div>
			</a>
			<div class="input-sort">
				<input name="startPrice" value="{{Input::get('startPrice')}}"
					onkeyup="this.value=this.value.replace(/\D/g,'')"
					onafterpaste="this.value=this.value.replace(/\D/g,'')"> <span>-</span>
				<input name="endPrice" value="{{Input::get('endPrice')}}"
					onkeyup="this.value=this.value.replace(/\D/g,'')"
					onafterpaste="this.value=this.value.replace(/\D/g,'')"> <a
					class="sort-btn" onclick="searchPrice();">{{trans('tour.submit')}}</a>
			</div>
		</div>
		<ul class="search-sort-result clear">
			@if($data->count()) @foreach($data as $v)
			<li onclick="window.open('{{url('tour/detail').'/'.$v->id}}')"><img
				src="@storageAsset(App\Models\TourToPic::getOnePicByTourId($v->id))">
				<div class="result-content">
					<p class="p-t">{{$v->name.'('.$v->days.trans('tour.tian').$v->nights.trans('tour.nights').')'}}</p>
					<div class="clear">
						<div class="rc-left">
						               <?php
            $leave_area = '';
            $areaArray=explode(',', $v->leave_area);
            if($areaArray){
                foreach ($areaArray as $areaId){
                    $leave_area.=App\Models\Area::getNameById($areaId).',';
                }
            }
            ?>
							<p class="rc-1">{{rtrim($leave_area,',')}}{{trans('tour.chufa')}}</p>
							{!!isset($v->infoData->route_feature)?$v->infoData->route_feature:''!!}
							<p class="rc-2">{{trans('tour.departure_day')}}：
               <?php
            $string = '';
            $tourPriceDate = TourPriceDate::getByTourAndDate($v->id, strtotime(date('Y-m-d', strtotime("+{$v->advance_day} days"))),3);
            // Common::sqlDump();
            // print_r(App\Models\TourPriceDate::getDateById($v->id));die;
            if($tourPriceDate){
            foreach ($tourPriceDate as $k => $vs) {
                $string .= $k . '/';
             }
            }
            ?>
                <span> {{rtrim($string,'/')}}</span>
							</p>
						</div>
						<div class="rc-right">
							<div class="rc-price">
								<span class="rc-s"> {{Common::getCurrencySymbol()}} </span> <span>{{Common::getPriceByValue($v->price)}}</span>
								<span class="rc-s">{{trans('tour.up')}}</span>
							</div>
							<a class="rc-turn">
								{{trans('tour.look')}} </a>
						</div>
					</div>
				</div></li> 
				@endforeach {!! with(new
			App\Extensions\Page\CustomPaginationLinks($paginator->appends(Input::get())))->render()!!}
			@else  @endif
		</ul>
	</div>
</section>
<!-- result end -->
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/pt-list.js')}}"></script>
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
  function searchPrice(){
      var startPrice=$('input[name="startPrice"]').val();
      var endPrice=$('input[name="endPrice"]').val();
      
      var url = changeURLArg(window.location.href,'startPrice',startPrice);
      url = changeURLArg(url,'endPrice',endPrice);
      url = changeURLArg(url,'page','');
      window.location.href=url;

	  }
  function changeURLArg(url,arg,arg_val){	 
	  	    var pattern=arg+'=([^&]*)';
	  	    var replaceText=arg+'='+arg_val;
	  	    if(url.match(pattern)){
	  	        var tmp='/('+ arg+'=)([^&]*)/gi';
	  	        tmp=url.replace(eval(tmp),replaceText);	
	  	        return tmp;	
	  	    }else{
	  	        if(url.match('[\?]')){
	  	            return url+'&'+replaceText;	 
	  	        }else{	
	  	            return url+'?'+replaceText;	
	  	        }	 
	  	    }	 
	  	    return url+'\n'+arg+'\n'+arg_val;
	
	  	}
</script>
<!--  <script src="{{ asset('/areaSelect/citylist.js')}}"></script>-->
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<script src="{{ asset('/areaSelect/pt-list.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!Area::getSelectJs()!!}
@stop
