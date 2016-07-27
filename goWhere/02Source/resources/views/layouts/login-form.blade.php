<div class="full-shade hide"></div>
<div class="login-popup hide">
  <div class="login-close">
    <i class="iconfont icon-guanbi"></i>
  </div>
  <p class="l-title">{{trans('common.login_welcome')}}</p>
  <form class="login-form" method="post" action="{{url('auth/login')}}">
    <div class="form-group">
      <span class="label">{{trans('common.username')}}</span>
      <input class="need-verify" name="identity" datatype="*" nullmsg="{{trans('message.fe_username_should_filled')}}" placeholder="{{trans('common.login_identity_placeholder')}}">
      <p class="verify-tip"></p>
    </div>
    <div class="form-group">
      <span class="label">{{trans('common.password')}}</span>
      <input type="password" class="need-verify" name="password" datatype="psd" errormsg="{{trans('message.fe_password_format_error')}}" nullmsg="{{trans('message.fe_password_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
      <a class="l-link" href="{{url('auth/password/1')}}">{{trans('common.forget_password')}}</a>
      <p class="verify-tip"></p>
    </div>
    <div class="form-group">
      <span class="label">{{trans('common.captcha')}}</span>
      <input class="need-verify" name="captcha" datatype="*" nullmsg="{{trans('message.fe_captcha_should_filled')}}" placeholder="{{trans('message.fe_required_field')}}">
      <img class="get-captcha" data-src="{{url('auth/captcha').'/'}}">
      <p class="verify-tip"></p>
    </div>
    <div class="l-remember">
      <span class="radio">
        <i class="iconfont wxz icon-unselected2"></i>
        <i class="iconfont xz icon-selected2"></i>
      </span>
      <span>{{trans('common.remember_me')}}</span>
    </div>
      <a id="loginBtn" class="l-btn">{{trans('common.login')}}</a>
    <p class="l-tip">{{trans('common.register_tip')}}<a class="l-link" href="{{url('auth/register')}}">{{trans('common.register_right_now')}}</a></p>
  </form>
</div>