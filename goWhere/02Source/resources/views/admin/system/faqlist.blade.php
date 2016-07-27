@extends('admin.layouts.master')
@section('title', 'FAQ列表')

@section('page-style')
<link rel="stylesheet" href="{{asset('/admin/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" />
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <!-- 搜索 -->
        <form id="searchForm" method="get" role="form" class="form-inline inline" novalidate="novalidate">
            <div class="form-group">
                <label for="search_title">标题</label>
                <input type="text" autocomplete="off" name="title" id="search_title" class="form-control">
            </div>
            <div class="form-group">
                <label for="search_category">分类</label>
                <select autocomplete="off" name="category" class="input-large form-control" id="search_category">
                    <option value="0">所有分类</option>
<!--                    <option value="-1">(无分类)</option>-->
                    @if($categoryList)
                    @foreach($categoryList as $catK => $catV)
                    <option value="{{$catK}}">{{str_repeat('---',$catV['tree_layer'])}}{{$catV['name']}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="search_lang">语言</label>
                <select autocomplete="off" name="lang" class="input-large form-control" id="search_lang">
                    <option value="0">所有语言</option>
                    @foreach($langConf as $langK => $langV)
                    <option value="{{$langV}}">{{trans('common.'.$langK)}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm btn-primary" id="searchBtn" type="submit">搜索</button>
            <button class="btn btn-sm btn-info" type="reset">重置</button>
        </form>
        <div class="pull-right tableTools-container">
            <button id="addBtn" class="btn btn-sm">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加FAQ
            </button>
        </div>
        <form class="form-horizontal" id="detailForm" method="post" style="display:none;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="clearfix"></div>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">添加FAQ</h4>
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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-category_id">分类</label>
                                <div class="col-sm-9">
                                    <select id="form-field-category_id" class="input-large valid" name="category_id">
                                        <option value="">选择分类</option>
                                        @if($categoryList)
                                        @foreach($categoryList as $catK => $catV)
                                        <option value="{{$catK}}">{{str_repeat('---',$catV['tree_layer'])}}{{$catV['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-content">内容</label>
                                <div class="col-sm-9">
<!--                                <textarea id="form-field-content" class="input-large" placeholder="内容" name="content"></textarea>-->
                                    <script id="form-field-content" name="content" type="text/plain"></script>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-lang">语言</label>
                                <div class="radio" id="form-field-lang">
                                    @foreach($langConf as $langK => $langV)
                                    <label>
                                        <input type="radio" value="{{$langV}}" name="lang" class="ace">
                                        <span class="lbl">{{trans('common.'.$langK)}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-sort">排序</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-sort" placeholder="越大排越前" name="sort">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-title">发表者</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-author" name="author" placeholder="留空为当前后台用户">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-title">发表时间</label>
                                <div class="col-sm-9">
                                    <input type="text" class="input-large valid" id="form-field-ctime" name="ctime" placeholder="留空为当前时间">
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
            <button id="delBtn" class="btn btn-xs btn-danger" data-val="{{route('admin::removeFaq')}}">
                <i class="ace-icon fa fa-trash-o bigger-120"></i>删除
            </button>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="ace chk_all" data-val="ids" autocomplete="off"> <span class="lbl"></span>
                            </label>
                        </th>
                        <th>ID</th>
                        <th>标题</th>
                        <th>内容</th>
                        <th>类别</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="id[]" class="ace ids" value="{{$l->id}}"> <span class="lbl"></span>
                            </label>
                        </td>
                        <td>
                            {{$l->id}}
                        </td>
                        <td>{{$l->title}}</td>
                        <td>{{$l->content ? '有': '无'}}</td>
                        <td>{{isset($categoryList[$l->category_id]) ? $categoryList[$l->category_id]['name'] : '(无分类)'}}</td>
                        <td>{{$l->sort}}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a href="{{route('admin::faq',['id'=>$l->id])}}" class="green editBtn">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeFaq',['id'=>$l->id])}}" class="red removeBtn">
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
                                            <a title="" data-rel="tooltip" class="tooltip-success editBtn" href="{{route('admin::faq',['id'=>$l->id])}}" data-original-title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::removeFaq',['id'=>$l->id])}}" data-original-title="Delete">
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
<script src="{{asset('/admin/components/moment/moment.js')}}"></script>
<script src="{{asset('/admin/components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('/admin/components/utf8-php/ueditor.config.js')}}"></script>
<script src="{{asset('/admin/components/utf8-php/ueditor.all.js')}}"></script>
@endsection

@section('inlineScript')
<script type="text/javascript">
jQuery(function ($) {
    // 实例化编辑器
    var ue = UE.getEditor('form-field-content', {
        toolbars: [
            ['fullscreen', 'undo', 'redo','bold', 'italic', 'underline', 'fontborder', 'strikethrough', '|', 'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify', '|', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|', 'link','inserttable', 'deletetable', 'simpleupload', '|', 'selectall', 'cleardoc']
        ],
        scaleEnabled:false,
        initialFrameHeight:230,
        autoFloatEnabled:true
    });
    // fill 搜索表单
    var curSearchCdt = {!!$searchCdt!!};
    if(curSearchCdt.title) {
        $('#search_title').val(curSearchCdt.title);
    }
    if(curSearchCdt.lang) {
        $('#search_lang').val(curSearchCdt.lang);
    }
    if(curSearchCdt.category) {
        $('#search_category').val(curSearchCdt.category);
    }
    // 删除
    $('#delBtn').on('click', function(){
        var ids = new Array();
        $('input[name="id[]"]:checked').each(function(index, element){
            ids.push(element.value);
        });
        if(ids.length<1) {
            alert('未选择');
            return false;
        }
        if(!confirm('删除选中项？')) {
            return false;
        }
        $.post($(this).data('val'),
            {
                id: ids
            }, function(data, status){
                if(data.error) {
                    alert(data.msg);
                } else {
                    alert(data.msg);
                    $('.ids').prop("checked", false);
                    location.reload();
                }
            }
        );
        return false;
    });
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
            title: {
                required: true,
                maxlength: 200
            },
            content: {
                maxlength: 255
            },
            author: {
                maxlength: 30
            },
            sort: {
                digits: true
            },
            lang: {
                required: true,
                digits: true
            },
            category_id: {
                required: true,
                digits: true
            },
            ctime: {
                date: true
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
        ue.ready(function() {
            ue.setContent('');
        });
        targetForm.reset();
        return false;
    }
    $('#addBtn').click(function () {
        $('#detailForm').attr('action', "{{route('admin::faqList')}}");
        $('#detailForm h4').html('添加FAQ');
        ue.ready(function() {
            ue.setContent('');
        });
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
                    $('#detailForm h4').html('编辑FAQ ' + data.data.id);
                    $('#detailForm').attr('action', targetUrl);
                    $('#form-field-title').val(data.data.title);
                    //$('#form-field-content').val(data.data.content);
                    ue.ready(function() {
                        ue.setContent(data.data.content);
                    });
                    $('#form-field-sort').val(data.data.sort);
                    $('#form-field-author').val(data.data.author);
                    $('#form-field-ctime').val(data.data.ctime);
                    $('input[name=lang]').filter('[value=' + data.data.lang + ']').prop('checked', true);
                    $('#form-field-category_id').val(data.data.category_id);
                    
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