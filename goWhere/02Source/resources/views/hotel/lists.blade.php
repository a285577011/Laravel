<?php
use App\Helpers\Common;
use App\Models\TourPriceDate;
use App\Models\Area;
?>
@extends('layouts.master')
 @section('title',trans('common.order_hotel'))

 @section('style')
  @parent
<link href="{{ asset('/css/src/hotel-inner.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/css/src/hotel.css') }}">
<link rel="stylesheet" href="{{ asset('/css/lib/jquery.nstSlider.css') }}">
@stop @section('navClass','ow-inner-nav') @section('content')
<section class="hotel-search">
<div class="hotel-search-warp">
<div class="hotel-search-title clear">
  <span class="hotel-search-title-keyWord">热门酒店</span>

  <div class="hotel-search-title-path">
    <a href="index.html">首页</a>
    <i class="iconfont icon-right"></i>
    <a>单项预定</a>
    <i class="iconfont icon-right"></i>
    <a href="hotel.html">酒店</a>
    <i class="iconfont icon-right"></i>
    <span>热门酒店</span>
  </div>
</div>
<div class="hotel-search-main">
  <form  action="{{url('hotel/list')}}" id="hotelSearchForm">
    <div class="form-group">
      <label>{{trans('mice.destinations')}}</label>
        <input id="city" class="l-form-ele need-verify" datatype="*" nullmsg="{{trans('hotel.area_hotel_dibiao')}}" value="{{App\Models\Area::getNameById(Input::get('destination'))}}">
        <input id="cityId" name="destination" type="hidden" value="{{Input::get('destination')}}">
    </div>
    
    <div class="form-group">
      <label>{{trans('hotel.check-in_date')}}</label>
      <input id="dateStart" class="m-input" name="checkin" value="{{Input::get('checkin')}}" readonly>
    </div>
    <div class="form-group">
      <label>{{trans('hotel.check-out_date')}}</label>
      <input id="dateEnd" class="m-input" name="checkout" value="{{Input::get('checkout')}}" readonly>
    </div>
    <div class="form-group">
      <label>{{trans('hotel.guest_room')}}</label>
      <select class="s-input" name="rooms_num">
        @foreach(config('hotel.rooms_num') as $v)
                            @if($v==Input::get('rooms_num'))
         <option value="{{$v}}" selected>{{$v}}</option>
        @else
          <option value="{{$v}}">{{$v}}</option>
          @endif
          @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>{{trans('tour.adult')}}</label>
      <select class="s-input" name="adult">
        @foreach(config('hotel.select_adult_num') as $v)
                  @if($v==Input::get('adult'))
         <option value="{{$v}}" selected>{{$v}}</option>
        @else
          <option value="{{$v}}">{{$v}}</option>
          @endif
          @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>{{trans('tour.child')}}</label>
      <select class="j-select-child s-input" name="child">
      <option value="0">0</option>
        @foreach(config('hotel.select_child_num') as $v)
                 @if($v==Input::get('child'))
         <option value="{{$v}}" selected>{{$v}}</option>
        @else
          <option value="{{$v}}">{{$v}}</option>
          @endif
          @endforeach
      </select>
    </div>
    <div class="clear"></div>
    <input class="child-ages-array hide" name="child_age">
<div class="hotel-search-main-other-condition" style="  -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color:  #e9e9e9 #e9e9e9;
    border-image: none;
    border-style: solid;
    border-width: 0px 0px 1px;">
  <div class="condition-price clear" style="line-height:10px;">
    <div class="condition-price-title">{{trans('tour.price')}}:</div>
    <script id="nstSlider-bar-tpl" type="text/template">
      <div class="nstSlider" data-range_min="0" data-range_max="20000"
           data-cur_min="${minPrice}" data-cur_max="${maxPrice}">

        <div class="bar"></div>
        <div class="leftGrip"></div>
        <div class="rightGrip"></div>
      </div>
      <div class="leftLabel"></div>
      <div class="rightLabel"></div>
    </script>
    <div class="nstSlider-bar">
      <div class="nstSlider" data-range_min="0" data-range_max="1000000"
           data-cur_min="0" data-cur_max="1000000">

        <div class="bar"></div>
        <div class="leftGrip"></div>
        <div class="rightGrip"></div>
      </div>
      <div class="leftLabel"></div>
      <div class="rightLabel"></div>
    </div>
    <div class="price-input">
      <input class="min-price">
      <span></span>
      <input class="max-price">
    </div>
              <button class="hotel-search-main-form-btn">{{trans('tour.submit')}}</button>
  </div>
  <div class="condition-star clear">
    <div class="condition-star-title">{{trans('hotel.star_rated')}}:</div>
    <a href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['star','page'])))}}" class="condition-star-all" style="width: 115px;@if(Input::get('star')) background: #fff none repeat scroll 0 0;color: black; @endif">{{trans('hotel.wuxian')}}</a>
@foreach(config('hotel.starOption') as $k=>$v)
 <a class="condition-star-all" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['star','page']),['star'=>$k]))}}"  style="width: 115px;@if(Input::get('star')!=$k)background: #fff none repeat scroll 0 0;color: black; @endif">
{{trans($v)}}
    </a>
    @endforeach
  </div>
</div>
</form>
</div>
</div>
</section>
<section class="hotel-search-result clear">
  <div class="hotel-search-result-warp clear">
    <div class="hotel-search-result-main fl">
      <div class="hotel-search-result-main-num">
        <span>11180</span>{{trans('hotel.num_hotel_To_meet_the_conditions')}}
      </div>
      <div class="hotel-search-result-main-list">
        <div class="hotel-search-sort clear">
          <a class="default-sort">{{trans('tour.tuijian_paixu')}}</a>
          <ul class="other-sort clear">         
                      <li>
              <span>{{trans('tour.price')}}</span>
              <a class="sort-type cur-sort" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'price-asc']))}}">
                <i class="iconfont icon-up6"></i>
              </a>
              <a class="sort-type" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'price-desc']))}}">
                <i class="iconfont icon-down6"></i>
              </a>
            </li>
            <li>
              <span>{{trans('hotel.star_rated')}}</span>
              <a class="sort-type cur-sort" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'star-asc']))}}">
                <i class="iconfont icon-up6"></i>
              </a>
              <a class="sort-type" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'star-desc']))}}">
                <i class="iconfont icon-down6"></i>
              </a>
            </li>
            <li>
              <span>{{trans('hotel.book_num')}}</span>
              <a class="sort-type cur-sort" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'salenum-asc']))}}">
                <i class="iconfont icon-up6"></i>
              </a>
              <a class="sort-type" href="{{url('hotel/list').'?'.http_build_query(array_merge(Common::getAllGetParams(['sort','page']),['sort'=>'salenum-desc']))}}">
                <i class="iconfont icon-down6"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="hotel-search-sort-result">
          <ul class="hotel-search-sort-result-ul">
          <?php print_r($data);?>
          @if($data)
          @foreach($data as $v)
            <li onclick="window.open('{{url('hotel/detail').'?'.http_build_query(Input::get())}}')" class="hotel-search-sort-result-li" data-num="0">
              <p class="fs12 c6"><span class="fs18 hotel-name main-color">{{$v->name}}</span></p>
              <div class="mt10 clear">
                <img src="../img/hotel01.jpg">
                <div class="hotel-search-sort-result-li-text">
                  <p class="hotelStar">
                  <?php for($i=0;$i<$v->stars;$i++){?>
                    <i class="iconfont icon-star"></i>
                   <?php }?>
                  </p>
                  <p class="fs12 c6 mt10">{{$v->address}}
                  <span class="result-li-map">
                    <i class="iconfont icon-zuobiao"></i>地图
                  </span></p>

                  <p class="fs12 c9 mt10">{{$v->introduction}}</p>
                </div>
                <div class="hotel-search-sort-result-li-other">
                  <p class="fs14 c6"><span class="fs20 main-color">￥899</span>起</p>

                 <!--  - <p class="fs12 c9">20人预定</p>-->
                  <a class="go-look">{{trans('tour.look')}}</a>
                </div>
              </div>
            </li>
            @endforeach
            @endif
          </ul>
        </div>
      </div>
    </div>
    <div class="hotel-search-result-other fl">
      <div id="googleMap" class="hotel-search-result-map">
      </div>
      <div class="hotel-search-result-history">
        <p class="hotel-search-result-history-title">我浏览过的酒店</p>
        <ul>
          <li class="hotel-search-result-history-li clear">
            <img src="../img/hotel01.jpg">

            <div class="hotel-search-result-history-li-text">
              <p class="history-text">Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里)</p>

              <p class="hotelStar mt0">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </p>
            </div>
            <div class="del-hotel-history">
              <i class="iconfont icon-guanbi"></i>
            </div>
          </li>
          <li class="hotel-search-result-history-li clear">
            <img src="../img/hotel01.jpg">

            <div class="hotel-search-result-history-li-text">
              <p class="history-text">Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里)</p>

              <p class="hotelStar mt0">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </p>
            </div>
            <div class="del-hotel-history">
              <i class="iconfont icon-guanbi"></i>
            </div>
          </li>
          <li class="hotel-search-result-history-li clear">
            <img src="../img/hotel01.jpg">

            <div class="hotel-search-result-history-li-text">
              <div class="history-text">Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里)</div>

              <p class="hotelStar mt0">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </p>
            </div>
            <div class="del-hotel-history">
              <i class="iconfont icon-guanbi"></i>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<div class="full-shade hide"></div>
<div class="childs-age-pop hide">
  <p class="p-t">儿童年龄</p>
  <div class="childs-age-warp clear">
    <select class="childs-age-item">
        @foreach(config('hotel.select_child_age') as $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
    </select>
  </div>
  <a class="ca-ok">确定</a>
</div>
<!-- result end -->
@endsection @section('script') @parent













<script src="{{ asset('/js/lib/jquery.nstSlider.js')}}"></script>
<script src="{{ asset('/js/lib/juicer.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.dotdotdot.min.js')}}"></script>
<script src="http://ditu.google.cn/maps/api/js?sensor=false&language=zh-CN&callback=initialize&key=AIzaSyA-qk722H03vsGZO5nakrQlf-KCzZSQ8vE" charset="utf-8" async defer></script>
<script src="{{ asset('/js/src/hotelInner.js')}}"></script>
<script>
var nstSlider = function(){
	  $('.nstSlider').nstSlider({
	    "crossable_handles": false,
	    "left_grip_selector": ".leftGrip",
	    "right_grip_selector": ".rightGrip",
	    "value_bar_selector": ".bar",
	    "value_changed_callback": function(cause, leftValue, rightValue) {
	      $(this).parent().find('.leftLabel').text("{{App\Helpers\Common::getCurrencySymbol()}}"+leftValue);
	      $(".min-price").val(leftValue);
	      $(this).parent().find('.rightLabel').text("{{App\Helpers\Common::getCurrencySymbol()}}"+ rightValue);
	      $(".max-price").val(rightValue);
	    }
	  });
	};
</script>
<script>
  $(function(){
    $(".history-text").dotdotdot();
  })
  /**
 * Created by zds on 2015/12/14.
 */
function initialize() {
  var mapProp = {
    center: new google.maps.LatLng(51.508742, -0.120850),
    zoom: 6,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
  var markersArr = [];
  var infowindowArr = [];
  var markers = {
    "latLng": [
      {
        "num": "0",
        "lat": "52.008742",
        "lng": "-0.120850",
        "marker_blue": "../images/map_marker/map_blue_01.png",
        "marker_cur": "../images/map_marker/map_orange_01.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      },
      {
        "num": "1",
        "lat": "51.508642",
        "lng": "-0.120750",
        "marker_blue": "../images/map_marker/map_blue_02.png",
        "marker_cur": "../images/map_marker/map_orange_02.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      },
      {
        "num": "2",
        "lat": "51.008542",
        "lng": "-0.120650",
        "marker_blue": "../images/map_marker/map_blue_03.png",
        "marker_cur": "../images/map_marker/map_orange_03.png",
        "hotel_name":"国会东京大酒店(The Capitol Hotel Tokyu)",
        "hotel_img":"../img/hotel01.jpg"
      },
    ]
  };

  for (i = 0, len = markers.latLng.length; i < len; i++) {
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(markers.latLng[i].lat, markers.latLng[i].lng),
      icon: markers.latLng[i].marker_blue,
      num: markers.latLng[i].num
    });
    marker.setMap(map);
    var contentString = '<div id="map-tips" class="map-tips clear">' +
      '<img src="' + markers.latLng[i].hotel_img + '">' +
      '<p><span>' + markers.latLng[i].hotel_name +'</span></p>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content:contentString
    });

    infowindowArr.push(infowindow);
    markersArr.push(marker);
    marker.addListener("mouseover", function () {
      var num = $(this)[0].num;
      $(this)[0].setIcon(markers.latLng[num].marker_cur);
      infowindowArr[num].open(map,markersArr[num]);
    });
    marker.addListener("mouseout", function () {
      var num = $(this)[0].num;
      $(this)[0].setIcon(markers.latLng[num].marker_blue);
      infowindowArr[num].close(map,markersArr[num]);
    });
  }

  $(".hotel-search-sort-result-li").mouseenter(function () {
    var num = $(this).data("num");
    var center = new google.maps.LatLng(markers.latLng[num].lat, markers.latLng[num].lng);
    map.setCenter(center);
    markersArr[num].setIcon(markers.latLng[num].marker_cur);

  }).mouseleave(function(){
    var num = $(this).data("num");
    markersArr[num].setIcon(markers.latLng[num].marker_blue);
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!--  <script src="{{ asset('/areaSelect/citylist.js')}}"></script>-->
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!App\Models\Area::getSelectJs()!!}
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
  $(function () {
	$.validator.setDefaults({
		errorElement:'span',
		ignore:""
	});
	
	var cnmsg = {
		required: '<span class="warn"><span class="lgfork"></span>必填项</span>',
		equalTo: '<span class="warn"><span class="lgfork"></span>请再次输入相同的值</span>',
		maxlength: jQuery.format('<span class="warn"><span class="lgfork"></span>最多输入{0}个字符</span>'),
		minlength: jQuery.format('<span class="warn"><span class="lgfork"></span>最少输入{0}个字符</span>'),
		rangelength: jQuery.format('<span class="warn"><span class="lgfork"></span>请输入{0}到{1}个字符</span>'),
		range: jQuery.format('<span class="warn"><span class="lgfork"></span>请输入{0}到{1}之间的值</span>'),
		max: jQuery.format('<span class="warn"><span class="lgfork"></span>请输入小于 {0}的值</span>'),
		min: jQuery.format('<span class="warn"><span class="lgfork"></span>请输入大于 {0}的值</span>'),
		email: jQuery.format('<span class="warn"><span class="lgfork"></span>请输入正确的邮箱</span>'),
	};

	$.extend($.validator.messages, cnmsg);
	jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {
		var length = value.length;
		for (var i = 0; i < value.length; i++) {
			if (value.charCodeAt(i) > 127) {
				length++
			}
		}
		return this.optional(element) || (length >= param[0] && length <= param[1])
	}, '<span class="warn"><span class="lgfork"></span>长度在{0}-{1}之间，请重新输入</span>');
	jQuery.validator.addMethod("weixinOrqq", function(value, element) {
		return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
	}, '<span class="warn"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
	jQuery.validator.addMethod("isMobile", function(value, element) {
		var length = value.length;
		return this.optional(element) || (length == 11 && /^(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/.test(value))
	}, '<span class="warn"><span class="lgexm"></span>请填写正确的手机号</span>');
	$('#hotelSearchForm').validate({
		rules: {
			destination: {
				required: true,
			},
			checkin: {
				required: true,
				date: true
			},
			checkout: {
				required: true,
				date: true
			},
			adult: {
				required: true,
				number: true,
				min:1
				//checkDestinationall: true
			},
			child: {
				required: true,
				number: true,
				min:0
				//checkDestinationall: true
			},
		},
		messages: {
			destination: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.destination')}}"+'</span>',
				//checkDestination:'<span class="warn"><span class="lgexm"></span>不存在该地区</span>',
			},
			checkin: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('hotel.check-in_date').trans('common.must_in')}}"+'</span>',
			},
			checkout: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('hotel.check-out_date').trans('common.must_in')}}"+'</span>',
			},
			adult: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('tour.adult').trans('tour.num').trans('common.must_in')}}"+'</span>',
				min:'<span class="warn"><span class="lgexm"></span>'+"{{trans('tour.adult').trans('tour.num').trans('common.must_bigger_than')}}{0}"+'</span>',
			},
			child: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('tour.child').trans('tour.num').trans('common.must_in')}}"+'</span>',
				min: '<span class="warn"><span class="lgexm"></span>'+"{{trans('tour.child').trans('tour.num').trans('common.must_bigger_than')}}{0}"+'</span>',
			},
		},
		errorPlacement: function(error, element) {
			//layer.msg('aa');
           // element.after(error);
		},
	    invalidHandler: function(form, validator) {
        	//console.log(validator.invalid);
        	//return false;
	        $.each(validator.invalid,function(key,value){
	        	layer.msg(value,{icon: 2});
	            return false;
	        }); //这里循环错误map，只报错第一个
	    },
		success: function(label) {
			label.html('<span class="lgtick"></span>')
		},
		focusInvalid: false,
		onkeyup: false,
    	submitHandler: function(form) {
        	$.ajax({
        	    //async: false,
    			type: "GET",
    	        url: "{{url('area/getarea')}}",
    	        data: {'id':$('input[name="destination"]').val()},
    			success: function(msg) {
    				if(msg.status==1){
    					flag = true;
    					form.submit();
    				}
    				else{
    					flag=false;
    					layer.msg(msg.info,{icon: 2});
    			}
    			},
    		});
  	},
	});
  });
</script>
@stop
