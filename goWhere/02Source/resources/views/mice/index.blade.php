<?php
use function GuzzleHttp\json_decode;
use App\Models\Area;
use App\Models\MiceCases;
?>
@extends('layouts.master')
 @section('title',trans('index.mice'))

 @section('style') @parent
<link href="{{ asset('/font/iconfont.css') }}" rel="stylesheet"
	type="text/css">
<link href="{{ asset('/css/src/select2.css') }}" rel="stylesheet"
	type="text/css">
<link href="{{ asset('/css/src/place-select.css') }}" rel="stylesheet"
	type="text/css">
<link href="{{ asset('/css/src/ow-mice.css') }}" rel="stylesheet"
	type="text/css">

@stop @section('content')
<section class="ow-mice-bg">
	<div class="gradual-bg"></div>
	<div class="section-warp">
		<div class="ow-mice-form-warp">

			<form class="clear" id="simple-need" method="post" action="{{url('mice/addneeds')}}">
				<div class="group destination fl">
				{!! csrf_field() !!}
					<label>{{trans('mice.destinations')}}</label> <input class="" data-state="1"
						name="destination" value="" id="city"> 
						<input type="hidden" value="" name="destinationId" id="cityId">
						<i class="iconfont icon-search"></i>
				</div>
				<div class="group nnt fl">
					<label>{{trans('mice.renshu')}}</label> 
					
					<select id="peopleNum">
					@foreach(config('mice.people_num') as $k=>$v)
					<option value="{{$k}}">{{trans($v)}}</option>
					@endforeach
					</select>
					<!--          <input>
          <i class="iconfont icon-down"></i>-->
				</div>
				<div class="group budget fl">
					<label>{{trans('common.budget')}}</label> <select id="budget">
					@foreach(config('mice.budget') as $k=>$v)
					<option value="{{$k}}">{{trans($v)}}</option>
					@endforeach
					</select>
					<!--          <input class="">
          <i class="iconfont icon-down"></i>-->
					<span class="tip">{{trans('mice.yuan/ren')}}</span>
				</div>
				<div id="demand" class="group demand fl">
					<label>{{trans('mice.needs')}}</label>
					<ul class="clear">
						<li class="fl" data-demand="1">
						<span> <i class="iconfont icon-unselected3 wxz"></i> 
						<i class="iconfont icon-selected3 xz"></i>
						</span> 
						<span>{{trans('mice.travel')}}</span>
						</li>
						<li class="fl" data-demand="2"><span> 
						<i class="iconfont icon-unselected3 wxz"></i> 
						<i class="iconfont icon-selected3 xz"></i>
						</span> 
						<span>{{trans('mice.travel')}} + {{trans('mice.active')}}</span>
						</li>
					</ul>
					<input class="hide">
				</div>
				<div class="group fName fl">
					<label>{{trans('tour.name')}}</label> <input class="" name="name">
				</div>
				<div class="group tel fl">
					<label>{{trans('mice.telphone')}}</label> <input class="" name="phone">
				</div>
				<div class="btns fl">
					<button type="button" id="simpleButton">{{trans('common.submit')}}</button>
					<a class="preciseAdvisory">{{trans('mice.jinquezixun')}}</a>
				</div>
			</form>
		</div>
	</div>
	<div class="precise-advisory hide">
		<form id="all-need" method="post" action="{{url('mice/addneedsall')}}">
			<div class="ow-close">
				<i class="iconfont icon-close2"></i>
			</div>
			<p class="title">{{trans('mice.jinquezixun')}}</p>
			<div class="hr1"></div>
			<div class="group destination">
				<label>{{trans('mice.destinations')}}</label> <input class="long destination-select"
					data-state="1" name="allDestination" id="allCity"> 
					<input type="hidden" value="" name="allDestinationId" id="allCityId">
					<i class="iconfont icon-search"></i>
			</div>
			<div class="group goTime">
				<label>{{trans('tour.departure_day')}}</label> <input class="middle datePick" name="departure_date" readonly> <i
					class="iconfont icon-date"></i>
			</div>
			<div class="group day">
				<label>{{trans('mice.travel_days')}}</label> <input class="short" name="duration" value="1"> <span class="plusDay"> <i
					class="iconfont icon-up2"></i>
				</span> <span class="minusDay"> <i class="iconfont icon-down2"></i>
				</span> <span class="tip">天</span>
			</div>
			<div class="group">
				<label>{{trans('mice.xianmu_leixing')}}</label> 				
				<select id="allType" class="long">
					@foreach(config('mice.need_type') as $k=>$v)
					@if($k!=1&&$k!=2)
					<option value="{{$k}}">{{trans($v)}}</option>
					@endif
					@endforeach
					</select>
			</div>
			<div class="group">
				<label>{{trans('mice.renshu')}}</label>
					<select id="allPeopleNum" class="middle">
					@foreach(config('mice.people_num') as $k=>$v)
					<option value="{{$k}}">{{trans($v)}}</option>
					@endforeach
					</select>
			</div>
			<div class="group">
				<label>{{trans('common.budget')}}</label>
				 <select id="allBudget" class="short">
					@foreach(config('mice.budget') as $k=>$v)
					<option value="{{$k}}">{{trans($v)}}</option>
					@endforeach
					</select>
				<!--        <input class="short">-->
				<span class="tip">{{trans('mice.yuan/ren')}}</span>
			</div>
			<div id="precise-demand" class="group demand">
				<label>{{trans('mice.xianmu_need')}}</label>
				<ul class="clear">
					@foreach(config('mice.project_need') as $k=>$v)
					          <li data-demand="{{$k}}">
          <span>
            <i class="iconfont wxz icon-unselected2"></i>
            <i class="iconfont xz icon-selected2"></i>
          </span>
            {{trans($v)}}
          </li>
					@endforeach
					</ul>
         <input class="aaa hide" name="services">
			</div>
			<div class="group textarea">
				<label>{{trans('common.remark')}}</label>
				<textarea name="remark" id="remark"></textarea>
			</div>
			<div class="hr2 fl"></div>
			<div class="group">
				<label>{{trans('tour.name')}}</label> <input class="middle" name="allName">
			</div>
			<div class="group">
				<label>{{trans('tour.phone')}}</label> <input class="middle" name="allPhone">
			</div>
			<div class="group">
				<label>{{trans('tour.email')}}</label> <input class="middle" name="email">
			</div>
			<div class="group">
				<label>{{trans('mice.QQorWeixin')}}</label> <input class="middle" name="QQorWeixin">
			</div>
			<div class="clear"></div>
			<button type="button" id="allNeedButton">{{trans('common.submit')}}</button>
		</form>
	</div>
</section>
@if(MiceCases::first())
  <section class="mice-category">
  <ul class="clear">
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>1])}}">
        <div class="bgImg sports">
          <i class="iconfont icon-sports"></i>
        </div>

        <p>{{trans('mice.tiyu_saishi')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>2])}}">
        <div class="bgImg celebration">
          <i class="iconfont icon-celebration"></i>
        </div>

        <p>{{trans('mice.qindian_nianhui')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>3])}}">
        <div class="bgImg evening">
          <i class="iconfont icon-evening"></i>
        </div>

        <p>{{trans('mice.wanhui_wanyan')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>4])}}">
        <div class="bgImg meeting">
          <i class="iconfont icon-meeting"></i>
        </div>

        <p>{{trans('mice.huiyi_guanli')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>5])}}">
        <div class="bgImg travel">
          <i class="iconfont icon-travel"></i>
        </div>

        <p>{{trans('mice.jiangli_lvyou')}}</p>
      </a>
    </li>
  </ul>
</section>
@endif
<!--  
<section class="mice-block suc-case">
	<div class="title">
		<p class="tp1">SUCCESSFUL CASE</p>

		<div class="line"></div>
		<p class="tp2">成功案例</p>
	</div>
	<div class="cases">
		<div class="all-case">
			<i class="iconfont icon-add2"></i>
		</div>
		<ul class="case-ul fRow clear"></ul>
		<ul class="case-ul sRow clear"></ul>
	</div>
    <div class="btns clear">
      <a class="pre">
        <i class="iconfont icon-left5"></i>
      </a>
      <a class="next">
        <i class="iconfont icon-right5"></i>
      </a>
    </div>
</section>-->
<section class="mice-block explore">
	<div class="title">
		<p class="tp1">RECOMMENDED DESTINATION</p>
		<div class="line"></div>
		<p class="tp2">推荐目的地</p>
	</div>
	<div class="explore-main clear">
		@if($data['recomDest']->count())
		@foreach($data['recomDest'] as $k=>$v)
		<div class="explore-destination @if($k==1) long @elseif($k==3) middle @else short @endif @if($k==0||$k==2||$k==3) mr @endif iwrap">
			<img src="@storageAsset($v->image)">

			<p class="ed1">{{$v->name}}</p>

			<div class="ed2 zzc">
				<p>{{$v->desc}}</p>
				<a href="{{$v->url}}">{{trans('tour.look')}}</a>
			</div>
		</div>
		@endforeach
		@endif
	</div>
</section>
<section class="mice-block live-data">
	<div class="title">
		<p class="tp1">NUMBERS FACTS</p>

		<div class="line"></div>
		<p class="tp2">实时数据</p>
	</div>
	<div class="live-data-main">
		<ul class="clear">
			<li>
				<div class="text">
					<p class="ld1">
						<i class="iconfont icon-activity"></i>
					</p>

					<p class="ld2">
						<span>1512</span>{{trans('mice.ci')}}
					</p>

					<p class="ld3">{{trans('mice.zuzhi_huodong')}}</p>
				</div>
			</li>
			<li>
				<div class="text">
					<p class="ld1">
						<i class="iconfont icon-user2"></i>
					</p>

					<p class="ld2">
						<span>22145</span>{{trans('mice.wei')}}
					</p>

					<p class="ld3">{{trans('mice.fuwu_kehu')}}</p>
				</div>
			</li>
			<li>
				<div class="text">
					<p class="ld1">
						<i class="iconfont icon-praise"></i>
					</p>

					<p class="ld2">
						<span>99%+</span>
					</p>

					<p class="ld3">{{trans('mice.haopin_lv')}}</p>
				</div>
			</li>
		</ul>
	</div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<<script type="text/javascript">
var caseData ={!!$data['cases']!!};
</script>
<script src="{{ asset('/js/lib/select2.js')}}"></script>
<script src="{{ asset('/js/src/ow.mice.js')}}"></script>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
  $(function () {
    $("select").select2();


    var iwrap = $(".iwrap");

    iwrap.hover(function (e) {//mouse in
      var $this = $(this);
      var $thisFloat = $this.find(".zzc");
      $thisFloat.css(moveForward($this, e)).stop().animate({"left": 0, "top": 0}, 500);
    }, function (e) {//mouse out
      var $this = $(this);
      var $thisFloat = $this.find(".zzc");
      $thisFloat.stop().animate(moveForward($this, e), 500);
    });
	$.validator.setDefaults({
		errorElement:'span'
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
	jQuery.validator.addMethod("checkDestination", function(value, element) {
		var flag = $.ajax({
			type: "GET",
	        url: "{{url('area/getarea')}}",
	        data: {'name':$('input[name="destination"]').val()},
			async: false,
			success: function(data) {
	             var idStr='';
	             $.each(data.data, function (index, value) {
	            	 idStr+=value+',';
	             })
	             idStr=idStr.substring(0,idStr.length-1);
                 $('input[name="destinationId"]').val(idStr);
			}
		}).responseJSON;
		return this.optional(element) || flag.data.length !=0
	}, '<span class="warn"><span class="lgfork"></span>不存在该地区,请重新输入</span>');
	jQuery.validator.addMethod("checkDestinationall", function(value, element) {
		var flag = $.ajax({
			type: "GET",
	        url: "{{url('area/getarea')}}",
	        data: {'name':$('input[name="allDestination"]').val()},
			async: false,
			success: function(data) {
	             var idStr='';
	             $.each(data.data, function (index, value) {
	            	 idStr+=value+',';
	             })
	             idStr=idStr.substring(0,idStr.length-1);
                 $('input[name="allDestinationId"]').val(idStr);
			}
		}).responseJSON;
		return this.optional(element) || flag.data.length !=0
	}, '<span class="warn"><span class="lgfork"></span>不存在该地区,请重新输入</span>');
	jQuery.validator.addMethod("weixinOrqq", function(value, element) {
		return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
	}, '<span class="warn"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
	jQuery.validator.addMethod("isMobile", function(value, element) {
		var length = value.length;
		return this.optional(element) || (length == 11 && /^(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/.test(value))
	}, '<span class="warn"><span class="lgexm"></span>请填写正确的手机号</span>');
	$('#simple-need').validate({
		rules: {
			destinationId: {
				required: true,
				number: true,
				//checkDestination: true
			},
			name: {
				required: true
			},
			phone: {
				required: true,
				isMobile: true,
			},
		},
		messages: {
			destinationId: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.destination')}}"+'</span>',
				//checkDestination:'<span class="warn"><span class="lgexm"></span>不存在该地区</span>',
			},
			name: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.name')}}"+'</span>',
			},
			phone: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.phone')}}"+'</span>',
				isMobile: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.isMobile')}}"+'</span>'
			},
		},
		errorPlacement: function(error, element) {
			//layer.msg('aa');
            //element.after(error);
		},
		success: function(label) {
			label.html('<span class="lgtick"></span>')
		},
	    invalidHandler: function(form, validator) {
	        $.each(validator.invalid,function(key,value){
	        	layer.msg(value,{icon: 2});
	            return false;
	        }); //这里循环错误map，只报错第一个
	    },
		focusInvalid: false,
		onkeyup: false,
    	submitHandler: function(form) {
    		  var destination=$('input[name="destinationId"]').val();
    		  if(!destination){
    			  layer.msg("{{trans('validation.mice.destination')}}",{icon: 2});
    			  return false;
        		  }
      		  var peopleNum=$('#peopleNum').val();
      		  var type=parseInt($('.fl .cur').attr('data-demand'));
      		  if(!type){
      			layer.msg('请选择需求',{icon: 2});
      			return false;
          		  }
      		  var budget=$('#budget').val();
      		  var name=$('input[name="name"]').val();
      		  var phone=$('input[name="phone"]').val();
  		  $.ajax({
  		         type: "POST",
  		         url: "{{url('mice/addneeds')}}",
  		         data: {'_token':'{{csrf_token()}}','area':destination,'people_num':peopleNum,'budget':budget,'type':type,'name':name,'phone':phone,},
  		         beforeSend : function(){
  		    },
  		             success: function(data){
  			             if(data.status){
  			            	layer.msg(data.info,{icon: 1});
                              setTimeout(function(){
                                  location.reload();
                                 },150);
  			             }
  			             else{
  			            	layer.msg(data.info,{icon: 2});
      			             }     
  		             },
  		     error: function(){
  		     alert("系统繁忙");
  		     }
  		           });
  		 // return false;
  	},
	});
	$('#all-need').validate({
		rules: {
			allDestinationId: {
				required: true,
				number: true,
				//checkDestinationall: true
			},
			departure_date: {
				required: true,
				date: true
			},
			duration: {
				required: true,
				number: true,
				min:1,
			},
			services: {
				required: true,
			},
			remark: {
				//required: true,
			},
			allName: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			QQorWeixin: {
				required: true,
				weixinOrqq:true
			},
			allPhone: {
				required: true,
				isMobile: true,
			},
		},
		messages: {
			allDestinationId: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.destination')}}"+'</span>',
				//checkDestination:'<span class="warn"><span class="lgexm"></span>不存在该地区</span>',
			},
			allName: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.name')}}"+'</span>',
			},
			allPhone: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.phone')}}"+'</span>',
				isMobile: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.isMobile')}}"+'</span>'
			},
			departure_date: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.departure_date')}}"+'</span>',
			},
			email: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.email')}}"+'</span>',
				email: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.isEmail')}}"+'</span>',
			},
			QQorWeixin: {
				required: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.QQorWeixin')}}"+'</span>',
				weixinOrqq: '<span class="warn"><span class="lgexm"></span>'+"{{trans('validation.mice.isQQorWeixin')}}"+'</span>',
			},
		},
		errorPlacement: function(error, element) {
			//layer.msg('aa');
           // element.after(error);
		},
	    invalidHandler: function(form, validator) {
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
  		 var destination=$('input[name="allDestinationId"]').val();
		  if(!destination){
			  layer.msg("{{trans('validation.mice.destination')}}",{icon: 2});
			  return false;
    		  }
 		  var departure_date=$('input[name="departure_date"]').val();
 		  var duration=$('input[name="duration"]').val();
 		  var allType=$('#allType').val();
 		  var allPeopleNum=$('#allPeopleNum').val();
 		  var budget=$('#allBudget').val();
 		  var remark=$('#remark').val();
 		  var services=$('input[name="services"]').val();
 		  var QQorWeixin=$('input[name="QQorWeixin"]').val();
 		  var allName=$('input[name="allName"]').val();
 		  var allPhone=$('input[name="allPhone"]').val();
 		  var email=$('input[name="email"]').val();
  		  $.ajax({
  		         type: "POST",
  		         url: "{{url('mice/addneedsall')}}",
  		         data: {'duration':duration,'departure_date':departure_date,'email':email,'qq_wechat':QQorWeixin,'services':services,'remark':remark,'_token':'{{csrf_token()}}','area':destination,'people_num':allPeopleNum,'budget':budget,'type':allType,'name':allName,'phone':allPhone,},
  		         beforeSend : function(){
  		    },
  		             success: function(data){
  			             if(data.status){
  			            	layer.msg(data.info,{icon: 1});
                              setTimeout(function(){
                                  location.reload();
                                 },150);
  			             }
  			             else{
  			            	layer.msg(data.info,{icon: 2});
      			             }     
  		             },
  		     error: function(){
  		     alert("系统繁忙");
  		     }
  		           });
  		 // return false;
  	},
	});
	$(document).on('click', '#simpleButton,#allNeedButton', function () { 
		$(this).submit();
		});
  });

  var moveForward = function (elem, e) {
    var w = elem.width(), h = elem.height(), direction = 0, cssprop = {};
    var x = (e.pageX - elem.offset().left - (w / 2)) * (w > h ? (h / w) : 1);
    var y = (e.pageY - elem.offset().top - (h / 2)) * (h > w ? (w / h) : 1);

    direction = Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180) / 90) + 3) % 4;
    switch (direction) {
      case 0://from top
        cssprop.left = 0;
        cssprop.top = "-100%";
        break;
      case 1://from right
        cssprop.left = "100%";
        cssprop.top = 0;
        break;
      case 2://from bottom
        cssprop.left = 0;
        cssprop.top = "100%";
        break;
      case 3://from left
        cssprop.left = "-100%";
        cssprop.top = 0;
        break;
    }
    return cssprop;
  }
</script>
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<script src="{{ asset('/areaSelect/pt-list.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!Area::getSelectJs()!!}
<script type="text/javascript">
//labelFromcity ['X-Z'] = new Array(2,19,20,21,26,27,39);
//console.log(labelFromcity);
$(document).ready(function(){
	$('#allCity').querycity({'inputCityIdName':'allCityId','data':citysFlight,'tabs':labelFromcity,'hotList':'','defaultText':"{{trans('common.ChineseOrpPinyin')}}",'popTitleText'   :"{{trans('common.cityselectOS')}}",'suggestTitleText' : "{{trans('common.suggest_city_select')}}",'nofundText':"{{trans('common.city_notfound')}}",'pingyinOrder':"{{trans('common.pingyinOrder')}}"});
});
</script>
@stop
