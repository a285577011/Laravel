@extends('admin.layouts.master')
@section('title', '友情链接列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="pull-right tableTools-container">
            <button id="addBtn" class="btn btn-sm">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加链接
            </button>
        </div>
        <form class="form-horizontal" id="detailForm" method="post" style="display:none;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">添加友情链接</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-title">网站名称</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-title" placeholder="网站名称" name="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-logo_text">LOGO</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" placeholder="LOGO地址或上传图片文件" id="form-field-logo_text" name="logo_text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-logo"></label>
                                <div class="col-sm-9">
                                    <label class="ace-file-input input-large">
                                        <input id="form-field-logo" type="file" name="logo">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"></label>
                                <div class="col-sm-9">
                                    <img id="logoPreview" style="display: none;" width="100" class="img-responsive">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-url">网站链接</label>
                                <div class="col-sm-9">
                                    <input type="text" id="form-field-url" class="input-large valid" placeholder="网站链接" name="url" value="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-valid">是否显示</label>
                                <div class="radio" id="form-field-valid">
                                    <label>
                                        <input type="radio" value="1" checked name="valid" class="ace">
                                        <span class="lbl">是</span>
                                    </label>
                                    <label>
                                        <input type="radio" value="0" name="valid" class="ace">
                                        <span class="lbl">否</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-sm btn-primary">提交</button>
                                    <button id="cancelBtn" class="btn btn-sm">取消</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </form>
        <div class="space"></div>
        @if(isset($title) && $title)
        <div class="table-header">
            {{$title}} 搜索结果
        </div>
        @endif
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>网站名称</th>
                        <th>网站链接</th>
                        <th>LOGO</th>
                        <th>是否显示</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->title}}</td>
                        <td>{{$l->url}}</td>
                        <td>
                            @if($l->logo)
                            {{$positionConf[$l->position] or ''}}
                            <img class="img-responsive center-block" width="100" src="@storageAsset($l->logo)" />
                            @endif
                        </td>
                        <td>
                            <span class="label label-sm {{$l->valid ? 'label-success':''}}">
                                {{$l->valid ? trans('common.yes') : trans('common.no')}}
                            </span>
                        </td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a href="{{route('admin::editLink',['id'=>$l->id])}}" class="green editBtn">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeLink',['id'=>$l->id])}}" class="red removeBtn">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-success editBtn" href="{{route('admin::editLink',['id'=>$l->id])}}" data-original-title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::removeLink',['id'=>$l->id])}}" data-original-title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">无内容</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{!!$paginator->render()!!}
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
    $('#detailForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            title: {
                required: true,
                maxlength: 50
            },
            url: {
                required: true,
                maxlength: 255,
                url: true
            },
            logo_text: {
                maxlength: 255
            },
            valid: {
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
    $('#form-field-logo').ace_file_input({
        no_file: '未选择...',
        btn_choose: '浏览',
        btn_change: '更换',
        droppable: false,
        onchange: null,
        thumbnail: false
    });
    function cancelBtn(obj) {
        var targetForm = obj.form;
        $(targetForm).fadeOut();
        targetForm.reset();
        return false;
    }
    $('#addBtn').click(function () {
        $('#detailForm').attr('action', "{{route('admin::linkList')}}");
        $('#detailForm h4').html('添加友情链接');
        $("#detailForm").validate().resetForm();
        $("#detailForm div.form-group").removeClass("has-error");
        $('#detailForm')[0].reset();
        $('#logoPreview').hide();
        $('#detailForm').fadeIn();
    });
    $('#cancelBtn').click(function () {
        $('#logoPreview').hide();
        return cancelBtn(this);
    });
    $('.removeBtn').click(function () {
        return confirm('确认删除？');
    });
    $('.editBtn').click(function () {
        var targetUrl = this.href;
        $.ajax({
            type: "GET",
            url: this.href,
            success: function (data) {
                if (data.error) {
                    alert(data.msg ? data.msg : '系统繁忙');
                } else {
                    $("#detailForm").validate().resetForm();
                    $("#detailForm div.form-group").removeClass("has-error");
                    $('#detailForm')[0].reset();
                    $('#detailForm h4').html('编辑友情链接 ' + data.data.id);
                    $('#detailForm').attr('action', targetUrl);
                    $('#form-field-title').val(data.data.title);
                    $('#form-field-url').val(data.data.url);
                    $('input[name=valid]').filter('[value=' + data.data.valid + ']').prop('checked', true);
                    $('#form-field-logo_text').val(data.data.logo);
                    if (data.data.logoUrl) {
                        $('#logoPreview').attr('src', data.data.logoUrl);
                        $('#logoPreview').show();
                    }
                    $('#detailForm').fadeIn();
                    location.href = "#detailForm";
                }
            },
            error: function (jqxhr) {
                var errorStr = '';
                if (jqxhr.status == 403) {
                    errorStr = '无权访问';
                } else if(jqxhr.status == 404) {
                    errorStr = '找不到相关内容';
                } else if (jqxhr.responseJSON) {
                    for (x in jqxhr.responseJSON) {
                        if (errorStr !== jqxhr.responseJSON[x] + '\n') {
                            errorStr += jqxhr.responseJSON[x] + '\n';
                        }
                    }
                }
                if (errorStr) {
                    alert(errorStr);
                } else {
                    alert("系统繁忙");
                }
            }
        });
        return false;
    });
});
</script>
@endsection