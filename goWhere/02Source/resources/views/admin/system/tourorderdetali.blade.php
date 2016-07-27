<?php
use function GuzzleHttp\json_decode;
?>
@extends('admin.layouts.master') @section('title', '订单编号:'.$data['orderData']['order_sn'])
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.min.css')}}" />
<div class="page-content">
<div class="widget-header widget-header-large">
												<h3 class="widget-title grey lighter">
													<i class="ace-icon fa fa-leaf green"></i>
													订单详情
												</h3>

											</div>
<div class="col-sm-6" style="min-height: 200px;">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>线路信息</b>
																</div>
															</div>

															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>线路名称:{{$data['tourData']['name_zh_cn']}}
																	</li>
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>出发城市:{{App\Models\Area::getNameById(intval($data['tourData']['leave_area']))}}
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>成人-儿童数:{{$data['tourOrderData']['adult_num']}}-{{$data['tourOrderData']['child_num']}}
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>出发日期:{{date('Y-m-d',$data['tourOrderData']['departure_date'])}}({{config('tour.week_zh_cn')[date("w",$data['tourOrderData']['departure_date'])]}})
																	</li>

														

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>
																		返回日期:{{date('Y-m-d',$data['tourOrderData']['departure_date']+(86400*$data['tourData']['schedule_days']))}}({{config('tour.week_zh_cn')[date("w",$data['tourOrderData']['departure_date']+(86400*$data['tourData']['schedule_days']))]}})
																	</li>
																</ul>
															</div>
														</div>
		<div class="col-sm-6" style="min-height: 200px;">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>联系人信息</b>
																</div>
															</div>

															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>姓名:{{$data['tourOrderData']['contact_name']}}
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>邮箱:{{$data['tourOrderData']['contact_email']}}
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>电话:{{$data['tourOrderData']['contact_phone']}}
																	</li>
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>      
																		@if($data['tourOrderData']['invoice']==1)
																		<?php $invoiceInfo=json_decode($data['tourOrderData']['invoice_info'],true);?>
      <span class="s1">发票信息：<span> {{$invoiceInfo['fapiao_taitou']}}</span></span>
      <span class="s1">{{trans('tour.xiangxi_dizhi')}}：<span>{{$invoiceInfo['address']}}</span></span>
      @else
      <span class="s1">不要发票</span>
      @endif
																	</li>
																</ul>
															</div>
														</div>
														<div class="col-sm-6" style="min-height: 200px;">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>旅客信息</b>
																</div>
															</div>

															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>旅客总数:{{$data['tourOrderData']['adult_num']+$data['tourOrderData']['child_num']}}
																	</li>

																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>
																		<?php $touristData=json_decode($data['tourOrderData']['tourist_info'],true)?>    
																		@foreach($touristData['adult'] as $k=>$v)
    @if($v)
      <div class="order-pay-msg-title">
        <span>旅客信息(成人)</span>
      </div>
      <p class="s2">旅客姓名：{{$v['name']}}  {{config('common.sex')[$v['sex']?:1]['zh_cn']}} 英文姓:{{$v['englishXing']}} 英文名:{{$v['englishName']}} 证件信息({{config('tour.zhengjian')[$v['zhengjianType']]['zh_cn']}}):{{$v['zhengjian']}} 生日:{{$v['birther_day']}} 手机:{{$v['phone']}}</p>
      @endif
    @endforeach
    @if(isset($touristData['child']))
    																		@foreach($touristData['child'] as $k=>$v)
    @if($v)
      <div class="order-pay-msg-title">
        <span>旅客信息(儿童)</span>
      </div>
      <p class="s2">旅客姓名：{{$v['name']}}  {{config('common.sex')[$v['sex']?:1]['zh_cn']}} 英文姓:{{$v['englishXing']}} 英文名:{{$v['englishName']}} 证件信息({{config('tour.zhengjian')[$v['zhengjianType']]['zh_cn']}}):{{$v['zhengjian']}} 生日:{{$v['birther_day']}} 手机:{{$v['phone']}}</p>
      @endif
    @endforeach
    @endif
																	</li>
																</ul>
															</div>
														</div>
														<div class="col-sm-6" style="min-height: 200px;">
															<div class="row">
																<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
																	<b>订单信息</b>
																</div>
															</div>

															<div>
																<ul class="list-unstyled  spaced">
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>订单编号:{{$data['orderData']['order_sn']}}
																	</li>
																	<li>
																		<i class="ace-icon fa fa-caret-right green"></i>订单状态:{{trans(config('order.orderStatus')[$data['orderData']['status']])}}
																	</li>

																</ul>
															</div>
														</div>
</div>
@endsection @section('pageScript') @parent



@endsection @section('inlineScript')
@endsection

