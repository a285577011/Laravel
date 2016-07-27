@extends('admin.layouts.master') @section('title', '跟团游订单')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.min.css')}}" />
<div class="page-content">

	<form action="">
		<label>ID:</label><input type="text" placeholder="id" class="input-sm"
			name="id" style="margin-right: 10px;" value="{{Input::get('id')}}">
			<label>状态</label> <select id="status" class="short"
					style="width: 22.5%" name="status" >
					<option value="">全部</option>
					 @foreach(config('order.orderStatus') as $k=>$v)
					<option value="{{$k}}" @if(Input::get('status')==$k)selected @endif>{{trans($v)}}</option> @endforeach
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
									<th>订单编号</th>
									<th>出行日期</th>
									<th>用户</th>
									<th>订单总额(元)</th>
									<th>支付方式</th>
									<th>订单状态</th>
									<th>订单创建时间</th>
									<th>订单修改时间</th>
									<th>支付时间</th>
									<th>备注</th>
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
									<td>{{$v->order_sn}}</td>
									<td>{{$v->prd_time?date('Y-m-d',$v->prd_time):''}}</td>
									<td>{{App\Models\Member::getUserNameById($v->members_id).'('.'Id:'.$v->members_id.')'}}</td>
									<td>{{$v->money}}</td>
									<td>{{$v->payment?config('order.payType')[$v->payment]:''}}</td>
									<td>{{trans(config('order.orderStatus')[$v->status])}}</td>
									<td>{{date('Y-m-d H:i:s',$v->ctime)}}</td>
									<td>{{date('Y-m-d H:i:s',$v->mtime)}}</td>
									<td>{{$v->paytime?date('Y-m-d H:i:s',$v->paytime):''}}</td>
									<td>{{$v->remark}}</td>
									<td>
                                            <button onclick="window.open('{{route('admin::tourOrderDetail').'?orderId='.$v->id}}')" class="btn btn-xs btn-info">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
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

