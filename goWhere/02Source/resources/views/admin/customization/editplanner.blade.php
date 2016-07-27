@extends('admin.layouts.master')
@section('title', '旅行规划师信息')
@section('content')
<form id="validation-form" class="form-horizontal" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="tabbable">
        <div class="tab-content profile-edit-tab-content">
            <div class="tab-pane active" id="edit-basic">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 center">
                        <span class="profile-picture">
                            <img src="@if(isset($info->avatar) && $info->avatar)@storageAsset($info->avatar)@else {{asset('/admin/assets/avatars/profile-pic.jpg')}}@endif" id="avatar" alt="Alex's Avatar" class="editable img-responsive">
                        </span>
                        <div class="space space-4"></div>
                    </div><!-- /.col -->

                    <div class="col-xs-12 col-sm-9">

                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name">名称</div>

                                <div class="profile-info-value">
                                    <span><input type="text" value="{{$info->name or ''}}" name="name" placeholder="显示在前台的名称" class="input-large"></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">后台账号ID</div>

                                <div class="profile-info-value">
                                    <span><input type="text" value="{{$info->user_id or ''}}" name="user_id" placeholder="后台账号ID" class="input-large"></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">简介</div>

                                <div class="profile-info-value">
                                    <span>
                                        <textarea name="desc" placeholder="规划师简介" class="form-control input-large">{{$info->desc or ''}}</textarea>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">是否显示</div>

                                <div class="profile-info-value">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="ace" name="enable" {{isset($info->enable) && $info->enable || !isset($info->enable) ? 'checked': ''}} value="1">
                                            <span class="lbl">{{trans('common.yes')}}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="ace" name="enable" {{isset($info->enable) && !$info->enable ? 'checked' : ''}} value="0">
                                            <span class="lbl">{{trans('common.no')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">头像地址或文件</div>
                                <div class="profile-info-value">
                                    <span class="block">
                                        <input type="text" value="{{$info->avatar or ''}}" name="avatar_text" placeholder="头像地址" class="input-large">
                                        <!-- #section:custom/file-input -->
                                    </span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"></div>

                                <div class="profile-info-value">
                                    <label class="ace-file-input input-large">
                                        <input id="id-input-file-1" type="file" name="avatar">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col -->
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
            &nbsp; &nbsp;
            <a class="btn btn-danger" href="{{route('admin::customPlannerList')}}">
                <i class="ace-icon fa fa-reply bigger-110"></i>
                返回
            </a>
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
jQuery(function ($) {
    jQuery.validator.addMethod("phone", function (value, element) {
        return this.optional(element) || /(^1(3[0-9]|4[57]|5[0-35-9]|7[6-8]|8[0-9])\d{8}$)|(^170[0-25]\d{7}$)/.test(value);
    }, "{{trans('validation.cnphone')}}");
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            name: {
                required: true,
                maxlength: 30
            },
            desc: {
                maxlength: 255
            },
            enable: {
                required: true,
            },
            user_id: {
                min: 1,
                required: true,
                digits: true
            },
            avatar_text: {
                maxlength: 255
            }
        },
        messages: {
        },
        highlight: function (e) {
            $(e).closest('.profile-info-row').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
            $(e).closest('.profile-info-row').removeClass('has-error'); //.addClass('has-info');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('[type="password"]')) {
                error.insertAfter(element);
            } else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else
                error.insertAfter(element);
        },
        submitHandler: function (form) {
            form.submit();
        },
        invalidHandler: function (form) {
        }
    });
    $('#id-input-file-1').ace_file_input({
        no_file:'未选择...',
        btn_choose:'浏览',
        btn_change:'更换',
        droppable:false,
        onchange:null,
        thumbnail:false //| true | large
        //whitelist:'gif|png|jpg|jpeg'
        //blacklist:'exe|php'
        //onchange:''
        //
    });
});
</script>
@endsection