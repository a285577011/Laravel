@extends('layouts.master')
 @section('title',trans('mice.detail'))
 @section('style') @parent
<link href="{{ asset('/css/src/case-detail.css') }}" rel="stylesheet"
	type="text/css">
@stop
@section('navClass','ow-inner-nav')
@section('content')
<section class="case-head">
  <div class="case-bg">
    <img src="@storageAsset($data['baseData']->image)">
  </div>
  <div class="case-text clear">
    <div class="quote">
      <i class="iconfont icon-quotes3"></i>
    </div>
    <div class="text fl">
      <span>{!!$data['infoData']->service_content!!}</span>
    </div>
    <div class="case-logo fr">
      <!--<img src="{{ asset('/images/case-logo.jpg')}}">-->
    </div>
  </div>
</section>
<section class="case-main">
  <div class="case-main-warp">
    <p class="case-title">{{$data['infoData']->title}}</p>
    <ul class="case-container">
{!!$data['infoData']->desc!!}
    </ul>
  </div>
</section>

@endsection
