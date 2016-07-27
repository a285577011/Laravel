@extends('layouts.master')
 @section('title',trans('common.order_hotel'))
  @section('style') @parent
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/css/src/hotel.css') }}" rel="stylesheet" type="text/css">

@stop
@section('content')
<!--<section class="hotel-top-banner">
  <div class="fwzzc"></div>
  <div class="hotel-top-search">
    <form class="hotel-top-search-form clear" style="width: 940px;" action="{{url('hotel/list')}}">
      <input class="hotel-top-search-destination" placeholder="{{trans('hotel.area_hotel_dibiao')}}" id="city">
      <input id="cityId" name="destination" type="hidden">
      <input class="hotel-top-search-time datePick date-pick-start" readonly placeholder="{{trans('hotel.check-in_date')}}" name="checkin">
      <span class="right-icon"><i class="iconfont icon-xiangyou"></i></span>
      <input class="hotel-top-search-time datePick date-pick-end" readonly placeholder="{{trans('hotel.check-out_date')}}" name="checkout">
      <input class="hotel-top-search-room" placeholder="{{trans('tour.adult').trans('tour.num')}}" name="adult" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
       <input class="hotel-top-search-room" placeholder="{{trans('tour.child').trans('tour.num')}}" name="child" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
      <button class="hotel-top-search-form-btn">{{trans('tour.submit')}}</button>
    </form>
  </div>
</section> -->
<section class="hotel-top-banner">
  <div class="banner-grad"></div>
  <div class="banner-search">
    <form class="clear" id="searchForm" action="{{url('hotel/list')}}">
      <div class="form-group">
        <span class="label">{{trans('mice.destinations')}}</span>
        <input id="city" class="l-form-ele need-verify" datatype="*" nullmsg="{{trans('hotel.area_hotel_dibiao')}}">
        <input id="cityId" name="destination" type="hidden">
        <p class="verify-tip"></p>
      </div>
      <div class="form-group mr20">
        <span class="label">{{trans('hotel.check-in_date')}}</span>
        <input id="hFrom" class="m-form-ele need-verify date-pick-start" datatype="*" nullmsg="{{trans('hotel.check-in_date')}}" placeholder="yyyy-mm-dd" readonly name="checkin">
        <p class="verify-tip"></p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('hotel.check-out_date')}}</span>
        <input id="hTo" class="m-form-ele need-verify date-pick-end" datatype="*" nullmsg="{{trans('hotel.check-out_date')}}" placeholder="yyyy-mm-dd" readonly name="checkout">
        <p class="verify-tip"></p>
      </div>
      <div class="form-group mr20">
        <span class="label">{{trans('hotel.guest_room')}}</span>
        <select class="s-form-ele" name="rooms_num">
        @foreach(config('hotel.rooms_num') as $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group mr20">
        <span class="label">{{trans('tour.adult')}}</span>
        <select class="s-form-ele" name="adult">
        @foreach(config('hotel.select_adult_num') as $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <span class="label">{{trans('tour.child')}}</span>
        <select id="childSelect" class="s-form-ele" name="child">
        <option value="0">0</option>
        @foreach(config('hotel.select_child_num') as $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group child-ages hide">
        <span class="label">儿童年龄</span>
        <div class="child-age-items">
          <select class="child-age-item s-form-ele mr20">
        @foreach(config('hotel.select_child_age') as $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="clear"></div>
      <input class="child-ages-array hide" name="child_age">
      <a class="hotel-search">{{trans('tour.submit')}}</a>
    </form>
  </div>
</section>
<section class="special-hotel">
  <div class="special-hotel-warp">
    <div class="special-hotel-header">
      <p class="special-hotel-header-title">{{trans('hotel.CheapHotels')}}</p>

      <p class="special-hotel-header-text">{{trans('hotel.CheapHotelsDesc')}}</p>
      <img class="hotel-shadow" src="../img/hotel-shadow.png">
    </div>
    <div class="special-hotel-main mt10">
      <div class="special-hotel-main-items clear">
        <div class="special-hotel-main-item1">
          <div class="special-hotel-main-item1-left">
            <p class="f16 c3">普吉岛</p>
            <hr/>
            <p class="f16 c3">美爵芭东大酒店</p>

            <p class="hotelStar">
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
            </p>

            <p class="special-hotel-main-item1-left-text">Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。
              酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
              从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...</p>

            <p class="special-price"><span>￥680</span>起</p>
          </div>
          <img class="fr" src="../img/hotel01.jpg">
        </div>
        <div class="special-hotel-main-item1">
          <div class="special-hotel-main-item1-left">
            <p class="f16 c3">普吉岛</p>
            <hr/>
            <p class="f16 c3">美爵芭东大酒店</p>

            <p class="hotelStar">
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
            </p>

            <p class="special-hotel-main-item1-left-text">Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。
              酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
              从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...</p>

            <p class="special-price"><span>￥680</span>起</p>
          </div>
          <img class="fr" src="../img/hotel01.jpg">
        </div>
        <div class="special-hotel-main-item1">
          <div class="special-hotel-main-item1-left">
            <p class="f16 c3">普吉岛</p>
            <hr/>
            <p class="f16 c3">美爵芭东大酒店</p>

            <p class="hotelStar">
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
            </p>

            <p class="special-hotel-main-item1-left-text">Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。
              酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
              从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...</p>

            <p class="special-price"><span>￥680</span>起</p>
          </div>
          <img class="fr" src="../img/hotel01.jpg">
        </div>
        <div class="special-hotel-main-item1">
          <div class="special-hotel-main-item1-left">
            <p class="f16 c3">普吉岛</p>
            <hr/>
            <p class="f16 c3">美爵芭东大酒店</p>

            <p class="hotelStar">
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
              <i class="iconfont icon-star"></i>
            </p>

            <p class="special-hotel-main-item1-left-text">Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。
              酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
              从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...</p>

            <p class="special-price"><span>￥680</span>起</p>
          </div>
          <img class="fr" src="../img/hotel01.jpg">
        </div>
        <div class="special-hotel-main-item2">
          <div class="special-hotel-main-item2-img">
            <img class="block" src="../img/hotel02.jpg">

            <div class="special-hotel-main-item2-zzc">
              <p class="">日本 · 科纳礁城堡酒店</p>

              <div class="mt5 clear">
                <div class="hotelStar2 fl">
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                </div>

                <P class="fr special-price2"><span>￥300</span>起</P>
              </div>
            </div>
          </div>
          <p class="special-hotel-main-item2-text">
            Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
            从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...
          </p>
        </div>
        <div class="special-hotel-main-item2">
          <div class="special-hotel-main-item2-img">
            <img class="block" src="../img/hotel02.jpg">

            <div class="special-hotel-main-item2-zzc">
              <p class="">日本 · 科纳礁城堡酒店</p>

              <div class="mt5 clear">
                <div class="hotelStar2 fl">
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                </div>

                <P class="fr special-price2"><span>￥300</span>起</P>
              </div>
            </div>
          </div>
          <p class="special-hotel-main-item2-text">
            Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
            从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...
          </p>
        </div>
        <div class="special-hotel-main-item2">
          <div class="special-hotel-main-item2-img">
            <img class="block" src="../img/hotel02.jpg">

            <div class="special-hotel-main-item2-zzc">
              <p class="">日本 · 科纳礁城堡酒店</p>

              <div class="mt5 clear">
                <div class="hotelStar2 fl">
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                  <i class="iconfont icon-star"></i>
                </div>

                <P class="fr special-price2"><span>￥300</span>起</P>
              </div>
            </div>
          </div>
          <p class="special-hotel-main-item2-text">
            Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
            从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...
          </p>
        </div>
      </div>
      <div class="special-hotel-main-item3">
        <img class="block fl" src="../img/hotel03.jpg">

        <div class="special-hotel-main-item3-r fr">

          <p class="c3 fs20 mt15">纳礁城堡酒店</p>

          <p class="c6 fs16 mt10">日本·东京</p>

          <p class="hotelStar">
            <i class="iconfont icon-star"></i>
            <i class="iconfont icon-star"></i>
            <i class="iconfont icon-star"></i>
            <i class="iconfont icon-star"></i>
            <i class="iconfont icon-star"></i>
          </p>

          <p class="special-price3"><span>￥300</span>起</p>

          <p class="special-hotel-main-item3-text">Fenice皇宫酒店位于位于佛罗伦萨具有悠久历史的文化中心。酒店距离多尔莫广场，乔托钟楼和乌菲齐美术馆的路程都不超多5分钟。
            从酒店去市政广场，旧桥，美蒂奇教堂，圣罗伦佐市场也是十分便利...</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="explore">
  <div class="explore-warp">
    <div class="explore-header">
      <p class="explore-header-title">{{trans('hotel.tansuo_shijie')}}</p>

      <p class="explore-header-text">{{trans('hotel.tansuo_shijieDesc')}}</p>
      <img class="hotel-shadow" src="../img/hotel-shadow.png">
    </div>
    <div class="explore-main clear">
      <div class="explore-main-item explore-main-item-short mr16 iwrap">
        <img src="../img/explore01.jpg">

        <div class="explore-main-item-place">
          <p>首尔<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-main-item-text float">
          <p class="">城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-long iwrap">
        <img src="../img/explore02.jpg">

        <div class="explore-main-item-place">
          <p>新加坡<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-short mr16 iwrap">
        <img src="../img/explore03.jpg">

        <div class="explore-main-item-place">
          <p>清迈<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-zzc"></div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-middle mr16 iwrap">
        <img src="../img/explore04.jpg">

        <div class="explore-main-item-place">
          <p>普吉岛<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-zzc"></div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-short iwrap">
        <img src="../img/explore05.jpg">

        <div class="explore-main-item-place">
          <p>首尔<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-zzc"></div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-long mr16 iwrap">
        <img src="../img/explore06.jpg">

        <div class="explore-main-item-place">
          <p>首尔<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-zzc"></div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
      <div class="explore-main-item explore-main-item-short iwrap">
        <img src="../img/explore07.jpg">

        <div class="explore-main-item-place">
          <p>首尔<span class="fs14 ml5">共1999家酒店</span></p>

          <p class="explore-enName">SEOUL</p>

          <p class="fs14 mt10">共1999家酒店</p>
        </div>
        <div class="explore-zzc"></div>
        <div class="explore-main-item-text float">
          <p>城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍城市旅游景点介绍</p>

          <div>去看看</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/placeholder.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.dotdotdot.min.js')}}"></script>
<script src="{{ asset('/js/src/hotel.js')}}"></script>
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!App\Models\Area::getSelectJs()!!}
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
  $(function () {
	  $('.hotel-search').click(function(){
		
$('#searchForm').submit();
		  });
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
	$('#searchForm').validate({
		rules: {
			destination: {
				required: true,
			},
			checkin: {
				//required: true,
				//date: true
			},
			checkout: {
				//required: true,
				//date: true
			},
			adult: {
				//required: true,
				//number: true,
				//min:1
				//checkDestinationall: true
			},
			child: {
				//required: true,
				//number: true,
				//min:0
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