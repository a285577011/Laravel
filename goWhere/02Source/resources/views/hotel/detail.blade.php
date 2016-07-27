<?php
use App\Helpers\Common;
use App\Models\Area;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
?>
@extends('layouts.master')
 @section('title',trans('common.order_hotel'))

 @section('style') @parent
<link href="{{ asset('/css/lib/jquery.ad-gallery.css') }}" rel="stylesheet"
	type="text/css">
  <link rel="stylesheet" href="{{ asset('/css/src/hotel.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/src/hotel-inner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/jquery.nstSlider.css') }}">
@stop 
@section('navClass','ow-inner-nav')
@section('content')
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
        <span>Moni Gallery Hostel(莫尼画廊旅馆)</span>
      </div>
    </div>
<div class="hotel-search-main">
  <form  action="{{url('hotel/list')}}" id="hotelSearchForm" >
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
      <input id="dateEnd" class="m-input" name="checkout"  value="{{Input::get('checkout')}}" readonly>
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
    <input class="child-ages-array hide" name="child_age" value="{{Input::get('child_age')}}">
    <button class="hotel-search-main-form-btn">{{trans('tour.submit')}}</button>
</form>
</div>
  </div>
</section>
<section class="hotel-search-result">
<div class="hotel-search-result-warp">
<div class="hotel-search-result-header clear">
  <img src="../img/hotel_logo.jpg">

  <div class="hotel-search-result-header-text">
    <p class="hotel-search-result-header-text-name">Moni Gallery Hostel(莫尼画廊旅馆)
        <span class="hotelStar">
          <i class="iconfont icon-star"></i>
          <i class="iconfont icon-star"></i>
          <i class="iconfont icon-star"></i>
          <i class="iconfont icon-star"></i>
          <i class="iconfont icon-star"></i>
        </span>
    </p>

    <p class="hotel-search-result-header-text-address">
      263 Lavender Street,新加坡,338795,新加坡
    </p>
  </div>
</div>
<div class="hotel-search-detail clear">
<div class="hotel-search-detail-main">
<!--hotel详情页轮播图-->
<div id="gallery" class="ad-gallery">
  <div class="ad-image-wrapper">
  </div>
  <div class="ad-nav">
    <div class="ad-thumbs">
      <ul class="ad-thumb-list">
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
        <li>
          <a href="../hotelImg/hotel_b_01.jpg">
            <img src="../hotelImg/hotel_s_01.jpg" class="image0">
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<!--hotel详情页轮播图-->
<div class="hotel-room-msg mt20">
<ul class="hotel-room-msg-header clear">
  <li class="hotel-room-msg-header-li hotel-room-msg-header-li-cur"><a>房形价格</a></li>
  <li class="hotel-room-msg-header-li"><a>设施服务</a></li>
  <li class="hotel-room-msg-header-li"><a>住客点评</a></li>
</ul>
<div class="room-search mt20">
<!--<form class="room-search-form">
  <div class="hotel-search-main-form-item">
    <label>入住日期</label>
    <input class="hotel-search-main-form-item-short-input room-datePick room-date-pick-start" readonly>
  </div>
  <div class="hotel-search-main-form-item">
    <label>退房日期</label>
    <input class="hotel-search-main-form-item-short-input room-datePick room-date-pick-end" readonly>
  </div>
  <div class="hotel-search-main-form-item">
    <label>人数</label>
    <input class="hotel-search-main-form-item-short-input" placeholder="2成人0儿童">
  </div>
  <button class="hotel-search-main-form-btn">搜索</button>
</form> -->
<div class="room-search-result">
  <table class="room-search-result-table">
    <tr class="room-search-result-th">
      <td width="20%">房型</td>
      <td width="20%">取消条款</td>
      <td width="15%">人数上限</td>
      <td width="15%">价格</td>
      <td width="15%">房间设备</td>
      <td width="15%"></td>
    </tr>
    <tr class="room-search-result-tr">
      <td class="room-type">风格单人房</td>
      <td>不可取消修改</td>
      <td>2</td>
      <td>
        <p class="room-price">￥599</p>

        <p>(含税/服务税)</p>
      </td>
      <td><i class="iconfont icon-hanzaocan"></i>含早餐</td>
      <td><a href="{{url('hotel/order').'?'.http_build_query(Input::get())}}">预定</a></td>
    </tr>
    <tr class="room-search-result-tr">
      <td class="room-type">风格单人房</td>
      <td>不可取消修改</td>
      <td><i class="iconfont icon-fangke"></i><i class="iconfont icon-fangke"></i></td>
      <td>
        <p class="room-price">￥599</p>

        <p>(含税/服务税)</p>
      </td>
      <td><i class="iconfont icon-hanzaocan"></i>含早餐</td>
      <td><a>预定</a></td>
    </tr>
    <tr class="room-search-result-tr">
      <td class="room-type">风格单人房</td>
      <td>不可取消修改</td>
      <td>2</td>
      <td>
        <p class="room-price">￥599</p>

        <p>(含税/服务税)</p>
      </td>
      <td><i class="iconfont icon-hanzaocan"></i>含早餐</td>
      <td><a>预定</a></td>
    </tr>
    <tr class="room-search-result-tr">
      <td class="room-type">风格单人房</td>
      <td>不可取消修改</td>
      <td>2</td>
      <td>
        <p class="room-price">￥599</p>

        <p>(含税/服务税)</p>
      </td>
      <td><i class="iconfont icon-hanzaocan"></i>含早餐</td>
      <td><a>预定</a></td>
    </tr>
  </table>
</div>
<div class="hotel-introduction-facilities mt20">
  <div class="hotel-introduction-facilities-title clear">
    <img src="../img/border-left.png">
    <span>酒店设施</span>
  </div>
  <div class="hotel-introduction mt20">
    <p class="hotel-introduction-title">酒店介绍</p>

    <p class="hotel-introduction-main">客人可以在共用厨房使用微波炉和电冰箱。自动售货机供应茶和咖啡等热饮。花园里提供免费的简单早餐和全天小吃供客人享用。
      酒店退房后还可以免费寄存行李。旅馆提供PC笔记本电脑，MacBook和iPad供宾客使用，不收取额外费用。宾客可在藏书丰富的图书馆阅
      读杂志和书籍。酒店离樟宜国际机场（Changi International Airport）有20分钟车程。乘坐火车从酒店前往
      Dhoby Ghaut MRT Station地铁口需要5分钟，地铁口坐落于备受欢迎的乌节路（Orchard Road）的起始端。Moni Gallery Hostel
      酒店离City Square Shopping Mall购物中心和小印度（Little India）有10分钟路程。共用浴室设有淋浴。仅限女性居住的宿舍式
      客房或混合宿舍式客房拥有色彩明艳的墙壁，均配备了空调、卫生的床单和个人储物柜。酒店离Boon Keng地铁口只有5分钟路程，
      设有一个带平面电视、Playstation视频游戏机和乒乓球设施的休闲娱乐区。Moni Gallery Hostel酒店是一家色彩缤纷、
      独具特色的酒店，房间陈设有原创艺术品和雕塑，设有免费wifi和自助式洗衣设施。</p>

    <p class="hotel-introduction-tel">电话0081-476-320032&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;传真0081-476-32003</p>
  </div>
  <div class="hotel-facilities mt20">
    <p class="hotel-introduction-title">酒店设施</p>
    <ul class="hotel-facilities-main clear">
      <li>
        <i class="iconfont icon-hanzao"></i>

        <p>早餐</p>
      </li>
      <li>
        <i class="iconfont icon-disabled"></i>

        <p>残疾人通道</p>
      </li>
      <li>
        <i class="iconfont icon-kongtiao"></i>

        <p>空调</p>
      </li>
      <li>
        <i class="iconfont icon-heating"></i>

        <p>暖气</p>
      </li>
      <li>
        <i class="iconfont icon-bicycle"></i>

        <p>自行车</p>
      </li>
      <li>
        <i class="iconfont icon-xinglifuwu"></i>

        <p>行李服务</p>
      </li>
      <li>
        <i class="iconfont icon-baoxianxiang"></i>

        <p>保险箱</p>
      </li>
      <li>
        <i class="iconfont icon-parking"></i>

        <p>停车场</p>
      </li>
      <li>
        <i class="iconfont icon-bcs"></i>

        <p>B/C/S</p>
      </li>
      <li>
        <i class="iconfont icon-tv"></i>

        <p>电视休息区</p>
      </li>
    </ul>
  </div>
</div>
<div class="hotel-around-hotel">
  <p class="hotel-around-hotel-title">附近酒店</p>
  <ul class="hotel-around-hotel-ul clear">
    <li>
      <img src="../img/hotel01.jpg">

      <div class="hotel-around-hotel-main">
        <p class="fs14 c6">Madera Hong Kong Hotel</p>

        <div class="fl">
              <span class="hotelStar">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </span>
          <br/>
          <span class="fs14 c9">0.1 miles</span>
        </div>
        <p class="fs12 c6 fr">
          <span class="fs18 main-color">￥6666</span>起
        </p>
      </div>
    </li>
    <li>
      <img src="../img/hotel01.jpg">

      <div class="hotel-around-hotel-main">
        <p class="fs14 c6">Madera Hong Kong Hotel</p>

        <div class="fl">
              <span class="hotelStar">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </span>
          <br/>
          <span class="fs14 c9">0.1 miles</span>
        </div>
        <p class="fs12 c6 fr">
          <span class="fs18 main-color">￥6666</span>起
        </p>
      </div>
    </li>
    <li>
      <img src="../img/hotel01.jpg">

      <div class="hotel-around-hotel-main">
        <p class="fs14 c6">Madera Hong Kong Hotel</p>

        <div class="fl">
              <span class="hotelStar">
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
                <i class="fs12 iconfont icon-star"></i>
              </span>
          <br/>
          <span class="fs14 c9">0.1 miles</span>
        </div>
        <p class="fs12 c6 fr">
          <span class="fs18 main-color">￥6666</span>起
        </p>
      </div>
    </li>
  </ul>
</div>
</div>
</div>
</div>
<div class="hotel-search-detail-other">
  <div class="hotel-search-detail-comment">
    <div class="hotel-search-detail-comment-one clear">
      <div class="form-lodger">
        <p>90%用户推荐</p>

        <p class="c_blue">源自80位住客评价</p>
      </div>
      <div class="hotel-point">
        <span class="fs26 c_blue">4.0</span>/5分
      </div>
    </div>
    <div class="hotel-search-detail-comment-two">
      <i class="iconfont icon-quotes2"></i>

      <p>初次來购物，重点自由行的选择！ 位置好，房租中等，交通便捷～对面的APM后面的巷弄里就是这附近的美食集中地区</p>
      <i class="iconfont icon-quotes"></i>
    </div>
  </div>
  <div id="hotelMap" class="hotel-map"></div>
  <div class="hotel-around">
    <p class="fs20 c6">酒店周边信息</p>
    <ul class="hotel-around-ul clear">
      <li class="hotel-around-li hotel-around-cur">
        <span>景点</span>
        <hr>
      </li>
      <li class="hotel-around-li">
        <span>地铁</span>
        <hr>
      </li>
      <li class="hotel-around-li">
        <span>机场</span>
        <hr>
      </li>
      <li class="hotel-around-li">
        <span>车站</span>
        <hr>
      </li>
    </ul>
    <div class="hotel-around-ul-result">
      <ul class="spot-result">
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.3公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.3公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.3公里</p>
        </li>
      </ul>
      <ul class="subway-result hide">
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.4公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.4公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.4公里</p>
        </li>
      </ul>
      <ul class="airport-result hide">
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.5公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.5公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.5公里</p>
        </li>
      </ul>
      <ul class="station-result hide">
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.6公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.6公里</p>
        </li>
        <li>
          <p class="c6 fl">幸信站(Haengsin Station)</p>

          <p class="main-color fl">2.6公里</p>
        </li>
      </ul>
    </div>
  </div>
  <div class="hotel-search-result-history">
    <p class="hotel-search-result-history-title">我浏览过的酒店</p>
    <ul>
      <li class="hotel-search-result-history-li clear">
        <img src="../img/hotel01.jpg">

        <div class="hotel-search-result-history-li-text">
          <p>Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里</p>

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
          <p>Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里</p>

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
          <p>Fraser Suites Le Claridge Champs-Elysées(香榭丽舍克拉里</p>

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
@endsection @section('script') @parent
<script src="{{ asset('/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{ asset('/js/lib/jquery-ui-1.10.3.min.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.ad-gallery.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.nstSlider.js')}}"></script>
<script src="{{ asset('/js/lib/juicer.js')}}"></script>
<script src="{{ asset('/js/lib/jquery.dotdotdot.min.js')}}"></script>
<script src="{{ asset('/js/src/zzsc.js')}}"></script>
<script src="http://ditu.google.cn/maps/api/js?sensor=false&language=zh-CN&callback=initialize&key=AIzaSyA-qk722H03vsGZO5nakrQlf-KCzZSQ8vE" charset="utf-8" async defer></script>
<script src="{{ asset('/js/src/hotelInner.js')}}"></script>
<script src="{{ asset('/js/src/hotel_detail.js')}}"></script>
<script>
function initialize() {
  var mapProp = {
    center: new google.maps.LatLng(10, -0.120850),
    zoom: 6,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("hotelMap"), mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!--  <script src="{{ asset('/areaSelect/citylist.js')}}"></script>-->
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
<link href="{{ asset('/areaSelect/cityquery.css')}}" rel="stylesheet" type="text/css" />
{!!App\Models\Area::getSelectJs()!!}
<script src="{{ asset('/js/src/zzsc.js')}}"></script>
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
