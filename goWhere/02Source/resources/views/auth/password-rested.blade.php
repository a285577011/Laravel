@extends('auth.password')

@section('title', trans('member.reset_succ'))

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.reset_succ')}}</div>
@endsection


@section('passwordContent')
<div class="find-psd-success-tip" style="margin-top: 70px">
    <div class="suc-icon">
        <i class="iconfont icon-checked"></i>
    </div>
    <p class="s1">{{trans('member.reset_password_succ')}}</p>
    <p class="p1">{!!trans('member.register_succ_login_tip')!!}</p>
</div>
@endsection