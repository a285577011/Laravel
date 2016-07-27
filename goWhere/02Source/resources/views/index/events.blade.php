@extends('index.misc')

@section('title', trans('index.events'))

@section('misc-content')
<section>
  <img class="about-banner" src="{{asset('/img/events-banner.jpg')}}">
  <div class="event-title">
    <p class="p1">
      {{trans('misc.orangeway_events')}}
    </p>
    <p class="p2">
        {{trans('misc.orangeway_events_content')}}
    </p>
  </div>
  <div class="events-item odd clear">
    <img src="{{asset('/img/events1.jpg')}}">
    <div class="text">
      <p class="p1">
        {{trans('misc.event_1')}}
      </p>
      <p class="p2">
        {{trans('misc.event_1_content')}}
      </p>
    </div>
  </div>
  <div class="events-item even clear">
    <img src="{{asset('/img/events2.jpg')}}">
    <div class="text">
      <p class="p1">
        {{trans('misc.event_2')}}
      </p>
      <p class="p2">
        {{trans('misc.event_2_content')}}
      </p>
    </div>
  </div>
  <div class="events-item odd clear">
    <img src="{{asset('/img/events3.jpg')}}">
    <div class="text">
      <p class="p1">
        {{trans('misc.event_3')}}
      </p>
      <p class="p2">
          {{trans('misc.event_3_content')}}
      </p>
    </div>
  </div>
  <div class="events-item even clear">
    <img src="{{asset('/img/events4.jpg')}}">
    <div class="text">
      <p class="p1">
        {{trans('misc.event_4')}}
      </p>
      <p class="p2">
          {{trans('misc.event_4_content')}}
      </p>
    </div>
  </div>
</section>
@endsection
