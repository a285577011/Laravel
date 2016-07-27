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
  <div class="progress-step-bar">
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

<section class="order-write">
  <div class="order-write-warp">
    <p class="order-write-title">{{$tourData->name.'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')'}}</p>

    <div class="order-write-main clear">
      <div class="order-write-left">
        <form class="order-write-form" action="{{url('tour/addorder')}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" value="{{$token}}" name="token">
          <div class="order-msg">
            <div class="order-write-msg-title">
              <span>{{trans('tour.xianlu_xinxi')}}</span>
            </div>
            <div class="order-write-msg-main">
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('tour.xianlu_mincheng')}}</span>
                <span class="fs14 c3 bold">{{$tourData->name.'('.$tourData->days.trans('tour.tian').$tourData->nights.trans('tour.nights').')'}}</span>
              </div>
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('tour.departure_day')}}</span>
        <select class="pt-order-time" name="departure_date" id="departure_date">
        @if($tourDate)
        @foreach($tourDate as $k=>$v)
        <option data-begin="{{$k}}" data-end="{{date('Y-m-d',strtotime($k)+(($tourData->schedule_days-1)*86400))}}" data-ap="{{Common::getPriceByValue($v['price'],false)}}" data-cp="{{Common::getPriceByValue($v['child_price'],false)}}" value="{{$k}}" data-returnDate="{{date('Y-m-d',strtotime($k)+(($tourData->schedule_days-1)*86400))}}" @if($departureDate==$k) selected @endif>{{$k.' '.config('tour.week_'.\App::getLocale())[date("w",strtotime($k))]}}</option>
        @endforeach
        @endif
        </select>
                <span class="pt-begin fs12 c9"><span class="time c3 pt-begin">{{date('Y-m-d',strtotime($departureDate))}}</span>{{trans('tour.chufa')}}</span>,
                <span class="pt-end fs12 c9"><span class="time c3 pt-end">{{date('Y-m-d',strtotime($departureDate)+(($tourData->schedule_days-1)*86400))}}</span>{{trans('tour.return')}}</span>
              </div>
              <div class="order-write-msg-item">
                <span class="order-msg-label">{{trans('tour.schedule_renshu')}}</span>
                <div class="pt-num">
                  <div class="minus minusDdult">-</div>
                  <div class="num" data-num="{{$adultNnum}}" data-type="adult">{{$adultNnum}}</div>
                  <div class="add addDdult">+</div>
                  <span>{{trans('tour.adult')}}</span>
                  <input class="hide" name="adult_num" value="{{$adultNnum}}">
                </div>
                <div class="pt-num">
                  <div class="minus minusChild">-</div>
                  <div class="num" data-num="{{$childNum}}" data-type="child">{{$childNum}}</div>
                  <div class="add addChild">+</div>
                  <span>{{trans('tour.child')}}</span>
                  <input class="hide" name="child_num" value="{{$childNum}}">
                </div>
              </div>
            </div>
          </div>
@if(config('tour.insurance'))
          <div class="order-msg">
            <div class="order-write-msg-title">
              <span>{{trans('tour.baoxian_xinxi')}}</span>
            </div>
            <div class="order-write-msg-main">
            @foreach(config('tour.insurance') as $k=>$v)
            <div class="order-write-msg-item insurance-msg">
                <span class="checkbox" data-val="{{$k}}" data-price="{{Common::getPriceByValue($v['price'],false)}}">
                  <i class="iconfont wxz icon-unselected2"></i>
                  <i class="iconfont xz icon-selected2"></i>
                </span>
                <span class="im1">{{$v['name_'.\App::getLocale()]}}</span>
                <span class="im2">{{Common::getCurrencySymbol()}}<span>{{Common::getPriceByValue($v['price'])}}</span></span>
                <span class="im3">{{$v['desc_'.\App::getLocale()]}}</span>
              </div>
            @endforeach
            <input class="hide" name="insurance_id">
            </div>
          </div>
@endif
          <div class="order-msg">
            <div class="order-write-msg-title">
              <span>
              {{trans('tour.lianxi_info')}}
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="order-write-msg-item">
                <div class="iBlock">
                  <span class="order-msg-label">{{trans('tour.name')}}:</span>
                  <input placeholder="({{trans('tour.bitian')}})" name="contact_name">
                </div>
                <div class="iBlock">
                  <div class="radio-warp">
                    <span class="radio cur" data-val="1">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                    <span>{{trans('tour.xiansheng')}}</span>
                  </div>
                  <div class="radio-warp">
                    <span class="radio" data-val="2">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                    <span>{{trans('tour.nvshi')}}</span>
                  </div>
                  <input class="hide" name="contact_gender" value="1">
                </div>
              </div>
              <div class="order-write-msg-item">
                <div class="iBlock">
                  <span class="order-msg-label">{{trans('tour.email')}}:</span>
                  <input placeholder="({{trans('tour.bitian')}})" name="contact_email">
                </div>
                <div class="iBlock">
                  <span class="order-msg-label">{{trans('tour.phone')}}:</span>
                  <input placeholder="({{trans('tour.bitian')}})" name="contact_phone">
                </div>
              </div>
            </div>
          </div>
          <div class="order-msg">
                     <div class="adultPassengerMsg-warp">
<?php for($i=0;$i<$adultNnum;$i++){?>
<div class="adultPassengerMsg">
            <div class="order-write-msg-title">
              <span>
              {{trans('tour.lvke_xinxi')}}
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="passenger-msg">
                <div class="order-write-msg-item">
                  <div class="iBlock">
                    <span class="order-msg-label">{{trans('tour.name')}}:</span>
                    <input placeholder="({{trans('tour.bitian')}})" name="tourist[adult][name][]" onclick="removeError(this)">
                  </div>
                  <div class="iBlock">
                    <div class="radio-warp">
                    <span class="radio cur" data-val="1">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.xiansheng')}}</span>
                    </div>
                    <div class="radio-warp">
                    <span class="radio" data-val="2">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.nvshi')}}</span>
                    </div>
                    <input class="hide" name="tourist[adult][sex][]" value="1" onclick="removeError(this)">
                  </div>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.english')}}{{trans('tour.name')}}:</span>
                  <input class="" placeholder="{{trans('tour.english_xing')}}" name="tourist[adult][englishXing][]" onclick="removeError(this)">
                  <input class="" placeholder="{{trans('tour.english_name')}}" name="tourist[adult][englishName][]" onclick="removeError(this)">
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.zhengjian_info')}}:</span>
                  <select class="" name="tourist[adult][zhengjianType][]">
                  @foreach(config('tour.zhengjian') as $k=>$v)
                    <option value="{{$k}}">{{$v[\App::getLocale()]}}</option>
                    @endforeach
                  </select>
                  <input class="" placeholder="" name="tourist[adult][zhengjian][]" onclick="removeError(this)">
                </div>
                <div class="passenger-msg-tip">
                  <i class="iconfont icon-evening"></i>
                  <span>{{trans('tour.wenxintishi_detail')}}</span>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.birther_day')}}:</span>
                  <input class="middle datePick" name="tourist[adult][birther_day][]" readonly onclick="removeError(this)">
                  <span class="order-msg-label">{{trans('tour.phone')}}:</span>
                  <input class="" placeholder="({{trans('tour.bitian')}})" name="tourist[adult][phone][]" onclick="removeError(this)">
                </div>
              </div>
              </div>
              </div>
              <?php }?>
            </div>
            <div class="childPassengerMsg-warp">
<?php for($i=0;$i<$childNum;$i++){?>
<div class="childPassengerMsg">
            <div class="order-write-msg-title">
              <span>
              {{trans('tour.lvke_xinxi')}}({{trans('tour.child')}})
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="passenger-msg">
                <div class="order-write-msg-item">
                  <div class="iBlock">
                    <span class="order-msg-label">{{trans('tour.name')}}:</span>
                    <input placeholder="({{trans('tour.bitian')}})" name="tourist[child][name][]" onclick="removeError(this)">
                  </div>
                  <div class="iBlock">
                    <div class="radio-warp">
                    <span class="radio cur" data-val="1">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.xiansheng')}}</span>
                    </div>
                    <div class="radio-warp">
                    <span class="radio" data-val="2">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.nvshi')}}</span>
                    </div>
                    <input class="hide" name="tourist[child][sex][]" value="1">
                  </div>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.english')}}{{trans('tour.name')}}:</span>
                  <input class="" placeholder="{{trans('tour.english_xing')}}" name="tourist[child][englishXing][]" onclick="removeError(this)">
                  <input class="" placeholder="{{trans('tour.english_name')}}" name="tourist[child][englishName][]" onclick="removeError(this)">
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.zhengjian_info')}}:</span>
                  <select class="" name="tourist[child][zhengjianType][]" >
                  @foreach(config('tour.zhengjian') as $k=>$v)
                    <option value="{{$k}}">{{$v[\App::getLocale()]}}</option>
                    @endforeach
                  </select>
                  <input class="" placeholder="" name="tourist[child][zhengjian][]" onclick="removeError(this)">
                </div>
                <div class="passenger-msg-tip">
                  <i class="iconfont icon-evening"></i>
                  <span>{{trans('tour.wenxintishi_detail')}}</span>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.birther_day')}}:</span>
                  <input class="middle datePick" name="tourist[child][birther_day][]" readonly onclick="removeError(this)">
                  <span class="order-msg-label">{{trans('tour.phone')}}:</span>
                  <input class="" placeholder="({{trans('tour.bitian')}})" name="tourist[child][phone][]" onclick="removeError(this)">
                </div>
              </div>
                          </div>
  </div>
              <?php }?>
                                        </div>
            </div>
            
                          
          <div class="order-msg no-bottom">
            <div class="order-write-msg-title">
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
          <input type="hidden" value="{{$tourId}}" name="tour_id">
          <button class="order-btn" type="submit">{{trans('tour.tijiao_order')}}</button>
        </form>
            </div>
      <div class="order-write-right">
        <div class="order-write-right-warp">
          <div class="pay-view">
            <p class="pay-view-title">{{trans('tour.jiesuan_xinxi')}}</p>
            <p class="p1">{{trans('tour.jiben_tuanfei')}}</p>
              <div class="pay-view-item">
              <span class="pvl">{{trans('tour.adult')}}</span><span class="pv-line"></span><span class="pvr">{{Common::getCurrencySymbol()}}<span class="j-ap">{{Common::getPriceByValue($tourDateData['price'])}}</span>*<span class="j-adult-num">{{$adultNnum}}</span>{{trans('tour.ren')}}</span>
            </div>
            <div class="pay-view-item">
              <span class="pvl">{{trans('tour.child')}}</span><span class="pv-line"></span><span class="pvr">{{Common::getCurrencySymbol()}}<span class="j-cp">{{Common::getPriceByValue($tourDateData['child_price'])}}</span>*<span class="j-child-num">{{$childNum}}</span>{{trans('tour.ren')}}</span>
            </div>
            @if(config('tour.insurance'))
            <p class="p1">{{trans('tour.baoxian')}}</p>
            @foreach(config('tour.insurance') as $k=>$v)
             <div class="pay-view-item pvi-insurance hide" data-type="{{$k}}">
              <span class="pvl">{{$v['name_'.\App::getLocale()]}}</span><span class="pv-line"></span><span class="pvr">{{Common::getCurrencySymbol()}}{{Common::getPriceByValue($v['price'])}}*<span class="j-total-num">{{$adultNnum+$childNum}}</span>{{trans('tour.ren')}}</span>
            </div>
            @endforeach
            @endif
            <div class="total-price">
             {{trans('tour.yinfu_quane')}}：<span>{{Common::getCurrencySymbol()}}<span class="j-total-price">{{round(Common::getPriceByValue($tourDateData['price'],false)*$adultNnum+Common::getPriceByValue($tourDateData['child_price'],false)*$childNum,2)}}</span></span>
            </div>
          </div>
        </div>
      </div>
  </div>
  </div>
  <div class="adultPassengerMsg hide">
  <div class="order-write-msg-title">
              <span>
              {{trans('tour.lvke_xinxi')}}
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="passenger-msg">
                <div class="order-write-msg-item">
                  <div class="iBlock">
                    <span class="order-msg-label">{{trans('tour.name')}}:</span>
                    <input placeholder="({{trans('tour.bitian')}})" name="tourist[adult][name][]" onclick="removeError(this)">
                  </div>
                  <div class="iBlock">
                    <div class="radio-warp">
                    <span class="radio cur" data-val="1">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.xiansheng')}}</span>
                    </div>
                    <div class="radio-warp">
                    <span class="radio" data-val="2">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.nvshi')}}</span>
                    </div>
                    <input class="hide" name="tourist[adult][sex][]" value="1">
                  </div>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.english')}}{{trans('tour.name')}}:</span>
                  <input class="" placeholder="{{trans('tour.english_xing')}}" name="tourist[adult][englishXing][]" onclick="removeError(this)">
                  <input class="" placeholder="{{trans('tour.english_name')}}" name="tourist[adult][englishName][]" onclick="removeError(this)">
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.zhengjian_info')}}:</span>
                  <select class="" name="tourist[adult][zhengjianType][]">
                  @foreach(config('tour.zhengjian') as $k=>$v)
                    <option value="{{$k}}">{{$v[\App::getLocale()]}}</option>
                    @endforeach
                  </select>
                  <input class="" placeholder="" name="tourist[adult][zhengjian][]" onclick="removeError(this)">
                </div>
                <div class="passenger-msg-tip">
                  <i class="iconfont icon-evening"></i>
                  <span>{{trans('tour.wenxintishi_detail')}}</span>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.birther_day')}}:</span>
                  <input class="middle datePick" name="tourist[adult][birther_day][]" readonly onclick="removeError(this)">
                  <span class="order-msg-label">{{trans('tour.phone')}}:</span>
                  <input class="" placeholder="({{trans('tour.bitian')}})" name="tourist[adult][phone][]" onclick="removeError(this)">
                </div>
              </div>
              </div>
              
  </div>
  <div class="childPassengerMsg hide">
  <div class="order-write-msg-title">
              <span>
              {{trans('tour.lvke_xinxi')}}({{trans('tour.child')}})
              </span>
            </div>
            <div class="order-write-msg-main">
              <div class="passenger-msg">
                <div class="order-write-msg-item">
                  <div class="iBlock">
                    <span class="order-msg-label">{{trans('tour.name')}}:</span>
                    <input placeholder="({{trans('tour.bitian')}})" name="tourist[child][name][]" onclick="removeError(this)">
                  </div>
                  <div class="iBlock">
                    <div class="radio-warp">
                    <span class="radio cur" data-val="1">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.xiansheng')}}</span>
                    </div>
                    <div class="radio-warp">
                    <span class="radio" data-val="2">
                      <i class="iconfont wxz icon-unselected3"></i>
                      <i class="iconfont xz icon-selected3"></i>
                    </span>
                      <span>{{trans('tour.nvshi')}}</span>
                    </div>
                    <input class="hide" name="tourist[child][sex][]" value="1">
                  </div>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.english')}}{{trans('tour.name')}}:</span>
                  <input class="" placeholder="{{trans('tour.english_xing')}}" name="tourist[child][englishXing][]" onclick="removeError(this)">
                  <input class="" placeholder="{{trans('tour.english_name')}}" name="tourist[child][englishName][]" onclick="removeError(this)">
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.zhengjian_info')}}:</span>
                  <select class="" name="tourist[child][zhengjianType][]" >
                  @foreach(config('tour.zhengjian') as $k=>$v)
                    <option value="{{$k}}">{{$v[\App::getLocale()]}}</option>
                    @endforeach
                  </select>
                  <input class="" placeholder="" name="tourist[child][zhengjian][]" onclick="removeError(this)">
                </div>
                <div class="passenger-msg-tip">
                  <i class="iconfont icon-evening"></i>
                  <span>{{trans('tour.wenxintishi_detail')}}</span>
                </div>
                <div class="order-write-msg-item">
                  <span class="order-msg-label">{{trans('tour.birther_day')}}:</span>
                  <input class="middle datePick" name="tourist[child][birther_day][]" readonly onclick="removeError(this)">
                  <span class="order-msg-label">{{trans('tour.phone')}}:</span>
                  <input class="" placeholder="({{trans('tour.bitian')}})" name="tourist[child][phone][]" onclick="removeError(this)">
                </div>
              </div>
  </div>
  </div>
</section>
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/src/package-order.js')}}"></script>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>

$(function(){
	$('#departure_date').change(function() {
				var text = $(this).val();
				var returnDate = $('#departure_date').find("option:selected")
						.attr("data-returnDate");
				$('.pt-begin').text(text);
				$('.pt-end').text(returnDate);
			});
	  $(document).on("click", ".datePick", function () {
		    $(this).datepicker({
		      dateFormat:"yy-mm-dd",
		     // numberOfMonths:2,
		      //showMonthAfterYear:true,
		      //showOtherMonths:true,
		      changeYear:true,
		      yearRange: "-150:+0",
		      changeMonth : true,
		    }).datepicker('show');
		  });
});
</script>
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
    '<span class="warn"><span class="lgfork"></span>长度在{0}-{1}之间，请重新输入</span>');
    jQuery.validator.addMethod("weixinOrqq",
    function(value, element) {
        return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
    },
    '<span class="warn"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
    jQuery.validator.addMethod("isMobile",
    function(value, element) {
        var length = value.length;
        return this.optional(element) || (/(^1(3|4|5|7|8)[0-9]{9}$)|(^(\d{3})[-]?(\d{8})$|^(\d{4})[-]?(\d{7,8})$)/.test(value))
    },
    '<span class="warn"><span class="lgexm"></span>请填写正确的手机号</span>');
    jQuery.validator.addMethod("checkName",
    function(value, element) {
        return this.optional(element) || /^([\u4e00-\u9fa5]|[A-Za-z])+$/.test(value)
    },
    '<span class="warn"><span class="lgfork"></span>联系人名字格式错误</span>');
    $('.order-write-form').validate({
        rules: {
            adult_num: {
                required: true,
                number: true,
                min: 2,
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
        },
        messages: {
            adult_num: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>',
                number: '<span class="error" style="color: red; display: inline;">' + "{{trans('validation.tour.adult_num')}}" + '</span>',
                min: '<span class="error" style="color: red; display: inline;">' + "{{trans('validation.tour.adult_num')}}" + '</span>',
            },
            contact_name: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>',
                checkName: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>',
            },
            contact_email: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>',
                email: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>',
            },
            contact_phone: {
                required: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>',
                isMobile: '<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>'
            },
        },
        errorPlacement: function(error, element) {
            //layer.msg('aa');
            $(element).focus();
            element.after(error);
        },
        success: function(label) {
            label.html('<span class="lgtick"></span>')
        },
        focusInvalid: false,
        onkeyup: false,
        submitHandler: function(form) {
            //alert();
            if (parseInt($('input[name="adult_num"]').val()) < 1) {
                layer.msg("{{trans('validation.tour.adult_num')}}", {
                    icon: 2
                });
                return false;
            }
            if (!parseInt($('input[name="contact_gender"]').val())) {
                layer.msg("{{trans('validation.tour.contact_gender')}}", {
                    icon: 2
                });
                return false;
            }
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
            CheckName('tourist[adult][name][]');
            CheckName('tourist[child][name][]');
            CheckABCName('tourist[adult][englishXing][]');
            CheckABCName('tourist[child][englishName][]');
            CheckABCName('tourist[adult][englishName][]');
            CheckABCName('tourist[child][englishXing][]');
            checkZhengjian('tourist[child][zhengjian][]');
            checkZhengjian('tourist[adult][zhengjian][]');
            checkPhone('tourist[child][phone][]');
            checkPhone('tourist[adult][phone][]');
            CheckBirtherDay('tourist[child][birther_day][]');
            CheckBirtherDay('tourist[adult][birther_day][]');
            //CheckPhone('a');
            if (CheckName('tourist[adult][name][]', 2) && CheckName('tourist[child][name][]', 2) && CheckABCName('tourist[adult][englishXing][]', 2) && CheckABCName('tourist[child][englishName][]', 2) && CheckABCName('tourist[adult][englishName][]', 2) && CheckABCName('tourist[child][englishXing][]', 2) && checkZhengjian('tourist[child][zhengjian][]', 2) && checkZhengjian('tourist[adult][zhengjian][]', 2) && checkPhone('tourist[child][phone][]', 2) && checkPhone('tourist[adult][phone][]', 2) && CheckBirtherDay('tourist[child][birther_day][]', 2) && CheckBirtherDay('tourist[adult][birther_day][]', 2)) {

                form.submit();
            }
            // return false;
        },
    });
    function CheckName(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('.order-msg input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if (! (/^([\u4e00-\u9fa5]|[A-Za-z])+$/.test($(this).val()))) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
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
    function CheckABCName(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('.order-msg input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if (! (/^[A-Za-z]+$/.test($(this).val()))) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
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
    function checkZhengjian(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('.order-msg input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if ($(this).prev().val() == 2) {
                if (! (/^([\d]|[\w])+$/.test($(this).val()))) {
                    if (displayError == 1) {
                        $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
                        $(this).focus();
                    }
                    flag = false;
                    return false;
                    //onblurCheck=false;
                    //layer.msg("{{trans('validation.tour.wrong_format')}}",{icon: 2});
                }
            } else if ($(this).prev().val() == 1) {
                if (! (/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test($(this).val()))) {
                    if (displayError == 1) {
                        $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
                        $(this).focus();
                    }
                    flag = false;
                    return false;
                    //onblurCheck=false;
                    //layer.msg("{{trans('validation.tour.wrong_format')}}",{icon: 2});
                }
            }
        });
        return flag;
    }
    function checkPhone(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('.order-msg input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                    $(this).focus();
                }
                flag = false;
                return false;
            }
            if (! (/(^1(3|4|5|7|8)[0-9]{9}$)|(^(\d{3})[-]?(\d{8})$|^(\d{4})[-]?(\d{7,8})$)/.test($(this).val()))) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.wrong_format')}}" + '</span>');
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
    function CheckBirtherDay(inputName, displayError) {
        flag = true;
        var displayError = arguments[1] ? arguments[1] : 1;
        $('.order-msg input[name="' + inputName + '"]').each(function() {
            if (!$(this).val()) {
                if (displayError == 1) {
                    $(this).after('<span class="error" style="color: red; display: inline;font-size: 14px;">' + "{{trans('validation.tour.must')}}" + '</span>');
                    $(this).focus();
                }
                flag = false;
                return false;
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
