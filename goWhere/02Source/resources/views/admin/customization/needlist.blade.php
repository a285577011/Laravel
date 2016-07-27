@extends('admin.layouts.master')
@section('title', '定制需求列表')
@section('content')
<div class="row">
    <div class="col-xs-12">
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
                        <th>姓名</th>
                        <th>电话</th>
                        <th>邮箱</th>
                        <th>联系时间</th>
                        <th>计划出发</th>
                        <th>出发城市</th>
                        <th>规划师</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->phone}}</td>
                        <td>{{$l->email}}</td>
                        <td>
                            @foreach(explode(',',$l->contact_time) as $ct)
                            @transLang($contactConf[$ct])
                            @endforeach
                        </td>
                        <td>{{$l->departure_date}}</td>
                        <td>{{$l->from_city}}</td>
                        <td>{{$planners[$l->planner_id]->name or ''}}</td>
                        <td>
                            <span class="label label-sm @if($l->status){{$l->status==2 ? 'label-success':'label-warning'}}@endif">
                                @transLang($statusConf[$l->status])
                            </span>
                        </td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{route('admin::customNeedDetail', ['id'=>$l->id])}}">
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
                                            <a href="{{route('admin::customNeedDetail', ['id'=>$l->id])}}" class="tooltip-info" data-rel="tooltip" title="View">
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
@endsection

@section('inlineScript')
@endsection