@extends('layouts.master')

@section('title', trans('member.register_succ'))
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
        <div class="progress-step-num">
          <i class="iconfont icon-gou"></i>
        </div>
        <div class="progress-step-text">{{trans('member.choose_register_type')}}</div>
      </div>
      <div class="progress-step-bar progress-step-bar-cur">
        <div class="progress-step-num">
          <i class="iconfont icon-gou"></i>
        </div>
        <div class="progress-step-text">{{trans('member.complete_form')}}</div>
      </div>
      <div class="progress-step-bar progress-step-bar-cur mr5">
        <div class="progress-step-num">3</div>
        <div class="progress-step-text">{{trans('member.register_succ')}}</div>
      </div>
      <div class="progress-bar-x3 mr3"></div>
      <div class="progress-bar-x2 mr2"></div>
      <div class="progress-bar-x1"></div>
    </div>
    <!-- 进度条 end -->
    <div class="reg-success-tip" style="margin-top: 70px">
      <i class="iconfont icon-success"></i>
      <span class="s1">{{trans('member.register_succ_tip')}}</span>
    </div>
    <hr class="reg-hr">
    <div class="reg-success-tip">
      <p class="p1">{{trans('member.register_succ_active_tip')}}</p>
      <p class="p1">{!!trans('member.register_succ_login_tip')!!}</p>
    </div>
  </div>
</section>
@endsection

@section('script')
@endsection

@section('inner-script')
@endsection