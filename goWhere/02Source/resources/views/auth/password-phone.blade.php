@extends('auth.password')

@section('title', trans('member.identify_yourself'))

@section('header-nav-content')
<div class="header-reg-text">{{trans('member.identify_yourself')}}</div>
@endsection


@section('passwordContent')
    <form class="find-form" method="post" action="{{url('auth/password/resetForm')}}">
      {!!csrf_field()!!}
      <div class="form-group">
        <span class="label">{{trans('common.cellphone')}}</span>
        <span class="fs14 c6">{{\App\Helpers\Common::maskPhone($identity)}}</span>
        <input name="phone" class ="no-valid" type="hidden" value="{{$identity}}" />
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.captcha')}}</span>
        <input name="captcha" class="s-input" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
        <img class="ss get-captcha" src="{{asset('auth/captcha/'.mt_rand())}}">
        <p class="verify-tip">{{$errors->first('captcha')}}</p>
      </div>
      <div class="form-group">
        <span class="label">{{trans('common.sms_captcha')}}</span>
        <input class="s-input" name="smsCaptcha" datatype="*" nullmsg="{{trans('message.fe_smscaptcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
        <a class="ss get-phone-code">{{trans('common.get_captcha')}}</a>
        <p class="verify-tip">{{$errors->first('smsCaptcha')}}</p>
      </div>
      <a class="reg-form-btn find-psd">{{trans('common.confirm')}}</button>
    </form>
@endsection