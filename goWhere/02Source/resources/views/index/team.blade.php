@extends('index.misc')

@section('title', trans('index.our_team'))

@section('misc-content')
<section class="about-us">
  <img class="about-banner" src="{{asset('/img/team-banner.jpg')}}">
  <div class="event-title">
    <p class="p1">
      {{trans('index.our_team')}}
    </p>
    <p class="p2">
      {{trans('misc.our_team_content')}}
    </p>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.reservation_department')}}</span>
    </div>
    <div class="about-content">
      <p>
          {{trans('misc.reservation_department_content')}}
      </p>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.operation_department')}}</span>
    </div>
    <div class="about-content">
      <p>
        {{trans('misc.operation_department_content')}}
      </p>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.technical_department')}}</span>
    </div>
    <div class="about-content">
      <p>
        {{trans('misc.technical_department_content')}}
      </p>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.overseas_department')}}</span>
    </div>
    <div class="about-content">
      <p>
        {{trans('misc.overseas_department_content')}}
      </p>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.customer_service_department')}}</span>
    </div>
    <div class="about-content">
      <p>
          {{trans('misc.customer_service_department_content')}}
      </p>
    </div>
  </div>
</section>
@endsection