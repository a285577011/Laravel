@extends('layouts.master')

@section('title', trans('member.member_register'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/reg.css')}}">
@endsection

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.member_register')}}</div>
@endsection

@section('content')
<section style="padding-bottom: 70px;background-color: #f5f5f5">
  <div class="reg-wrap">
    <!-- 进度条 begin -->
    <div class="progress-step clear">
      <div class="progress-bar-x1 mr2"></div>
      <div class="progress-bar-x2 mr3"></div>
      <div class="progress-bar-x3 mr5"></div>
      <div class="progress-step-bar progress-step-bar-cur">
        <div class="progress-step-num">1</div>
        <div class="progress-step-text">{{trans('member.choose_register_type')}}</div>
      </div>
      <div class="progress-step-bar">
        <div class="progress-step-num">2</div>
        <div class="progress-step-text">{{trans('member.complete_form')}}</div>
      </div>
      <div class="progress-step-bar mr5">
        <div class="progress-step-num">3</div>
        <div class="progress-step-text">{{trans('member.register_succ')}}</div>
      </div>
      <div class="progress-bar-x3 mr3"></div>
      <div class="progress-bar-x2 mr2"></div>
      <div class="progress-bar-x1"></div>
    </div>
    <!-- 进度条 end -->
    <p class="fs14 c6 center">{{trans('member.choose_register_type_tip')}}</p>
    <hr class="reg-hr">
    <div class="center">
      <div class="reg-phone">
        <a href="{{url('auth/register/1')}}">
          <i class="iconfont icon-phone4"></i>
        </a>
        <p>{{trans('common.phone')}}</p>
      </div>
      <div class="reg-email">
        <a href="{{url('auth/register/2')}}">
          <i class="iconfont icon-mail"></i>
        </a>
        <p>{{trans('common.email')}}</p>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
@endsection

@section('inner-script')
@endsection