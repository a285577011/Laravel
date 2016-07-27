@extends('index.misc')

@section('title', trans('index.our_partners'))

@section('misc-content')
<section class="about-us">
  <img class="about-banner" src="{{asset('/img/partner-banner.jpg')}}">
  <div class="event-title">
    <p class="p1">
      {{trans('index.our_partners')}}
    </p>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.travel_bureau')}}</span>
    </div>
    <ul class="partner-imgs clear">
      <li>
        <img src="{{asset('/img/partner1.jpg')}}">
      </li>
      <li>
        <img src="{{asset('/img/partner2.jpg')}}">
      </li>
      <li>
        <img src="{{asset('/img/partner3.jpg')}}">
      </li>
      <li>
        <img src="{{asset('/img/partner4.jpg')}}">
      </li>
      <li>
        <img src="{{asset('/img/partner5.jpg')}}">
      </li>
    </ul>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.media')}}</span>
    </div>
    <ul class="partner-imgs clear">
      <li>
        <img src="{{asset('/img/partner6.jpg')}}">
      </li>
    </ul>
  </div>
</section>
@endsection