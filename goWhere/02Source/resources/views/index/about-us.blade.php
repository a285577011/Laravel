@extends('index.misc')

@section('title', trans('index.about_us'))

@section('misc-content')
<!-- 关于我们 -->
<section class="about-us">
  <img class="about-banner" src="{{asset('/img/about-banner.jpg')}}">
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.orangeway_brief')}}</span>
    </div>
    <div class="about-content">
      {!!trans('misc.orangeway_brief_content')!!}
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.products_service')}}</span>
    </div>
    <div class="about-content">
      {!!trans('misc.products_service_content')!!}
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.operating_model')}}</span>
    </div>
    <div class="about-content">
      {!!trans('misc.operating_model_content')!!}
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.orangeway_advantages')}}</span>
    </div>
    <div class="about-content">
        {!!trans('misc.orangeway_advantages_content')!!}
    </div>
  </div>
</section>
<!-- 关于我们 -->
@endsection
