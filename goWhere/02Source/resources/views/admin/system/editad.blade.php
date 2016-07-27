@extends('admin.layouts.master')
@section('title', '广告详情')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" id="adDetailForm" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">编辑广告信息</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-title">标题</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-title" placeholder="标题" name="title" value="{{$info->title}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-type">类型</label>
                                <div class="col-sm-9">
                                    <select class="input-large form-control" id="form-field-type" name="type">
                                        @foreach($typeConf as $tKey => $t)
                                        <option value="{{$tKey}}" {{$tKey==$info->type ? 'selected' : ''}}>{{$t}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-sort">序列</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" placeholder="数字越大排越前" id="form-field-sort" name="sort" value="{{$info->sort}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-href">跳转URL</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-href" placeholder="" name="href" value="{{$info->href}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-desc">描述</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control input-large" id="form-field-desc" name="desc">{{$info->desc}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-module">所在模块</label>
                                <div class="col-sm-9">
                                    <select id="form-field-module" class="input-large form-control" name="module">
                                        @foreach($moduleConf as $mKey => $m)
                                        <option value="{{$mKey}}" {{$mKey==$info->module ? 'selected' : ''}}>{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-position">位置</label>
                                <div class="col-sm-9">
                                    <select id="form-field-position" class="input-large form-control" name="position">
                                        @foreach($positionConf as $pKey => $p)
                                        <option value="{{$pKey}}" {{$pKey==$info->position ? 'selected' : ''}}>{{$p}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-size">尺寸</label>
                                <div class="col-sm-9">
                                    <input type="text" id="form-field-size" class="input-large valid" placeholder="宽度,长度（如：1280,768）" name="size" value="{{$info->size}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-attachment_text">附件</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" placeholder="" id="form-field-attachment_text" name="attachment_text" value="{{$info->attachment}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-attachment"></label>
                                <div class="col-sm-9">
                                    <label class="ace-file-input input-large">
                                        <input id="id-input-file-1" type="file" name="attachment">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-desc"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-sm btn-primary">提交</button>
                                    <button type="reset" class="btn btn-sm">重置</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div>
                            @if($info->attachment)
                            <div class="hr hr-24"></div>
                            @if($info->type == 1)
                            <img src="@storageAsset($info->attachment)" class="img-responsive center-block"/>
                            @else
                            <object data="@storageAsset($info->attachment)" height="200" width="200"/>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
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
    jQuery.validator.addMethod("size", function (value, element) {
        return this.optional(element) || /^\d+,\d+$/.test(value);
    }, "请按格式输入：宽度,高度");
    $('#adDetailForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            title: {
                required: true,
                maxlength: 30
            },
            module: {
                required: true,
                digits: true
            },
            type: {
                required: true,
                digits: true
            },
            position: {
                required: true,
                digits: true
            },
            size: {
                size: 'required'
            },
            sort: {
                digits: true
            },
            href: {
                required: true,
                maxlength: 255,
                url: true
            },
            attachment_text: {
                maxlength: 255
            },
            desc: {
                maxlength: 255
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
        thumbnail:false
    });
    function cancelBtn(obj) {
        var targetForm = obj.form;
        targetForm.reset();
        $(targetForm).fadeOut();
        return false;
    }
});
</script>
@endsection