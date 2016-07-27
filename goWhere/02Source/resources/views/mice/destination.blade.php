<?php
use App\Helpers\Common;
?>
@extends('layouts.master')
 @section('title',trans('mice.dest_detail'))
 @section('style') @parent
<link href="{{ asset('/css/src/ow-mice-destination.css') }}" rel="stylesheet"
	type="text/css">
@stop
@section('navClass','ow-inner-nav')
@section('content')
<section class="mice-destination-bg" data-bg="@storageAsset($data['baseData']->image)">
  <div class="bg-zzc"></div>
  <div class="warp clear">
    <div class="mice-snap">
      <p class="title">MICE {{trans('mice.kuaizhao')}}</p>
      <hr>
      <div class="items">
        <div class="item">
          <p class="p1">{{trans('mice.airport')}}</p>
          <p class="p2">{{$data['infoData']->airport}}</p>
        </div>
        <div class="item">
          <p class="p1">{{trans('mice.huiyi_rongliang')}}</p>

          <p class="p2">{{$data['baseData']->meeting_area}}{{trans('mice.pinfangmi')}}</p>
        </div>
        <div class="item">
          <p class="p1">{{trans('mice.huiyi_center')}}</p>

          <p class="p2">{{$data['baseData']->confer_center}}{{trans('mice.zuo')}}</p>
        </div>
        <div class="item">
          <p class="p1">{{trans('mice.zhusu_rongliang')}}</p>

          <p class="p2">{{$data['baseData']->hotel_num}}+{{trans('mice.jia_hotel')}}，{{$data['baseData']->hotel_rooms}}{{trans('mice.ge_room')}}</p>
        </div>
        <div class="item">
          <p class="p1">{{trans('mice.tese_huodong')}}</p>

          <p class="p2">{{$data['infoData']->feature}}</p>
        </div>
      </div>
      <a class="btn">{{trans('mice.lijizixun')}}</a>
    </div>
  </div>
</section>
<section class="destination-msg destination-introduction">
  <div class="warp">
    <div class="title clear">
      <div class="rect fl">
        <p class="p1">城市</p>

        <p class="p2">City</p>
      </div>
      <div class="out-rect fl">
        <p class="p1">简介</p>

        <p class="p2">Introduction</p>
      </div>
    </div>
    <div class="contain">
    {!!$data['infoData']->desc!!}
    </div>
  </div>
</section>
<section class="destination-msg destination-advantage">
  <div class="warp">
    <div class="title clear">
      <div class="rect fl">
        <p class="p1">城市</p>

        <p class="p2">City</p>
      </div>
      <div class="out-rect fl">
        <p class="p1">优势</p>

        <p class="p2">Advantage</p>
      </div>
    </div>
{!!$data['infoData']->advantage!!}
  </div>
</section>
<section class="destination-msg destination-meeting">
  <div class="warp">
    <div class="title clear">
      <div class="rect fl">
        <p class="p1">会议</p>

        <p class="p2">Meet</p>
      </div>
      <div class="out-rect fl">
        <p class="p1">场地</p>

        <p class="p2">ing venue</p>
      </div>
    </div>

{!!$data['infoData']->address!!}

  </div>
</section>
<section class="destination-msg attraction">
  <div class="warp">
    <div class="title clear">
      <div class="rect fl">
        <p class="p1">城市</p>

        <p class="p2">City</p>
      </div>
      <div class="out-rect fl">
        <p class="p1">景点</p>

        <p class="p2">Attraction</p>
      </div>
    </div>
{!!$data['infoData']->attractions!!}
    <div>

    </div>
  </div>
</section>
<section class="destination-msg case">
  <div class="warp">
    <div class="title clear">
      <div class="rect fl">
        <p class="p1">成功</p>

        <p class="p2">Succ</p>
      </div>
      <div class="out-rect fl">
        <p class="p1">案例</p>

        <p class="p2">essfull case</p>
      </div>
    </div>
    <ul class="case-list clear">
    @if($data['cases'])
    @foreach($data['cases'] as $v)
      <li>
        <a href="{{url('mice/casesdetail') . '/' . $v['id']}}"><img src="@storageAsset($v->image)"></a>
        <div class="text">
          <p class="p1">{{$v->infoData->title}}</p>
          <p class="p2">{{trans('mice.shijian')}}：{{date('Y-m-d',$v->start_time)}}</p>
          <p class="p2">{{trans('mice.renshu')}}：{{$v->people_num}}人</p>
          <p class="p2">{{trans('mice.fuwu_neirong')}}：{{$v->infoData->service_content}}</p>
          <div class="line"></div>
{!!$v->infoData->event_overview!!}
        </div>
      </li>
      @endforeach
      @endif
    </ul>
  </div>
</section>

@endsection
@section('script') @parent
<script>
  $(function () {
    var $bgBlock = $(".mice-destination-bg"),
      dataBG = $bgBlock.attr("data-bg");
    $bgBlock.css("background", "url(" + dataBG + ") no-repeat center");
  })
</script>
@stop