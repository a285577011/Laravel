@extends('admin.layouts.master')
@section('title', '个人设置')
@section('content')
<form id="validation-form" class="form-horizontal" method="post">
    {!! csrf_field() !!}
    <div class="tabbable">
        <div class="tab-content profile-edit-tab-content">
            <div class="tab-pane active" id="edit-basic">
                <h4 class="header blue bolder smaller">基本信息</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="form-field-username" class="col-sm-3 control-label no-padding-right">用户名</label>
                            <div class="col-sm-9">
                                <input type="text" disabled value="{{$info->username or ''}}" name="username" placeholder="用户名" id="form-field-username" class="input-large">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label for="form-field-first" class="col-sm-3 control-label no-padding-right">姓名</label>
                            <div class="col-sm-9">
                                <input type="text" disabled value="{{$info->name or ''}}" name="name" placeholder="姓名" id="form-field-first" class="input-large">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space"></div>
                <h4 class="header blue bolder smaller">联系信息</h4>

                <div class="form-group">
                    <label for="form-field-email" class="col-sm-3 control-label no-padding-right">邮箱</label>

                    <div class="col-sm-9">
                        <span class="input-icon input-icon-right">
                            <input type="email" name="email" value="{{$info->email or ''}}" class="input-large" id="email">
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label for="form-field-phone" class="col-sm-3 control-label no-padding-right">手机</label>

                    <div class="col-sm-9">
                        <span class="input-icon input-icon-right">
                            <input type="text" id="phone" name="phone" value="{{$info->phone or ''}}" class="input-large input-mask-phone">
                            <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                        </span>
                    </div>
                </div>

                <div class="space"></div>
                <h4 class="header blue bolder smaller">安全信息</h4>
                <div class="tab-pane active" id="edit-password">
                    <div class="form-group">
                        <label for="form-field-pass1" class="col-sm-3 control-label no-padding-right">新密码</label>
                        <div class="col-sm-9">
                            <input type="password" id="password" name="password" class="input-large" placeholder="{{isset($info) ? '不修改请留空' : ''}}">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <label for="form-field-pass2" class="col-sm-3 control-label no-padding-right">确认新密码</label>
                        <div class="col-sm-9">
                            <input type="password" class="input-large" name="password_confirmation" id="password2">
                        </div>
                    </div>
                </div>
                <h4 class="header blue bolder smaller">角色信息</h4>
                <div class="tab-pane active" id="edit-password">
                    <div class="form-group">
                        <label for="form-field-pass1" class="col-sm-3 control-label no-padding-right"></label>
                        <div class="col-sm-9">
                            @foreach($userRoles as $role)
                            <span class="help-inline">
                                <label class="middle">
                                    <input type="checkbox" class="ace roleItem" checked value="{{$role->id}}" name="userRole[]" disabled />
                                    <span class="lbl">{{$role->display_name}}</span>&nbsp;&nbsp;
                                </label>
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn btn-info">
                <i class="ace-icon fa fa-check bigger-110"></i>
                保存
            </button>
            &nbsp; &nbsp;
            <button type="reset" class="btn">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                重置
            </button>
        </div>
    </div>
</form>
@endsection

@section('pageScript')
<!--[if lte IE 8]>
  <script src="{{asset('/admin/components/ExplorerCanvas/excanvas.js')}}"></script>
<![endif]-->
<script src="{{asset('/admin/components/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{asset('/admin/components/jquery-validation/dist/additional-methods.js')}}"></script>
<script src="{{asset('/admin/components/jquery-validation/src/localization/messages_zh.js')}}"></script>
@endsection

@section('inlineScript')
<script type="text/javascript">
jQuery(function($) {
jQuery.validator.addMethod("phone", function (value, element) {
return this.optional(element) || /(^1(3[0-9]|4[57]|5[0-35-9]|7[6-8]|8[0-9])\d{8}$)|(^170[0-25]\d{7}$)/.test(value);
}, "{{trans('validation.cnphone')}}");
$('#validation-form').validate({
errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
        email: {
        required: true,
                email:true,
                maxlength:255
        },
                password: {
                {{!isset($info) ? 'required: true,' : ''}}
                minlength: 6
                },
                password_confirmation: {
                {{!isset($info) ? 'required: true,' : ''}}
                minlength: 6,
                        equalTo: "#password"
                },
                username: {
                required: true,
                        maxlength: 16
                },
                name: {
                required: true,
                        maxlength: 30
                },
                phone: {
                required: true,
                        phone: 'required'
                },
                "userRole[]": {
                    required: true
                }
        },
        messages: {
        },
        highlight: function (e) {
        $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
        $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
        $(e).remove();
        },
        errorPlacement: function (error, element) {
        if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
        var controls = element.closest('div[class*="col-"]');
        if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
        else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
        }
        else if (element.is('[type="password"]')) {
        error.insertAfter(element);
        }
        else if (element.is('.chosen-select')) {
        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
        }
        else error.insertAfter(element);
        },
        submitHandler: function (form) {
        form.submit();
        },
        invalidHandler: function (form) {
        }
});
});
</script>
@endsection