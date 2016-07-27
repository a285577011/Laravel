@extends('admin.layouts.master')
@section('title', '用户列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="pull-right tableTools-container">
            <a class="btn btn-sm" href="{{route('admin::addUser')}}">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加用户
            </a>
        </div>
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
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->username}}</td>
                        <td>{{$l->email}}</td>
                        <td>{{date('Y-m-d H:i:s', $l->ctime)}}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{route('admin::editUser', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                <a href="{{route('admin::removeUser',['id'=>$l->id])}}" class="red removeBtn">
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
                                            <a href="{{route('admin::editUser', ['id'=>$l->id])}}" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::removeUser',['id'=>$l->id])}}" data-original-title="Delete">
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
@endsection

@section('inlineScript')
<script type="text/javascript">
jQuery(function($){
    $('.removeBtn').click(function () {
        return confirm('确认删除？');
    });
});
</script>
@endsection