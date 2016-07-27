@extends('admin.layouts.master')
@section('title', '广告列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <form class="form-inline inline" role="form" method="get" id="searchForm">
            <div class="form-group">
                <label for="search_title">标题</label>
                <input type="text" class="form-control" id="search_title" name="title" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="inputfile">所在模块</label>
                <select id="form-field-module" class="input-large form-control" name="module" autocomplete="off">
                    <option value="0">未选择</option>
                    @foreach($moduleConf as $mKey => $m)
                    <option value="{{$mKey}}" {{isset($module)&&$module==$mKey ? 'selected' : ''}}>{{$m}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="inputfile">广告类型</label>
                <select class="input-large form-control" id="form-field-type" name="type" autocomplete="off">
                    <option value="0">未选择</option>
                    @foreach($typeConf as $tKey => $t)
                    <option value="{{$tKey}}" {{isset($type)&&$type==$tKey ? 'selected' : ''}}>{{$t}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" id="searchBtn" class="btn btn-sm">搜索</button>
        </form>
        <div class="pull-right tableTools-container">
            <button id="addAdBtn" class="btn btn-sm">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加广告
            </button>
        </div>
        <form class="form-horizontal" id="adDetailForm" method="post" style="display:none;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">添加广告信息</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-title">标题</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-title" placeholder="标题" name="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-type">类型</label>
                                <div class="col-sm-9">
                                    <select class="input-large form-control" id="form-field-type" name="type">
                                        @foreach($typeConf as $tKey => $t)
                                        <option value="{{$tKey}}">{{$t}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-sort">序列</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" placeholder="数字越大排越前" id="form-field-sort" name="sort">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-href">跳转URL</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-href" placeholder="" name="href" value="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-desc">描述</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control input-large" id="form-field-desc" name="desc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-module">所在模块</label>
                                <div class="col-sm-9">
                                    <select id="form-field-module" class="input-large form-control" name="module">
                                        @foreach($moduleConf as $mKey => $m)
                                        <option value="{{$mKey}}">{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-position">位置</label>
                                <div class="col-sm-9">
                                    <select id="form-field-position" class="input-large form-control" name="position">
                                        @foreach($positionConf as $pKey => $p)
                                        <option value="{{$pKey}}">{{$p}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-size">尺寸</label>
                                <div class="col-sm-9">
                                    <input type="text" id="form-field-size" class="input-large valid" placeholder="宽度,长度（如：1280,768）" name="size">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-attachment_text">附件</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" placeholder="" id="form-field-attachment_text" name="attachment_text">
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
                        <th>标题</th>
                        <th>所在模块</th>
                        <th>位置</th>
                        <th>类型</th>
                        <th>序列</th>
                        <th>尺寸</th>
                        <th>跳转URL</th>
                        <th>描述</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->title}}</td>
                        <td>{{$moduleConf[$l->module] or ''}}</td>
                        <td>{{$positionConf[$l->position] or ''}}</td>
                        <td>{{$typeConf[$l->type] or ''}}</td>
                        <td>{{$l->sort}}</td>
                        <td>{{$l->size}}</td>
                        <td>{{$l->href}}</td>
                        <td>{{$l->desc}}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a href="{{route('admin::editAd',['id'=>$l->id])}}" class="green">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeAd',['id'=>$l->id])}}" class="red removeLink">
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
                                            <a title="" data-rel="tooltip" class="tooltip-success" href="{{route('admin::editAd',['id'=>$l->id])}}" data-original-title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeLink" href="{{route('admin::removeAd',['id'=>$l->id])}}" data-original-title="Delete">
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
                    <tr><td colspan="10">无内容</td></tr>
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
    $('#searchForm').validate({
        errorElement: 'span',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            module: {
                digits: true
            },
            title: {
                maxlength: 30
            },
            type: {
                digits: true
            }
        },
        errorPlacement: function (error, element) {
            var text = element.prev().html()+error.html();
            error.insertAfter($('#searchBtn'));
        }
    });
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
        no_file: '未选择...',
        btn_choose: '浏览',
        btn_change: '更换',
        droppable: false,
        onchange: null,
        thumbnail: false
    });
    function cancelBtn(obj) {
        var targetForm = obj.form;
        targetForm.reset();
        $(targetForm).fadeOut();
        return false;
    }
    $('#addAdBtn').click(function () {
        $('#adDetailForm').fadeIn();
    });
    $('#cancelBtn').click(function () {
        return cancelBtn(this);
    });
    $('.removeLink').click(function () {
        return confirm('确认删除？');
    });
});
</script>
@endsection