@extends('admin.layouts.master') @section('title', '跟团游列表')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.min.css')}}" />
<div class="page-content">
	<button class="btn btn-xs btn-success" onclick="window.location.href='{{url('admin/tour/addtour')}}'">
		<span>新增</span>
	</button>
	<button class="btn btn-xs btn-danger" onclick="dels();">
		<i class="ace-icon fa fa-trash-o bigger-120"></i>
	</button>
	</br>
	<form action="">
		<label>ID:</label><input type="text" placeholder="id" class="input-sm"
			name="id" value="{{Input::get('id')}}">
			<label style="margin-left:10px;">线路名称:</label>
			<input type="text" placeholder="线路名称" class="input-sm"
			name="name" value="{{Input::get('name')}}">
			
			<label>状态</label> <select id="status" class="short"
					style="width: 22.5%" name="status" >
					 @foreach(config('tour.tour_status') as $k=>$v)
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
									<th>线路名称</th>
									<th>行程天数</th>
									<th>价格</th>
									<th>儿童价格</th>
									<th>预订数量</th>
									<th>最低成团数数</th>
									<th>出发地区</th>
									<th>产品类型</th>
									<th>目的地</th>
									<th>线路状态</th>
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
									<td><a target="_blank" href="{{url('tour/detail').'/'.$v->id}}">{{$v->name.'('.$v->days.'天'.$v->nights.'夜)'}}</a></td>
									<td>{{$v->schedule_days}}</td>
									<td>{{$v->price}}</td>
									<td>{{$v->child_price}}</td>
									<td>{{$v->booking_count}}</td>
									<td>{{$v->lowest_people}}@if($v->booking_count>=$v->lowest_people)  （可成团） @else （不可成团）  @endif</td>
									<td>
							<?php $destination=array_filter(@explode(',', $v->leave_area));
									$destinationStr='';
									if($destination){
									foreach ($destination as $vc){
									    $destinationStr.=App\Models\Area::getNameById($vc).',';
									}
									}
									echo rtrim($destinationStr,',');
									?>
									</td>
									<td>{{config('tour.tour_type')[$v->type]}}</td>
									<td>
									<?php $destination=array_filter(@explode(',', $v->destination));
									$destinationStr='';
									if($destination){
									foreach ($destination as $vc){
									    $destinationStr.=App\Models\Area::getNameById($vc).'-';
									}
									}
									echo rtrim($destinationStr,'-');
									?></td>
									<td>{{config('tour.tour_status')[$v->tour_status]}}</td>
									<td>
										<div
											class="visible-md visible-lg hidden-sm hidden-xs btn-group">
											<button class="btn btn-xs btn-info"
												onclick="window.location.href='{{route('admin::updateTour',['id'=>$v->id,'step'=>1])}}'">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
											@if($v->tour_status==-1||$v->tour_status==1)
                                                <button class="btn btn-xs btn-warning" @if($v->tour_status==-1) onclick="checkTour({{$v->id}},1);" @elseif($v->tour_status==1) onclick="checkTour({{$v->id}},-1);" @endif>
																<i class="ace-icon fa fa-flag bigger-120">@if($v->tour_status==-1)审核通过@elseif($v->tour_status==1)审核不通过 @endif</i>
												</button>
												@endif
											<button class="btn btn-xs btn-danger"
												onclick="delRecommend({{$v->id}});">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</button>
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
	<form class="form-horizontal" role="form"
		action="{{url('admin/mice/addcases')}}" enctype="multipart/form-data"
		method="post" id="recommend-form" style="display: none;">
		<h1><?php
switch (\App::getLocale()) {
    case 'zh_cn':
        echo '中文表单';
        break;
    case 'en_us':
        echo '英文表单';
        break;
    case 'zh_tw':
        echo '繁体中文表单';
        break;
}
?></h1>
		{!! csrf_field() !!}
		<div id="updateImage"></div>
		<div id="updateId"></div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">名称:</label><input type="text"
					placeholder="名称" id="title" class="input-sm" name="title">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">类型</label> <select id="type" class="short"
					style="width: 18.5%" name="type"> @foreach(config('mice.case_type')
					as $k=>$v)
					<option value="{{$k}}">{{$v}}</option> @endforeach
				</select>
				<div class="space-2"></div>
			</div>
		</div>

		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">开始日期:</label>

				<!-- #section:plugins/date-time.datepicker -->

				<input class="date-picker input-sm time" id="start_time" type="text"
					name="start_time" />

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">天数</label> <input type="text" placeholder="天数"
					id="day_num" class="input-sm" name="day_num">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">目的地</label> <select class="chosen-select"
					id="destination" data-placeholder="选择目的地." name="destination">
					<option value=""></option>
					<option value="1">Alabama</option>
					<option value="2">Alaska</option>
					<option value="3">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">人数</label> <input type="text" placeholder="人数"
					id="people_num" class="input-sm" name="people_num">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">人均费用</label> <input type="text"
					placeholder="人均费用" id="cost" class="input-sm" name="cost">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">服务内容</label> <input type="text"
					placeholder="服务内容" id="service_content" class="input-sm"
					name="service_content">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">客户名称</label> <input type="text"
					placeholder="客户名称" id="customer" class="input-sm" name="customer">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">联系人</label> <input type="text" placeholder="联系人"
					id="contact_name" class="input-sm" name="contact_name">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 10%">联系方式</label> <input type="text"
					placeholder="联系方式" id="contact_info" class="input-sm"
					name="contact_info">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 10%">邮箱</label> <input type="text" placeholder="邮箱"
					id="email" class="input-sm" name="email">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<!-- #section:custom/file-input -->
				头显示图片 <input type="file" name="file" id="id-input-file-2" />
			</div>
		</div>
		<div style="margin-bottom: 30px;">
			活动概述:

			<textarea placeholder="活动概述..." id="event_overview"
				class="form-control" name="event_overview"></textarea>
		</div>
		<div style="margin-bottom: 30px;">
			详情:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="desc" name="desc" type="text/plain"
					style="width: 846px; height: 420px;">
						</script>
			</div>
			<!--endbianji-->
		</div>
		<button class="btn btn-sm btn-success" type="submit">提交</button>
	</form>

	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('admin/components/chosen/chosen.jquery.js')}}"></script>
<!-- 下拉选择 -->

<link
	href="{{ asset('admin/components/datetimepicker/css/datetimepicker.css')}}"
	rel="stylesheet" type="text/css">
<link
	href="{{ asset('admin/components/datetimepicker/css/datetimepicker_blue.css')}}"
	rel="stylesheet" type="text/css">
<link
	href="{{ asset('admin/components/datetimepicker/css/dropdown.css')}}"
	rel="stylesheet" type="text/css">
<script type="text/javascript"
	src="{{ asset('admin/components/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript"
	src="{{ asset('admin/components/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"
	charset="UTF-8"></script>


@endsection @section('inlineScript')
<script type="text/javascript">
			$(function () {
				//时间
			    $('.time').datetimepicker({
			        format: 'yyyy-mm-dd',
			        language:"zh-CN",
			        minView:2,
			        autoclose:true
			    });
			   

				//chosen 搜索
								if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': '18.2%'});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							// $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
								//文件图片框
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				 $(".ids").click(function(){
						var option = $(".ids");
						$(this).is(':checked')?$(this).attr("checked", true):$(this).attr("checked", false);
						option.each(function(i){
							if(!this.checked){
								$(".checkall").prop("checked", false);
								return false;
							}else{
								$(".checkall").prop("checked", true);
							}
						});
				 });
				 $('.checkall').click(function(){
					 $(".ids").prop("checked", this.checked);
				 });				
				//.form-group.has-error .control-label, .form-group.has-error .help-block, .form-group.has-error .help-inline
				
				});
			function delRecommend(id){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{route('admin::delTour')}}",
		  		         data: {'id':id},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
		                              alert(data.info);
		                              setTimeout(function(){
		                                  location.reload();
		                                 },150);
		  			             }
		  			             else{
		  			            	 alert(data.info);
		      			             }     
		  		             },
		  		     error: function(){
		  		     alert("系统繁忙");
		  		     }
		  		           });
				}
			function dels(){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		        var id=getId();
		        if(id.length==0){
			        alert('请选择');
			        return false;
			        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{route('admin::delTour')}}",
		  		         data: {'id':id},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
		                              alert(data.info);
		                              setTimeout(function(){
		                                  location.reload();
		                                 },150);
		  			             }
		  			             else{
		  			            	 alert(data.info);
		      			             }     
		  		             },
		  		     error: function(){
		  		     alert("系统繁忙");
		  		     }
		  		           });
				}
			 function getId(){
			     var id=[];  
			     $('.ids').each(function(i) {
			         if ($(this).is(':checked')) { 
			        	 id.push($(this).val()); 
			         }
			     }); 
			     return id;
				 }
			 function updateRecommend(id){
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{url('admin/mice/casesdetail')}}/"+id+"",
		  		         data: {},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
			  			             var baseData=data.data.baseData;
			  			             var infoData=data.data.infoData;
			  			             console.log(data);
			  			             $('input[name="title"]').val(infoData.title);
			  			           $('input[name="type"]').val(baseData.type);
			  			         $('input[name="start_time"]').val(baseData.start_time);
			  			       $('input[name="day_num"]').val(baseData.day);
			  			     $('#destination').val(baseData.destination);
			  			   $("#destination").trigger("chosen:updated");
			  			   $('input[name="people_num"]').val(baseData.people_num);
			  			 $('input[name="cost"]').val(baseData.cost);
			  			$('input[name="service_content"]').val(infoData.service_content);
			  			$('input[name="customer"]').val(infoData.customer);
			  			$('input[name="contact_name"]').val(infoData.contact_name);
			  			$('input[name="contact_info"]').val(baseData.contact_info);
			  			             $('#event_overview').val(infoData.event_overview);
			  			            $('#desc').val(infoData.desc);
			  			             var imageHtml='图片:<img src="@storageAsset("'+baseData.image+'")"/>';
			  			             $('#updateImage').html(imageHtml);
			  			             $('input[name="email"]').val(baseData.email);
			  			             var updateUrl="{{url('admin/mice/updatecases')}}";
			  			             var idInput='<input type="hidden" value='+id+' name="id">';
			  			             $('#updateId').html(idInput);
			  			             $('#recommend-form').attr('action',updateUrl);
			  			             showForm();
		  			             }
		  			             else{
		  			            	 //alert(data.info);
		      			             }     
		  		             },
		  		     error: function(){
		  		     alert("系统繁忙");
		  		     }
		  		           });
				 }
			 
			 function showForm(){
				 $('#recommend-form').show();
				 location.href = "#recommend-form";
					//实例化编辑器
					var um = UM.getEditor('desc');
					$('#desc').focus(function() {
						//$(this).empty();
					})
				 }
			 function addRecommend(){
				 $('#recommend-form').attr('action',"{{url('admin/mice/addcases')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
				 showForm();
				 }			 
		</script>
<script>
		$.validator.setDefaults({
			errorElement:'span'
		});
		
		var cnmsg = {
			required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">必填项</span></span>',
			number :'<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入数字</span></span>',
			equalTo: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请再次输入相同的值</span></span>',
			maxlength: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">最多输入{0}个字符</span></span>'),
			minlength: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">最少输入{0}个字符</span></span>'),
			rangelength: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入{0}到{1}个字符</span></span>'),
			range: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入{0}到{1}之间的值</span></span>'),
			max: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入小于 {0}的值</span></span>'),
			min: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入大于 {0}的值</span></span>'),
			email: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入正确的邮箱</span></span>'),
			url: jQuery.format('<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入正确的URL</span></span>'),
		};

		$.extend($.validator.messages, cnmsg);
		jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {
			var length = value.length;
			for (var i = 0; i < value.length; i++) {
				if (value.charCodeAt(i) > 127) {
					length++
				}
			}
			return this.optional(element) || (length >= param[0] && length <= param[1])
		}, '<span class="has-error" style="position: absolute;line-height:30px"><span class="lgfork"></span>长度在{0}-{1}之间，请重新输入</span>');
		jQuery.validator.addMethod("weixinOrqq", function(value, element) {
			return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
		}, '<span class="has-error" style="position: absolute;line-height:30px"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
		jQuery.validator.addMethod("isMobile", function(value, element) {
			var length = value.length;
			return this.optional(element) || (length == 11 && /^(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/.test(value))
		}, '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;"></span>请填写正确的手机号</span>');
		$('#recommend-form').validate({
			rules: {
				title: {
					required: true,
				},
				event_overview: {
					required: true,
				},
				type: {
					required: true,
					number: true,
					min:1
				},
				url : {
					required: true,
					url : true,
				},
				desc: {
					required: true,
				},
				day_num: {
					required: true,
					number: true,
					min:1
				},
				destination: {
					required: true,
					number: true,
					min:1
				},
				people_num: {
					required: true,
					number: true,
					min:1
				},
				cost: {
					required: true,
					number: true,
					min:1
				},
				service_content: {
					required: true,
				},
				customer: {
					required: true,
				},
				contact_name: {
					required: true,
				},
				contact_info: {
					required: true,
				},
				email: {
					required: true,
					email:true,
				},
			},
			messages: {
				url: {
					required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入URL</span></span>',
					url:'<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入正确的URL</span></span>',
				},
				name: {
					required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入名称</span></span>',
				},
				desc: {
					required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入详情</span></span>',
				},
				sort: {
					required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入排序值</span></span>',
					number: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">排序值必须为数字</span></span>',
					min: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">排序值最小为{0}的值</span></span>',
				},
			},
			errorPlacement: function(error, element) {
				element.after(error);
				//if (element.parent().find('.clear').length > 0) error.insertBefore(element.parent().find('.clear'));
				//else if (element.is(":radio")) error.appendTo(element.parent());
				//else error.appendTo(element.parent());
			},
			success: function(label) {
				label.html('<span class="lgtick"></span>')
			},
			focusInvalid: false,
			onkeyup: false,
	    	submitHandler: function(form) {
		    	if(!$('#destination').val()){
                       alert('请选择目的地!');
                  return false;  	}
		    	if(!$('#start_time').val()){
                    alert('请选开始时间!');
               return false;  	
               }
		    	var data=$(form).serialize();
		    	//console.log(data);
		    	//return false;
		   $.post($(form).attr("action"), self.serialize(), success, "json");
	        return false;
	
	           function success(data){
			             if(data.status){
                          alert(data.info);
                          setTimeout(function(){
                              location.reload();
                             },150);
			             }
			             else{
			            	 alert(data.info);
  			             }     
		             }

	  	},
		});

function checkTour(tourId,status){
	switch(status){
	case 1:
	    if(!confirm('确认审核通过？')){
	        return false;
	    }
		break;
	case -1:
	    if(!confirm('确认审核不通过？')){
	        return false;
	    }
		break;
	}
	  $.ajax({
	         type: "GET",
	         url: "{{route('admin::checkTour')}}",
	         data: {'id':tourId,'status':status},
	         beforeSend : function(){
	    },
	             success: function(data){
		             if(data.status){
		            	alert(data.info);
                       setTimeout(function(){
                           location.reload();
                          },150);
		             }
		             else{
		            	 alert(data.info);
			             }     
	             },
	     error: function(){
	     alert("系统繁忙");
	     }
	           });
}
		</script>
@endsection

