@extends('layouts.master')

@section('title', trans('member.account_setting'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/personal.css')}}">
@endsection

@section('content')
<section class="pc-warp clear">
    @include('member.left-sidebar')
    <div class="personal-modules">
        <div class="personal-module only-read-pi-msg">
            <div class="pc-title">
                <span>{{trans('member.personal_info')}}</span>
            </div>
            <div class="clear">
                <div class="pi-avatar">
                    <img @if($member->avatar) src="@storageAsset($member->avatar)" @else src="{{config('common.memberDefaultAvatar')}}" @endif>
                </div>
                <div class="pi-msg">
                    <p>
                        <span class="label">{{trans('common.nickname')}}</span>
                        <span>{{$member->nickname ?: trans('member.unfilled_yet')}}</span>
                    </p>

                    <p>
                        <span class="label">{{trans('common.account')}}</span>
                        <span>{{$member->username}}</span>
                    </p>

                    <p>
                        <span class="label">{{trans('common.true_name')}}</span>
                        <span>{{$member->name ?: trans('member.unfilled_yet')}}</span>
                    </p>

                    <p>
                        <span class="label">{{trans('common.gender')}}</span>
                        <span>@transLang($genderConf[$member->gender])</span>
                    </p>
                </div>
            </div>
            <a class="pi-modify">{{trans('common.modify')}}</a>
        </div>

        <div class="personal-module modify-pi-msg hide">
            <div class="pc-title">
                <span>{{trans('member.personal_info')}}</span>
            </div>
            <form class="clear" action="{{url('member/changeInfo')}}" method="POST" enctype ="multipart/form-data">
                {!!csrf_field()!!}
                <div class="pi-avatar">
                    <img class="pa-img" @if($member->avatar) src="@storageAsset($member->avatar)" @else src="{{config('common.memberDefaultAvatar')}}" @endif>
                    <a class="change-avatar">{{trans('member.change_avatar')}}</a>
                    <input class="pa-file hide" name="avatar" type="file">
                </div>
                <div class="pi-msg">
                    <p>
                        <span class="label">{{trans('common.nickname')}}</span>
                        <input name="nickname" value="{{$member->nickname}}">
                    </p>
                    <p>
                        <span class="label">{{trans('common.true_name')}}</span>
                        <input name="name" value="{{$member->name}}">
                    </p>

                    <p>
                        <span class="label">{{trans('common.gender')}}</span>
                        <span class="radio{{$member->gender==1 ? ' cur': ''}}" data-val="1">
                            <i class="iconfont wxz icon-unselected3"></i>
                            <i class="iconfont xz icon-selected3"></i>
                            <span>{{trans('common.male')}}</span>
                        </span>
                        <span class="radio{{$member->gender==2 ? ' cur': ''}}" data-val="2">
                            <i class="iconfont wxz icon-unselected3"></i>
                            <i class="iconfont xz icon-selected3"></i>
                            <span>{{trans('common.female')}}</span>
                        </span>
                        <input class="hide" name="gender" value="{{$member->gender}}">
                    </p>
                </div>
                <a class="pi-modify-ok">{{trans('common.confirm')}}</a>
                <a class="pi-modify-undo">{{trans('common.cancel')}}</a>
            </form>
        </div>

        <div class="personal-module">
            <div class="pc-title">
                <span>{{trans('member.security_setting')}}</span>
            </div>
            <div class="security-settings">
                <form>
                    <span class="s1 set-status">
                        @if($member->password_score < 10)
                        <i class="iconfont c-fail icon-guanbi"></i>
                        <i class="iconfont c-success icon-complete hide"></i>
                        @else
                        <i class="iconfont c-fail icon-guanbi hide"></i>
                        <i class="iconfont c-success icon-complete"></i>
                        @endif
                        {{trans('member.login_password')}}
                    </span>
                    <span class="s2 psd-level">{{$passInfo['text']}}</span>
                    <span class="s3">{{trans('member.password_8_to_20_letters')}}</span>
                    <a class="modify-btn">{{trans('common.modify')}}</a>
                    <div class="m-modify hide">
                        <div class="mm-item form-group">
                            <span class="label">{{trans('member.current_password')}}</span>
                            <input name="oldPsd" datatype="psd" type="password" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-item form-group">
                            <span class="label">{{trans('member.new_password')}}</span>
                            <input name="password" datatype="psd" type="password" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-item form-group">
                            <span class="label">{{trans('member.confirm_new_password')}}</span>
                            <input name="password_confirmation" type="password" datatype="psd" psdWrong="{{trans('message.fe_password_not_match')}}" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
	                    <span class="verify-tip"></span>
                        </div>
                        <div class="mm-btns">
                            <a class="mm-ok j-change-psd">{{trans('common.confirm')}}</a>
                            <a class="mm-undo">{{trans('common.cancel')}}</a>
                        </div>
                    </div>
                </form>
                <form>
                    <span class="s1 set-status">
                        @if($member->email_verify)
                        <i class="iconfont c-success icon-complete"></i>
                        <i class="iconfont c-fail icon-guanbi hide"></i>
                        @else
                        <i class="iconfont c-success icon-complete hide"></i>
                        <i class="iconfont c-fail icon-guanbi"></i>
                        @endif
                        {{trans('member.bind_email')}}
                    </span>
                    <span class="s2 cur-email">{{$maskEmail ? : trans('member.bind_none')}}</span>
                    <span class="s3 email-text">{{$member->email_verify ? trans('member.can_retrieve_password_thr_email') : trans('member.email_no_verified')}}</span>
                    <a class="modify-btn">{{trans('common.modify')}}</a>
                    <div class="m-modify hide">
                        <div class="mm-item">
                            <span class="label">{{trans('member.current_password')}}</span>
                            <input name="emailPsd" type="password" datatype="psd" nullmsg="{{trans('message.fe_password_should_filled')}}" errormsg="{{trans('message.fe_password_format_error')}}" placeholder="{{trans('message.fe_password_placeholder')}}">
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-item">
                            <span class="label">{{trans('member.new_email')}}</span>
                            <input name="newEmail" datatype="e" nullmsg="{{trans('message.fe_email_should_filled')}}" errormsg="{{trans('message.fe_email_format_error')}}" placeholder="{{trans('message.fe_required_field')}}">
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-btns">
                            <a class="mm-ok j-change-email">{{trans('common.confirm')}}</a>
                            <a class="mm-undo">{{trans('common.cancel')}}</a>
                        </div>
                    </div>
                </form>
                <div>
                    <span class="s1 set-status">
                        @if($member->mobile_verify)
                        <i class="iconfont c-success icon-complete"></i>
                        <i class="iconfont c-fail icon-guanbi hide"></i>
                        @else
                        <i class="iconfont c-success icon-complete hide"></i>
                        <i class="iconfont c-fail icon-guanbi"></i>
                        @endif
                        {{trans('member.bind_phone')}}
                    </span>
                    <span class="s2 cur-phone">{{$maskPhone ? : trans('member.bind_none')}}</span>
                    <span class="s3">{{$member->mobile_verify ? trans('member.can_retrieve_password_thr_phone') : trans('member.cannot_retrieve_password_thr_email')}}</span>
                    <a class="modify-btn" data-type="changePhone" data-val="{{$changePhoneStep}}">{{trans('common.modify')}}</a>
                    <form class="m-modify cp-step1 hide">
                        <div class="mm-item">
                            <span class="label">{{trans('member.current_phone')}}</span>
                            <span>{{$maskPhone ? : trans('member.bind_none')}}</span>
                        </div>
                        <div class="mm-item">
                            <span class="label">{{trans('common.sms_captcha')}}</span>
                            <input name="psc1" datatype="*" nullmsg="{{trans('message.fe_smscaptcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
                            <a class="get-verify phone-verify1" data-val="{{$userToken}}">{{trans('common.get_sms_captcha')}}</a>
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-btns">
                            <a class="mm-ok j-change-phone1">{{trans('common.confirm')}}</a>
                            <a class="mm-undo">{{trans('common.cancel')}}</a>
                        </div>
                    </form>
                    <form class="m-modify cp-step2 hide">
                        <div class="mm-item">
                            <span class="label">{{trans('member.new_phone')}}</span>
                            <input name="newPhone" datatype="m" nullmsg="{{trans('message.fe_phone_should_filled')}}" errormsg="{{trans('message.fe_phone_format_error')}}" placeholder="{{trans('message.fe_required_field')}}">
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-item">
				          <span class="label">{{trans('common.captcha')}}</span>
				          <input name="newPhoneCaptcha" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
				          <img class="phone-step2-captcha" style="display: inline-block;width: 90px;height: 30px;margin-left: 20px;vertical-align: middle;cursor: pointer" src="{{asset('auth/captcha/'.mt_rand())}}">
                                          <span class="verify-tip"></span>
				        </div>
                        <div class="mm-item">
                            <span class="label">{{trans('common.sms_captcha')}}</span>
                            <input name="psc2" datatype="*" nullmsg="{{trans('message.fe_smscaptcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
                            <a class="get-verify phone-verify2">{{trans('common.get_sms_captcha')}}</a>
                            <span class="verify-tip"></span>
                        </div>
                        <div class="mm-btns">
                            <a class="mm-ok j-change-phone2">{{trans('common.confirm')}}</a>
                            <a class="mm-undo">{{trans('common.cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/lib/jquery.pagination.js')}}"></script>
<script src="{{asset('/js/src/personal.js')}}"></script>
<script src="{{asset('/js/src/pc-info.js')}}"></script>
@endsection

@section('inner-script')

@endsection
