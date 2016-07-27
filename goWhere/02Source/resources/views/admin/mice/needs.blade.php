@extends('admin.layouts.master') @section('title', '会奖需求')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.min.css')}}" />
<div class="page-content">

	<form action="">
		<label>ID:</label><input type="text" placeholder="id" class="input-sm"
			name="id" style="margin-right: 10px;" value="{{Input::get('id')}}">
			<label>状态</label> <select id="status" class="short"
					style="width: 22.5%" name="status" >
					 @foreach(config('mice.needs_status') as $k=>$v)
					<option value="{{$k}}" @if(Input::get('status')==$k)selected @endif>{{$v}}</option> @endforeach
				</select>
					<button class="btn btn-purple btn-sm" type="submit">
			<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							搜索
																		</button>
	</form>
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
						<table id="sample-table-1"
							class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="center"><label> <input type="checkbox"
											class="ace checkall" /> <span class="lbl"></span>
									</label></th>
									<th>ID</th>
									<th>姓名</th>
									<th>出行日期</th>
									<th>电话</th>
									<th>邮箱</th>
									<th>qq/微信</th>
									<th>预算</th>
									<th>目的地</th>
									<th>人数</th>
									<th>出行天数</th>
									<th>需求类型</th>
									<th>所需服务</th>
									<th>备注</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@if($data->count()) @foreach($data as $v)
								<tr>
									<td class="center"><label> <input type="checkbox"
											class="ace ids" value="{{$v->id}}" /> <span class="lbl"></span>
									</label></td>
																	
									<td>{{$v->id}}</td>
									<td>{{$v->name}}</td>
									<td>{{$v->departure_date?date('Y-m-d',$v->departure_date):''}}</td>
									<td>{{$v->phone}}</td>
									<td>{{$v->email}}</td>
									<td>{{$v->qq_wechat}}</td>
									<td>{{trans(config('mice.budget')[$v->budget])}}</td>
									<td>{{App\Models\Area::getNameById($v->destinations_id)}}</td>
									<td>{{trans(config('mice.people_num')[$v->num])}}</td>
									<td>{{$v->duration}}</td>
									<td>{{trans(config('mice.need_type')[$v->type])}}</td>
									<td>
									<?php $services=array_filter(@explode(',', $v->services));
									$servicesStr='';
									if($services){
									foreach ($services as $vc){
									    $servicesStr.=trans(config('mice.project_need')[$vc]).',';
									}
									}
									echo rtrim($servicesStr,',');
									?></td>
                                    <td>{{$v->remark}}</td>
                                    <td class="hidden-480">
									<span class="label label-sm label-inverse arrowed-in">{{config('mice.needs_status')[$v->status]}}</span>
									</td>
									<td>
										<div
											class="visible-md visible-lg hidden-sm hidden-xs btn-group">
											<a href="{{url('admin/mice/updateneed?status=0&id='.$v->id)}}" onclick="if(confirm( '确认修改状态? ')==false)return   false; ">
											<button class="btn btn-xs btn-info">
												等待处理
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
											</a>
																					
											<a href="{{url('admin/mice/updateneed?status=1&id='.$v->id)}}" onclick="if(confirm( '确认修改状态? ')==false)return   false; ">
											<button class="btn btn-xs btn-warning">
												处理中
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
											</a>
												<a href="{{url('admin/mice/updateneed?status=2&id='.$v->id)}}" onclick="if(confirm( '确认修改状态? ')==false)return   false; ">
											<button class="btn btn-xs btn-success">
												处理结束
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
											</a>
										</div>
									</td>
								</tr>
								@endforeach @else
								<tr>
									<td colspan="100">暂无数据</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /span -->
			</div>
			<!-- /row -->


		</div>
		<!-- /.page-content -->
	</div>
	<!-- /.main-content -->
	{!!$data->appends(Input::get())->render()!!}
	<div class="hr hr-24"></div>
	<!-- basic scripts -->

	

	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent



@endsection @section('inlineScript')
@endsection

