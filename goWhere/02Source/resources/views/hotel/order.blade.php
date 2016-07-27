<?php
use App\Helpers\Common;
?>
@extends('layouts.master')
 @section('title',trans('common.order_hotel'))
@section('navClass','ow-inner-nav') @section('content')
 @section('style') @parent
<link href="{{ asset('/css/lib/jquery.ad-gallery.css') }}" rel="stylesheet"
	type="text/css">
	
  <link rel="stylesheet" href="{{ asset('/css/src/hotel.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/src/hotel-inner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/jquery.nstSlider.css') }}">
	<style>
.order-write .order-write-warp .order-write-main .order-write-left .order-write-form .no-bottom {
    border-bottom: medium none;
}
.order-step {
    height: 60px;
    margin: 25px auto;
    width: 985px;
}
.order-write-msg-title span {
    color: #333;
    display: inline-block;
    font-size: 20px;
    height: 35px;
    line-height: 35px;
}

.order-write .order-write-warp .order-write-main .order-write-left .order-write-form .order-msg .order-write-msg-main .order-write-msg-item {
    line-height: 40px;
}
.order-write-msg-item {
    height: 40px;
    line-height: 40px;
}

.order-write .order-write-warp .order-write-main .order-write-left .order-write-form .order-msg .order-write-msg-main .order-write-msg-item .order-msg-label {
    color: #666;
    display: inline-block;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    text-align: right;
    width: 76px;
}

.order-write .order-write-warp .order-write-main .order-write-left .order-write-form .order-msg .order-write-msg-main .order-write-msg-item .radio-warp {
    display: inline-block;
    margin-left: 56px;
}
</style>
@stop @section('content')
<section class="hotel-search">
  <div class="hotel-search-warp">
    <div class="hotel-search-title clear">

    </div>
  </div>
</section>
<section class="order-step clear">
  <div class="order-bar-x1 mr2"></div>
  <div class="order-bar-x2 mr3"></div>
  <div class="order-bar-x3 mr5"></div>
  <div class="order-step-bar order-step-bar-cur">
    <div class="order-step-num">1</div>
    <div class="order-step-text">{{trans('tour.tianxie_order')}}</div>
  </div>
  <div class="order-step-bar">
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

<section class="order-write">
  <div class="order-write-warp">
    <p class="order-write-title">Moni Gallery Hostel(莫尼画廊旅馆)</p>

    <div class="order-write-main clear">
      <div class="order-write-left">
        <form class="order-write-form" action="{{url('hotel/addorder')}}">
          <div class="order-msg">
            <div class="order-write-msg-title">
              <img src="../img/border-left.png">
              <span>
                {{trans('hotel.book_info')}}
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('hotel.room_type_info')}}</span>
                <span class="fs14 c3 bold">标准单人房（无窗）-不含早（预付）</span>
              </div>
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('hotel.check-in-out_date')}}</span>
                <span class="fs14 c6 mr16">
                  <span class="order-start-time">{{Input::get('checkin')}}</span><span class="c9">({{config('tour.week_'.\App::getLocale())[date("w",strtotime(Input::get('checkin')))]}})</span> -
                  <span class="order-end-time">{{Input::get('checkout')}}</span><span class="c9">({{config('tour.week_'.\App::getLocale())[date("w",strtotime(Input::get('checkout')))]}})</span></span>
                <span class="fs14 c6 mr16">1{{trans('hotel.nights')}}</span>
                <a class="fs14 c_blue">修改日期</a>
              </div>
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('hotel.room_num')}}</span>
                  <select class="j-room-num" name="room_num">
            @foreach(config('hotel.rooms_num') as $v)
                            @if($v==Input::get('rooms_num'))
         <option value="{{$v}}" selected>{{$v}}</option>
        @else
          <option value="{{$v}}">{{$v}}</option>
          @endif
          @endforeach
                </select>
                <span class="fs14 c6 mr16">{{trans('tour.adult')}}-{{trans('tour.child').trans('tour.num')}}({{trans('tour.meijian')}})</span>
                <span class="fs14 c3">{{Input::get('adult')}}-{{Input::get('child')}}</span>
                <input type="hidden" value="{{Input::get('adult')}}" name="adult_num">
                <input type="hidden" value="{{Input::get('child')}}" name="child_num">
                <input type="hidden" value="{{Input::get('checkin')}}" name="checkin">
                <input type="hidden" value="{{Input::get('checkout')}}" name="checkout">
              </div>
            </div>
          </div>
          <div class="lodger-msg">
            <div class="order-write-msg-title">
              <img src="../img/border-left.png">
              <span>
                {{trans('hotel.guest_info')}}
              </span>
            </div>
            <div class="lodger-msg-main">
              <div class="lodger-msg-items">
              <?php for($i=0;$i<Input::get('rooms_num');$i++){?>
                <div class="lodger-msg-item">
                  <span class="lodger-msg-item-label">{{trans('hotel.guest_name')}}：</span><input onclick="removeError(this)" name="tenants[adult][][firstName]" class="lodger-name mr16" placeholder="{{trans('tour.english_xing')}}"><input name="tenants[adult][][lastName]" class="lodger-name" placeholder="{{trans('tour.english_name')}}" onclick="removeError(this)">
                  <span class="lodger-msg-item-label2">{{trans('hotel.guest_phone')}}：</span><input name="tenants[adult][][phone]" class="lodger-tel" placeholder="{{trans('common.must_in')}}" onclick="removeError(this)">
                 <!--  <a class="fs14 c6 set-lxr">
                    <i class="iconfont icon-danxuan mr3"></i>设置为联系人
                  </a>
                  <a class="fs14 c_blue">+添加入住人</a> -->
                </div>
              <?php }?>
              <?php //for($i=0;$i<Input::get('child');$i++){?>
                <!-- <div class="lodger-msg-item">
                  <span class="lodger-msg-item-label">{{trans('hotel.guest_name')}}：</span><input onclick="removeError(this)" name="tenants[child][][firstName]" class="lodger-name mr16" placeholder="{{trans('tour.english_xing')}}"><input name="tenants[child][][lastName]" class="lodger-name" placeholder="{{trans('tour.english_name')}}" onclick="removeError(this)">
                  <span class="lodger-msg-item-label2">{{trans('hotel.guest_phone')}}：</span><input  name="tenants[child][][phone]" class="lodger-tel" placeholder="{{trans('common.must_in')}}" onclick="removeError(this)">
                   <!--  <a class="fs14 c6 set-lxr">
                    <i class="iconfont icon-danxuan mr3"></i>设置为联系人
                  </a>
                  <a class="fs14 c_blue">+添加入住人</a> 
                </div>-->
              <?php //}?>
              </div>
              <a class="fs14 c_blue add-lodger">+添加入住人</a>
              <div class="lodger-msg-item-other">
                <span class="lodger-msg-item-label">{{trans('common.remark')}}：</span>
                <textarea placeholder="{{trans('hotel.guest_notice')}}" name="notice"></textarea>
              </div>
            </div>
          </div>
          <div class="contacts-msg">
            <div class="order-write-msg-title">
              <img src="../img/border-left.png">
              <span>
                {{trans('tour.lianxi_info')}}
              </span>
            </div>
            <div class="contacts-msg-main">
              <div class="contacts-msg-items">
                <div class="contacts-msg-item">
                  <span>{{trans('common.name')}}：</span>
                  <input name="contact_name" class="contacts-msg-input-m mr100" placeholder="({{trans('common.must_in')}})">
                  <span>{{trans('common.phone')}}：</span>
                  <input name="contact_phone" class="contacts-msg-input-m" placeholder="({{trans('common.must_in')}})">
                </div>
                <div class="contacts-msg-item">
                  <span>{{trans('common.email')}}：</span>
                  <input name="contact_email" class="contacts-msg-input-m mr100" placeholder="({{trans('common.must_in')}})">
                  <span>{{trans('mice.qq_wechat')}}：</span>
                  <input name="contact_wx" class="contacts-msg-input-m" placeholder="({{trans('common.must_in')}})">
                </div>
               <!--  <div class="contacts-msg-item">
                  <span>{{trans('tour.xiyao_fapiao')}}：</span>
                  <input class="contacts-msg-input-s" placeholder="是">
                  <p class="iBlock fs14 c9">{{trans('hotel.fapiao_detail')}}</p>
                </div>
                <div class="contacts-msg-item">
                  <span>{{trans('tour.fapiao_taitou')}}：</span>
                  <input class="contacts-msg-input-b" placeholder="{{trans('tour.taitou_placeholder')}}">
                </div>
                <div class="contacts-msg-item">
                  <span>{{trans('tour.xiangxi_dizhi')}}：</span>
                  <input class="contacts-msg-input-b" placeholder="{{trans('tour.xiangxi_dizhi_placeholder')}}">
                </div>
                --> 
              </div>
            </div>
                      <div class="order-msg no-bottom">
            <div class="order-write-msg-title">
            <img src="../img/border-left.png">
              <span>
                {{trans('tour.fapiao_xinxi')}}
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('tour.xiyao_fapiao')}}:</span>
                <div class="radio-warp">
                    <span class="radio" data-val="1" data-type="need-invoice">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                    <span>{{trans('tour.yes')}}</span>
                </div>
                <div class="radio-warp">
                    <span class="radio cur" data-val="2" data-type="noNeed-invoice">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                  <span>{{trans('tour.no')}}</span>
                  <span class="fs12 c9">{{trans('tour.fapiao_detail')}}</span>
                </div>
                <input class="hide" name="isNeedFapiao" value="2">
              </div>
                            <div class="invoice hide">
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.fapiao_taitou')}}:</span>
                  <input placeholder="{{trans('tour.taitou_placeholder')}}" name="fapiao_taitou">
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.xiangxi_dizhi')}}:</span>
                  <input placeholder="{{trans('tour.xiangxi_dizhi_placeholder')}}" name="address">
                </div>
              </div>
            </div>
          </div>
          </div>
          <input type="hidden" name="room_id" value="{{Input::get('hotel_id')}}">
          <input type="hidden" name="hotel_id" value="{{Input::get('hotel_id')}}">
          <button class="order-btn">{{trans('tour.quzhifu')}}</button>
        </form>
      </div>
      <div class="order-write-right">
        <div class="order-write-right-warp">
          <img src="../img/hotel01.jpg">
          <p class="order-view-name">Moni Gallery Hostel(莫尼画廊旅馆)</p>
          <p class="order-view-star">
            <i class="fs12 iconfont icon-star"></i>
            <i class="fs12 iconfont icon-star"></i>
            <i class="fs12 iconfont icon-star"></i>
            <i class="fs12 iconfont icon-star"></i>
            <i class="fs12 iconfont icon-star"></i>
          </p>
          <p class="order-view-address">263 Lavender Street,新加坡,338795,新加坡</p>
          <div class="room-view">
            <p class="room-view-type">房型：<span>标准单人房（无窗）-不含早（预付）</span></p>
            <p class="room-view-bed">加床：<span>不可加床</span></p>
            <p class="room-view-area">面积：<span>18平方米</span></p>
            <p class="room-view-num">最多可住：<span>2人</span></p>
            <p class="room-view-clause">取消条款：<span>不可取消</span></p>
          </div>
          <div class="pay-view">
            <p class="pay-view-title">账单信息</p>
            <div class="pay-view-price clear">
              <span class="fs14 c9">单价：</span><span class="pay-view-line"></span><span class="price-view">￥500</span>
            </div>
            <div class="pay-view-num clear">
              <span class="fs14 c9">数量：</span><span class="pay-view-line"></span><span class="pay-view-room">两间</span>
            </div>
            <div class="pay-view-time clear">
              <span class="fs14 c9">入住：</span><span class="pay-view-line"></span><span class="pay-view-room">1晚</span>
            </div>
            <div class="totle-price">
              总计(含税)：<span>￥1398</span>
            </div>
          </div>
        </div>
      </div>
      <p class="view-tips">备注：该城市有城市税，需到酒店现付</p>
    </div>
  </div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/src/package-order.js')}}"></script>
<script src="{{ asset('/js/src/hotel-order.js')}}"></script>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
var flag = true;
$(function() {

    $.validator.setDefaults({
        errorElement: 'span'
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
    jQuery.validator.addMethod("byteRangeLength",
    function(value, element, param) {
        var length = value.length;
        for (var i = 0; i < value.length; i++) {
            if (value.charCodeAt(i) > 127) {
                length++
            }
        }
        return this.optional(element) || (length >= param[0] && length <= param[1])
    },
    '<span class="error"><span class="error"></span>长度在{0}-{1}之间，请重新输入</span>');
    jQuery.validator.addMethod("weixinOrqq",
    function(value, element) {
        return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
    },
    '<span class="error"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
    jQuery.validator.addMethod("isMobile",
    function(value, element) {
        var length = value.length;
        return this.optional(element) || (/(^1(3|4|5|7|8)[0-9]{9}$)|(^(\d{3})[-]?(\d{8})$|^(\d{4})[-]?(\d{7,8})$)/.test(value))
    },
    '<span class="error"><span class="error"></span>请填写正确的手机号</span>');
    jQuery.validator.addMethod("checkName",
    function(value, element) {
        return this.optional(element) || /^([\u4e00-\u9fa5]|[A-Za-z])+$/.test(value)
    },
    '<span class="error"><span class="error"></span>联系人名字格式错误</span>');
    $('.order-write-form').validate({
        rules: {
        	room_num: {
                required: true,
                number: true,
                min: 1,
            },
            contact_name: {
                required: true,
                checkName: true,
            },
            contact_email: {
                required: true,
                email: true
            },
            contact_phone: {
                required: true,
                isMobile: true,
            },
            contact_wx: {
                required: true,
                weixinOrqq: true,
            },
        },
        messages: {
        	room_num: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.hotel.room_num_must')}}" + '</span>',
                number: '<span class="error" style="color: red; display: inline;">' + "{{trans('validation.hotel.room_num_must_num')}}" + '</span>',
                min: '<span class="error" style="color: red; display: inline;">' + "{{trans('validation.hotel.room_num_lest')}}{0}" + '</span>',
            },
            contact_name: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.contact_name')}}" + '</span>',
               // checkName: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>',
            },
            contact_email: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.contact_email')}}" + '</span>',
                email: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.is_contact_email')}}" + '</span>',
            },
            contact_phone: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.contact_phone')}}" + '</span>',
                isMobile: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.is_contact_phone')}}" + '</span>'
            },
            contact_wx: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.hotel.contact_wx')}}" + '</span>',
                weixinOrqq: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.hotel.is_contact_wx')}}" + '</span>'
            },
        },
        errorPlacement: function(error, element) {
            //layer.msg('aa');
            $(element).focus();
            
            //element.after(error);
        },
        success: function(label) {
            label.html('<span class="lgtick"></span>')
        },
        focusInvalid: false,
        onkeyup: false,
	    invalidHandler: function(form, validator) {
	        $.each(validator.invalid,function(key,value){
	        	layer.msg(value,{icon: 2});
	            return false;
	        }); //这里循环错误map，只报错第一个
	    },
        submitHandler: function(form) {
            var isNeedFapiao = parseInt($('input[name="isNeedFapiao"]').val());
            if (!isNeedFapiao) {
                layer.msg("{{trans('validation.tour.isNeedFapiao')}}", {
                    icon: 2
                });
                return false;
            }
            if (isNeedFapiao == 1) {
                if (!$('input[name="fapiao_taitou"]').val()) {
                    layer.msg("{{trans('validation.tour.fapiao_taitou')}}", {
                        icon: 2
                    });
                    return false;
                }
                if (!$('input[name="address"]').val()) {
                    layer.msg("{{trans('validation.tour.address')}}", {
                        icon: 2
                    });
                    return false;
                }
            }
            CheckName('tenants[adult][][firstName]');
            CheckName('tenants[child][][lastName]');
            CheckName('tenants[adult][][lastName]');
            CheckName('tenants[child][][firstName]');
            checkPhone('tenants[adult][][phone]');
            checkPhone('tenants[child][][phone]');
            //CheckPhone('a');
            if (CheckName('tenants[adult][][firstName]',2)&&
            CheckName('tenants[child][][lastName]',2)&&
            CheckName('tenants[adult][][lastName]',2)&&
            CheckName('tenants[child][][firstName]',2)&&
            checkPhone('tenants[adult][][phone]',2)&&
            checkPhone('tenants[child][][phone]',2)) {
                form.submit();
            }
            // return false;
        },
    });
    function CheckName(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    //console.log($(this).next('.error').length);
                	if(!$(this).next('.error').length){
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                	}
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if (! (/^([\u4e00-\u9fa5]|[A-Za-z])+$/.test($(this).val()))) {
                if (displayError == 1) {
                    if(!$(this).next('.error').length){
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
                    }
                    $(this).focus();
                }
                flag = false;
                return false;
                //onblurCheck=false;
                //layer.msg("{{trans('validation.tour.wrong_format')}}",{icon: 2});
            }
        });
        return flag;
    }
    function checkPhone(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                	if(!$(this).next('.error').length){
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                	}
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if (! (/(^1(3|4|5|7|8)[0-9]{9}$)|(^(\d{3})[-]?(\d{8})$|^(\d{4})[-]?(\d{7,8})$)/.test($(this).val()))) {
                if (displayError == 1) {
                	if(!$(this).next('.error').length){ 
                    	$(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
                	}
                    $(this).focus();
                }
                flag = false;
                return false;
                //onblurCheck=false;
                //layer.msg("{{trans('validation.tour.wrong_format')}}",{icon: 2});
            }
        });
        return flag;
    }

});
function removeError(obj){
	//console.log($(obj).next('.error'));
	$(obj).next('.error').remove();
}
</script>
@stop