@extends('layouts.master')

@section('title', trans('common.site_name'))

@section('style')
<link rel="stylesheet" href="{{asset('/css/lib/slick.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/ow-index.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/login.css')}}">
@endsection

@section('navClass', 'ow-inner-nav')

@section('content')
<section class="login-bg">
  <div class="login-main">
    <div class="login-warp">
      <p class="l-title">{{trans('common.login_welcome')}}</p>

      <form class="login-form" method="post" action="{{url('auth/login')}}">
        {!!csrf_field()!!}
        <div class="form-group">
          <span class="label">{{trans('common.username')}}</span>
          <input class="need-verify" name="identity" datatype="*" nullmsg="{{trans('message.fe_username_should_filled')}}" placeholder="{{trans('common.login_identity_placeholder')}}">

          <p class="verify-tip">{{$errors->first('identity')}}</p>
        </div>
        <div class="form-group">
          <span class="label">{{trans('common.password')}}</span>
          <input class="need-verify" type="password" name="password" datatype="psd" errormsg="{{trans('message.fe_password_format_error')}}" nullmsg="{{trans('message.fe_password_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
          <a class="l-link" href="{{url('auth/password/1')}}">{{trans('common.forget_password')}}</a>

          <p class="verify-tip">{{$errors->first('password')}}</p>
        </div>
        <div class="form-group">
          <span class="label">{{trans('common.captcha')}}</span>
          <input class="need-verify" name="captcha" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
          <img class="get-captcha" style="width:90px;" src="{{asset('auth/captcha/'.mt_rand())}}">

          <p class="verify-tip">{{$errors->first('captcha')}}</p>
        </div>
        <div class="l-remember">
      <span class="radio">
        <i class="iconfont wxz icon-unselected2"></i>
        <i class="iconfont xz icon-selected2"></i>
      </span>
          <span>{{trans('common.remember_me')}}</span>
        </div>
        <a id="login" class="l-btn">{{trans('common.login')}}</a>

        <p class="l-tip">{{trans('common.register_tip')}}<a class="l-link" href="{{url('auth/register')}}">{{trans('common.register_right_now')}}</a></p>
      </form>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/login.js')}}"></script>
@endsection

@section('inner-script')
<script type="text/javascript">
$(function(){
    $("#goLogin").unbind('click');
});
</script>
@endsection
