@extends('admin.layouts.master')
@section('title', '分配角色权限')
@section('content')
<form id="validation-form" class="form-horizontal" method="post">
    {!! csrf_field() !!}
    <div class="tabbable">
        <div class="tab-content profile-edit-tab-content">
            <div class="tab-pane active" id="edit-basic">
                <h4 class="header blue bolder smaller">角色信息</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right"></label>
                            <div class="col-sm-9">
                                {{$role->name}}
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right"></label>
                            <div class="col-sm-9">
                                {{$role->display_name}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space"></div>
                <h4 class="header blue bolder smaller">权限信息</h4>
                <div class="tab-pane active" id="edit-password">
                    <div class="form-group">
                        <label for="form-field-pass1" class="col-sm-3 control-label no-padding-right"></label>
                        <div class="col-sm-9">
                            @foreach($list as $lcategory)
                            <div class="help-inline">
                                @foreach($lcategory as $lk => $l)
                                <label class="middle">
                                    <input type="checkbox" class="ace" {{in_array($l->id, $owned)?'checked':''}} value="{{$l->id}}" name="permissions[]" />
                                    <span class="lbl">{{$l->display_name}}</span>&nbsp;&nbsp;
                                </label>
                                @endforeach
                            </div>
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
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "#password"
            },
            username: {
                required: true,
                maxlength: 16
            },
            nickname: {
                maxlength: 30
            },
            phone: {
                required: true,
                phone: 'required'
            },
            mobile_verify: {
                required: true,
            },
            email_verify: {
                required: true,
            },
            active: {
                required: true,
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