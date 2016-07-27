@extends('admin.layouts.master')
@section('title', '会员列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <!-- 搜索 -->
        <form id="searchForm" method="get" role="form" class="form-inline inline" novalidate="novalidate" style="margin-bottom: 10px;">
            <div class="form-group">
                <label for="search_username">用户名/姓名/昵称</label>
                <input type="text" autocomplete="off" name="username" id="search_username" class="form-control">
            </div>
            <div class="form-group">
                <label for="search_email">邮箱</label>
                <input type="text" autocomplete="off" name="email" id="search_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="search_phone">手机</label>
                <input type="text" autocomplete="off" name="phone" id="search_phone" class="form-control">
            </div>
            <button class="btn btn-sm btn-primary" id="searchBtn" type="submit">搜索</button>
            <button class="btn btn-sm btn-info" type="reset">重置</button>
        </form>
        <div class="table-header hidden">
            Results for "Latest Registered Domains"
        </div>

        <!-- div.table-responsive -->

        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>昵称</th>
                        <th>姓名</th>
                        <th>邮箱</th>
                        <th>手机</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->username}}</td>
                        <td>{{$l->nickname}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->email}}</td>
                        <td>{{$l->phone}}</td>
                        <td>
                            <span class="label label-sm {{$l->active ? 'label-success':'label-warning'}}">@transLang($activeStatusConf[$l->active])</span>
                            <span class="label label-sm {{$l->mobile_verify ? 'label-success':'label-warning'}}">手机@transLang($verifyStatusConf[$l->mobile_verify])</span>
                            <span class="label label-sm {{$l->email_verify ? 'label-success':'label-warning'}}">邮箱@transLang($verifyStatusConf[$l->email_verify])</span>
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{route('admin::member', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="{{route('admin::member', ['id'=>$l->id])}}" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">无内容</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{!!$paginator->render()!!}
@endsection

@section('pageScript')
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
    var curSearchCdt = {!!$searchCdt!!};
    for(x in curSearchCdt) {
        if($('#search_'+x)) {
            $('#search_'+x).val(curSearchCdt[x]);
        }
    }
    $('#searchForm').validate({
        errorElement: 'span',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            username: {
                maxlength: 30
            },
            email: {
                email:true,
                maxlength:255
            },
            phone: {
                phone: 'required'
            }
        },
        errorPlacement: function (error, element) {
            var text = element.prev().html()+error.html();
            error.insertAfter($('#searchBtn').next());
        }
    });
});
</script>
@endsection