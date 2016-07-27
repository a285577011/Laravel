@extends('admin.layouts.master')
@section('title', '规划师列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="pull-right tableTools-container">
            <a class="btn btn-sm" href="{{route('admin::customAddPlanner')}}">
                <i class="ace-icon glyphicon glyphicon-plus align-top bigger-125"></i>
                添加规划师
            </a>
        </div>
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
                        <th>后台用户ID</th>
                        <th>名称</th>
                        <th>是否显示</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->user_id}}</td>
                        <td>{{$l->name}}</td>
                        <td>
                            <span class="label label-sm {{$l->enable ? 'label-success':''}}">
                                {{$l->enable ? trans('common.yes') : trans('common.no')}}
                            </span>
                        </td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{route('admin::customEditPlanner', ['id'=>$l->id])}}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                <a href="{{route('admin::customRemovePlanner',['id'=>$l->id])}}" class="red removeBtn">
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
                                            <a href="{{route('admin::customEditPlanner', ['id'=>$l->id])}}" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="" data-rel="tooltip" class="tooltip-error removeBtn" href="{{route('admin::customRemovePlanner',['id'=>$l->id])}}" data-original-title="Delete">
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
                    <tr><td colspan="5">无内容</td></tr>
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
$('.removeBtn').click(function () {
    return confirm('确认删除？');
});
</script>
@endsection