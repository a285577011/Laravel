@extends('admin.layouts.master')
@section('title', 'FAQ分类列表')

@section('page-style')
<link rel="stylesheet" href="{{asset('/admin/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" />
<link rel="stylesheet" href="{{asset('/admin/components/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" />
<link rel="stylesheet" href="{{asset('/admin/components/bootstrap-daterangepicker/daterangepicker.css')}}" />
<link rel="stylesheet" href="{{asset('/admin/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" />
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="pull-right tableTools-container">
            <button id="addBtn" class="btn btn-sm">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加FAQ分类
            </button>
        </div>
        <form class="form-horizontal" id="detailForm" method="post" style="display:none;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">添加FAQ分类</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-name_zh_cn">分类名(简体中文)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-name_zh_cn" placeholder="简体中文" name="name_zh_cn">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-name_zh_tw">分类名(繁体中文)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-name_zh_tw" placeholder="繁体中文" name="name_zh_tw">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-name_en_us">分类名(英文)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-name_en_us" placeholder="英文" name="name_en_us">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-sort">排序</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-sort" placeholder="数字越大排越前" name="sort" title="数字越大排越前">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-parent_id">上级分类</label>
                                <div class="col-sm-9">
                                    <select id="form-field-parent_id" class="input-large valid" name="parent_id">
                                        <option value="0">无</option>
                                        @if($topCategory)
                                        @foreach($topCategory as $tpC)
                                        <option value="{{$tpC['id']}}">{{$tpC['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
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
                        <th>标题(简体中文)</th>
                        <th>标题(繁体中文)</th>
                        <th>标题(英文)</th>
                        <th>上级分类</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->name_zh_cn}}</td>
                        <td>{{$l->name_zh_tw}}</td>
                        <td>{{$l->name_en_us}}</td>
                        <td>{{isset($topCategory[$l->parent_id]['name']) ? $topCategory[$l->parent_id]['name'] : '无'}}</td>
                        <td>{{$l->sort}}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a href="{{route('admin::faqCategory',['id'=>$l->id])}}" class="green editBtn">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeFaqCategory',['id'=>$l->id])}}" class="red removeBtn">
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
                                            <a title="" data-rel="tooltip" class="tooltip-success editBtn" href="{{route('admin::faqCategory',['id'=>$l->id])}}" data-original-title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::removeFaqCategory',['id'=>$l->id])}}" data-original-title="Delete">
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
                    <tr><td colspan="7">无内容</td></tr>
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
<script src="{{asset('/admin/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/admin/components/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('/admin/components/moment/moment.js')}}"></script>
<script src="{{asset('/admin/components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('/admin/components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
@endsection

@section('inlineScript')
<script type="text/javascript">
jQuery(function ($) {
    $('#form-field-ctime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss', //use this option to display seconds
        showTodayButton: true,
        viewDate: '{{date('Y-m-d\TH:i:sP')}}'
    });
    $('#detailForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            name_zh_cn: {
                required: true,
                maxlength: 30
            },
            name_zh_tw: {
                required: true,
                maxlength: 30
            },
            name_en_us: {
                required: true,
                maxlength: 30
            },
            sort: {
                digits: true
            },
            parent_id: {
                digits: true
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
    function cancelBtn(obj) {
        var targetForm = obj.form;
        $(targetForm).fadeOut();
        $('#form-field-parent_id option').removeClass('hide');
        targetForm.reset();
        return false;
    }
    $('#addBtn').click(function () {
        $('#detailForm').attr('action', "{{route('admin::faqCategoryList')}}");
        $('#detailForm h4').html('添加FAQ分类');
        $('#form-field-parent_id option').removeClass('hide');
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
                    $('#detailForm h4').html('编辑FAQ分类 ' + data.data.id);
                    $('#detailForm').attr('action', targetUrl);
                    $('#form-field-name_zh_cn').val(data.data.name_zh_cn);
                    $('#form-field-name_zh_tw').val(data.data.name_zh_tw);
                    $('#form-field-name_en_us').val(data.data.name_en_us);
                    $('#form-field-parent_id').val(data.data.parent_id);
                    $('#form-field-parent_id option').removeClass('hide');
                    $('#form-field-parent_id option[value="'+data.data.id+'"]').addClass('hide');
                    $('#form-field-sort').val(data.data.sort);
                    $('#detailForm').fadeIn();
                    location.href = "#detailForm";
                }
            },
            error: function (jqxhr) {
                var errorStr = '';
                if (jqxhr.status == 403) {
                    errorStr = '无权访问';
                } else if (jqxhr.status == 404) {
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