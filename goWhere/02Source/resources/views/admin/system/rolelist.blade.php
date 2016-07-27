@extends('admin.layouts.master')
@section('title', '角色列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="pull-right tableTools-container">
            <button class="btn btn-sm" id="addBtn">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加角色
            </button>
        </div>
        <form class="form-horizontal" action="{{route('admin::addRole')}}" id="detailForm" method="post" style="display: none;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">添加角色</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-name">角色标识</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-name" placeholder="角色标识" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-description">角色描述</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-description" placeholder="角色描述" name="description">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-displayName">角色名称</label>
                                <div class="col-sm-9">
                                    <input type="text" id="form-field-displayName" class="input-large valid" placeholder="角色名称" name="display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"></label>
                                <div class="col-sm-9">
                                    <button id="detailFormSubmit" type="submit" class="btn btn-sm btn-primary">提交</button>
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
        <div class="table-header hidden">
        </div>

        <!-- div.table-responsive -->

        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>角色标识</th>
                        <th>角色名称</th>
                        <th>角色描述</th>
                        <th>系统角色</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->display_name}}</td>
                        <td>{{$l->description}}</td>
                        <td>
                            <span class="label label-sm {{$l->system ? 'label-success':'label-warning'}}">{{$l->system ? trans('common.yes') : trans('common.no')}}</span>
                        </td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                @if($l->system)
                                <a class="blue editBtn" href="{{route('admin::editRole', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                <a class="green" href="{{route('admin::roleUser', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-users bigger-130"></i>
                                </a>
                                @else
                                <a class="blue editBtn" href="{{route('admin::editRole', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a class="green" href="{{route('admin::roleUser', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-users bigger-130"></i>
                                </a>
                                <a class="orange" href="{{route('admin::grantPermission', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-exchange bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeRole',['id'=>$l->id])}}" class="red removeBtn">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                                @endif
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        @if($l->system)
                                        <li>
                                            <a href="{{route('admin::editRole', ['id'=>$l->id])}}" class="tooltip-info editBtn" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{route('admin::editRole', ['id'=>$l->id])}}" class="tooltip-info editBtn" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::removeRole',['id'=>$l->id])}}" data-original-title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
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
jQuery(function($){
    $('#detailForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            name: {
                required: true,
                maxlength: 30
            },
            display_name: {
                required: true,
                maxlength: 255
            },
            description: {
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
    function cancelBtn(obj) {
        var targetForm = obj.form;
        $(targetForm).fadeOut();
        targetForm.reset();
        return false;
    }
    $('#addBtn').click(function () {
        $('#detailForm').attr('action', "{{route('admin::addRole')}}");
        $('#detailForm h4').html('添加角色');
        $('#detailFormSubmit').show();
        $( "#detailForm" ).validate().resetForm();
        $("#detailForm div.form-group").removeClass("has-error");
        $('#detailForm')[0].reset();
        $('#detailForm').fadeIn();
        return false;
    });
    $('#cancelBtn').click(function () {
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
                    $( "#detailForm" ).validate().resetForm();
                    $("#detailForm div.form-group").removeClass("has-error");
                    $('#detailForm')[0].reset();
                    if(data.data.system) {
                        $('#detailForm h4').html('查看角色 '+data.data.id);
                        $('#detailFormSubmit').hide();
                    } else {
                        $('#detailForm h4').html('编辑角色 '+data.data.id);
                        $('#detailFormSubmit').show();
                    }
                    $('#detailForm').attr('action', targetUrl);
                    $('#form-field-name').val(data.data.name);
                    $('#form-field-displayName').val(data.data.display_name);
                    $('#form-field-description').val(data.data.description);
                    $('#detailForm').fadeIn();
                    location.href = "#detailForm";
                }
            },
            error: function () {
                alert("系统繁忙");
            }
        });
        return false;
    });
});
</script>
@endsection