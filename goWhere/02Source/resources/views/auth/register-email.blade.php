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
        <div class="progress-step-num">
          <i class="iconfont icon-gou"></i>
        </div>
        <div class="progress-step-text">{{trans('member.choose_register_type')}}</div>
      </div>
      <div class="progress-step-bar progress-step-bar-cur">
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
    <p class="fs14 c6 center">{{trans('member.complete_form_tip')}}</p>
    <hr class="reg-hr">
    <form class="reg-by-email reg-form" method="post" action="{{url('auth/register/2')}}">
      <div class="form-group">
        <span class="label">{{trans('common.email')}}</span>
        <input name="email" class="l-input" datatype="e" nullmsg="{{trans('message.fe_email_should_filled')}}" errormsg="{{trans('message.fe_email_format_error')}}" placeholder="{{trans('message.fe_required_field')}}">
        <p class="verify-tip">{{$errors->first('email')}}</p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.username')}}</span>
        <input name="username" class="l-input" datatype="username" nullmsg="{{trans('message.fe_username_should_filled')}}" errormsg="{{trans('message.fe_username_format_error')}}" placeholder="{{trans('message.fe_username_placeholder')}}">
        <p class="verify-tip">{{$errors->first('username')}}</p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.password')}}</span>
        <input name="password" type="password" class="l-input" datatype="psd" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
        <p class="verify-tip">{{$errors->first('password')}}</p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.password_confirmation')}}</span>
        <input name="password_confirmation" type="password" class="l-input" datatype="psd" psdWrong="{{trans('message.fe_password_not_match')}}" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
        <p class="verify-tip"></p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.captcha')}}</span>
        <input name="captcha" class="s-input" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
        <img class="ss get-captcha" src="{{asset('auth/captcha/'.mt_rand())}}">
        <p class="verify-tip">{{$errors->first('captcha')}}</p>
      </div>
      <a class="reg-form-btn j-reg-email">{{trans('common.submit')}}</a>
    </form>
    <div class="reg-email-msg hide">
      <i class="iconfont icon-checked"></i>
      <p class="p1">{{trans('member.register_mail_sent_to')}}<span class="new-email">@</span></p>
      <p class="p2">{{trans('member.register_mail_sent_brace')}}</p>
      <p class="p3">{{trans('member.register_mail_validate_period', ['time'=>config('member.registerConfirmMail.expire')/60])}}</p>
      <a class="go-email" href="" target="_blank">{{trans('member.register_mail_check_now')}}</a>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/reg.js')}}"></script>
@endsection

@section('inner-script')
@endsection