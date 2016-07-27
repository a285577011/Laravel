@extends('layouts.master')

@section('title', trans('member.retrieve_password'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/reg.css')}}">
@endsection

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.retrieve_password')}}</div>
@endsection

@section('content')
<section style="padding-bottom: 70px;background-color: #f5f5f5">
  <div class="reg-wrap">
    <!-- 进度条 begin -->
    <div class="progress-step four-step clear">
      <div class="progress-bar-x1 mr2"></div>
      <div class="progress-bar-x2 mr3"></div>
      <div class="progress-bar-x3 mr5"></div>
      <div class="progress-step-bar @if(!isset($step) || $step>=1) progress-step-bar-cur @endif">
        <div class="progress-step-num">1</div>
        <div class="progress-step-text">{{trans('member.retrieve_password')}}</div>
      </div>
      <div class="progress-step-bar @if($step>=2) progress-step-bar-cur @endif">
        <div class="progress-step-num">2</div>
        <div class="progress-step-text">{{trans('member.identify_yourself')}}</div>
      </div>
      <div class="progress-step-bar @if($step>=3) progress-step-bar-cur @endif">
        <div class="progress-step-num">3</div>
        <div class="progress-step-text">{{trans('member.reset_password')}}</div>
      </div>
      <div class="progress-step-bar @if($step>=4) progress-step-bar-cur @endif">
        <div class="progress-step-num">4</div>
        <div class="progress-step-text">{{trans('member.reset_succ')}}</div>
      </div>
      <div class="progress-bar-x3 mr3"></div>
      <div class="progress-bar-x2 mr2"></div>
      <div class="progress-bar-x1"></div>
    </div>
    <!-- 进度条 end -->
    @section('passwordContent')
    <form class="find-form" action="{{url('auth/password/2')}}" method="post">
    {!!csrf_field()!!}
      <div class="form-group">
        <span class="label">{{trans('member.email_or_phone')}}</span>
        <input class="l-input has-error" name="identity" datatype="*" nullmsg="{{trans('message.fe_identity_should_filled')}}">
        <p class="verify-tip">{{$errors->first('identity')}}</p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.captcha')}}</span>
        <input class="s-input has-error" name="captcha" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}">
        <img class="ss get-captcha" src="{{asset('auth/captcha/'.mt_rand())}}">
        <p class="verify-tip">{{$errors->first('captcha')}}</p>
      </div>
        <a class="reg-form-btn find-psd">{{trans('common.submit')}}</a>
    </form>
    @show
  </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/find-psd.js')}}"></script>
@endsection

@section('inner-script')
@endsection