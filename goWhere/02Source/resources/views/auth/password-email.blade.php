@extends('auth.password')

@section('title', trans('member.identify_yourself'))

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.identify_yourself')}}</div>
@endsection


@section('passwordContent')
    <div class="reg-email-msg">
      <i class="iconfont icon-checked"></i>
      <p class="p1">{{trans('member.register_mail_sent_to')}}<span class="new-email">{{\App\Helpers\Common::maskEmail($identity)}}</span></p>
      <p class="p2">{{trans('member.register_mail_sent_brace')}}</p>
      <p class="p3">{{trans('member.register_mail_validate_period', ['time'=>config('auth.password.expire')/60])}}</p>
      @if(isset($mailLogin) && $mailLogin)
      <a class="go-email" href="{{$mailLogin}}" target="_blank">{{trans('member.register_mail_check_now')}}</a>
      @endif
    </div>
@endsection