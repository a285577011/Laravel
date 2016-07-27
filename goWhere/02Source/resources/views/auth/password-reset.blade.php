@extends('auth.password')

@section('title', trans('member.reset_password'))

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.reset_password')}}</div>
@endsection


@section('passwordContent')
@if(isset($type) && $type == 1)
<form class="find-form" method="post" action="{{url('auth/password/resetByEmail')}}">
@else
<form class="find-form" method="post" action="{{url('auth/password/resetByPhone')}}">
@endif
    {!!csrf_field()!!}
    @if(isset($type) && $type == 1)
    <div class="form-group">
        <span class="label">{{trans('common.email')}}</span>
        <input name="token" class="no-valid" type="hidden" value="{{$token}}">
        <input name="email" class="l-input" datatype="e" nullmsg="{{trans('message.fe_email_should_filled')}}" errormsg="{{trans('message.fe_email_format_error')}}" placeholder="{{trans('message.fe_required_field')}}">
        <p class="verify-tip">{{$errors->first('email')}}</p>
    </div>
    @endif
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
    <a class="reg-form-btn find-psd">{{trans('common.submit')}}</a>
</form>
@endsection