@extends('admin.layouts.master')
@section('title', '“'.$info->display_name.'”的用户列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="table-header hidden">
        </div>

        <!-- div.table-responsive -->

        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="listTable">
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->username}}</td>
                        <td>{{$l->email}}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{route('admin::roleUser',['id'=>$info->id,'user'=>$l->id, 'action'=>2])}}" class="red removeBtn">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">无内容</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            <!-- #section:elements.tab -->
            <div class="tabbable">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#addTab" data-toggle="tab" aria-expanded="true">
                            添加用户到该角色
                        </a>
                    </li>

                    <li class="">
                        <a href="#searchTab" data-toggle="tab" aria-expanded="false">
                            通过搜索添加
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active in" id="addTab">
                        <form class="form-inline inline" method="post" id="addForm">
                            <div class="form-group">
                                {!! csrf_field() !!}
                                <label class="control-label no-padding-right">用户ID或用户名</label>
                                <input type="text" class="input-large valid" name="user" placeholder="用户ID或用户名"/>
                                <input type="hidden" class="input-large valid" name="id" value="{{$info->id}}"/>
                            </div>
                            <button class="btn btn-sm" type="submit">添加</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="searchTab">
                        <form class="form-inline inline" id="searchForm" method="post">
                            <div class="form-group">
                                <label class="control-label no-padding-right">用户ID</label>
                                <input type="text" id="form_userId" class="input-large valid" name="id" placeholder="用户ID"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label no-padding-right">用户名</label>
                                <input type="text" id="form_userName" class="input-large valid" name="username" placeholder="用户名"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label no-padding-right">姓名</label>
                                <input type="text" id="form_name" class="input-large valid" name="name" placeholder="姓名"/>
                            </div>
                            <button id="searchUserBtn" class="btn btn-sm" type="submit">搜索</button>
                            <div class="error"></div>
                        </form>
                        <div class="space"></div>
                        <table id="searchTable" class="table table-striped table-bordered table-hover" style="display: none;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="searchRst">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /section:elements.tab -->
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
    $('#listTable').delegate('tr td .removeBtn', 'click', function () {
        return confirm('确认删除？');
    });
    $('#searchRst').delegate('tr td .addUserBtn', 'click', function () {
        var addBtnUrl = this.href;
        var removeBtnUrl = "{{route('admin::roleUser', ['id'=>$info->id, 'action'=>2])}}";
        $.ajax({
            type: "GET",
            url: addBtnUrl,
            success: function (data) {
                if (data.error) {
                    alert(data.msg ? data.msg : '系统繁忙');
                } else {
                    if (data.msg) {
                        alert(data.msg);
                    }
                    var newRow = '<tr><td>' + data.data.id + '</td>'
                            + '<td>' + data.data.name + '</td>'
                            + '<td>' + data.data.username + '</td>'
                            + '<td>' + data.data.email + '</td>'
                            + '<td><div class="action-buttons"><a href="' + removeBtnUrl + '&user=' + data.data.id
                            + '" class="red removeBtn"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div></td></tr>';
                    $('#listTable').append(newRow);
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

    $('#addForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            user: {
                required: true,
                maxlength: 16
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
                error.insertAfter(element.parent().siblings());
        },
        submitHandler: function (form) {
            form.submit();
        },
        invalidHandler: function (form) {
        }
    });
    $('#searchForm').validate({
        errorContainer: "div.error",
        errorLabelContainer: $("#searchForm div.error"),
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        rules: {
            id: {
                min: 1,
                digits: true
            },
            username: {
                maxlength: 16
            },
            name: {
                maxlength: 30
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
                error.insertAfter(element.parent().siblings());
        },
        submitHandler: function (form) {
            var targetUrl = "{{route('admin::searchUser')}}";
            var addUrl = "{{route('admin::roleUser', ['id'=>$info->id, 'action'=>1])}}";
            var searchRst = $('#searchRst');
            $.ajax({
                type: "POST",
                url: targetUrl,
                data: {
                    'username': $('#form_userName').val(),
                    'name': $('#form_name').val(),
                    'id': $('#form_userId').val(),
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.msg ? data.msg : '系统繁忙');
                    } else {
                        if (data.data.length) {
                            var tbody = '';
                            for (x in data.data) {
                                tbody = tbody + '<tr><td>' + data.data[x].id + '</td>'
                                        + '<td>' + data.data[x].name + '</td>'
                                        + '<td>' + data.data[x].username + '</td>'
                                        + '<td>' + data.data[x].email + '</td>'
                                        + '<td><div class="action-buttons"><a href="' + addUrl + '&user=' + data.data[x].id
                                        + '" class="green addUserBtn"><i class="ace-icon glyphicon glyphicon-plus bigger-130"></i></a></div></td></tr>';
                                searchRst.html(tbody);
                            }
                        } else
                        {
                            searchRst.html('<tr><td colspan="5">无内容</td></tr>');
                        }
                        $('#searchTable').show();
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
        }
    });
});
</script>
@endsection