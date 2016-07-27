@extends('admin.layouts.master') @section('title', '会奖案例')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.css')}}" />
<div class="page-content">
	<button class="btn btn-xs btn-success" onclick="addRecommend();">
		<span>新增</span>
	</button>
	<button class="btn btn-xs btn-danger" onclick="dels();">
		<i class="ace-icon fa fa-trash-o bigger-120"></i>
	</button>
	</br>
	<form action="">
		<label>ID:</label><input type="text" placeholder="id" class="input-large"
			name="id" value="{{Input::get('id')}}">
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
									<th>名称</th>
									<th>类型</th>
									<th>开始日期</th>
									<th>结束日期</th>
									<th>天数</th>
									<th>目的地</th>
									<th>人数</th>
									<th>人均费用</th>
									<th>客户名称</th>
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
									<td>{{$v->title}}</td>
									<td>{{trans(config('mice.case_type')[$v->type])}}</td>
									<td>{{date('Y-m-d',$v->start_time)}}</td>
									<td>{{date('Y-m-d',$v->start_time+($v->day*86400))}}</td>
									<td>{{$v->day}}</td>
									<td>{{App\Models\Area::getNameById($v->destination)}}</td>
									<td>{{$v->people_num}}</td>
									<td>{{$v->cost}}</td>
									<td>{{$v->customer}}</td>
									<td>
										<div
											class="visible-md visible-lg hidden-sm hidden-xs btn-group">
											<button onclick="updateRecommend({{$v->id}});"
												class="btn btn-xs btn-warning">查看</button>
											<button class="btn btn-xs btn-info"
												onclick="updateRecommend({{$v->id}});">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
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
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">



				<label style="width: 25%">名称:</label>
				<input type="text" placeholder="名称" id="title" class="input-large" name="title">
						</div>
							<div class="form-group" style="width: 45%;float:left;">
					<label style="width: 25%">类型</label> <select id="type" class="input-large" name="type"> @foreach(config('mice.case_type')
					as $k=>$v)
					<option value="{{$k}}">{{trans($v)}}</option> @endforeach
				</select>
				<div class="space-2"></div>
		</div>

		<div class="form-group" style="width: 45%;float:left;margin-left:100px">

				<label style="width: 25%">开始日期:</label>

				<!-- #section:plugins/date-time.datepicker -->

				<input class="date-picker input-large time" id="start_time" type="text" name="start_time" />
		</div>
<div class="form-group" style="width: 45%;float:left;">
				<label style="width: 25%">天数</label> <input type="text" placeholder="天数"
					id="day_num" class="input-large" name="day_num">
				<div class="space-2"></div>
		</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">


				<label style="width: 25%">目的地</label> <select class="chosen-select input-large"
					id="destination" data-placeholder="选择目的地." name="destination">
					<option value=""></option>
					@foreach(App\Models\Area::getAllIdName('zh_cn') as $k=>$v)
					<option value="{{$k}}">{{$v}}</option>
					@endforeach
				</select>
				</div>
				<div class="form-group" style="width: 45%;float:left;">
          <label style="width: 25%">人数</label> <input type="text" placeholder="人数"
					id="people_num" class="input-large" name="people_num">
				<div class="space-2"></div>
		</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">


				<label style="width: 25%">人均费用</label> 
				<input type="text" placeholder="人均费用" id="cost" class="input-large" name="cost">
</div>
<div class="form-group" style="width: 45%;float:left;">
				<label style="width: 25%">服务内容</label> <input type="text"
					placeholder="服务内容" id="service_content" class="input-large"
					name="service_content">
				<div class="space-2"></div>
		</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">
				<label style="width: 25%">客户名称</label> 
				<input type="text" placeholder="客户名称" id="customer" class="input-large" name="customer">
				</div>
				<div class="form-group" style="width: 45%;float:left;">
    <label style="width: 25%">联系人</label> <input type="text" placeholder="联系人"
					id="contact_name" class="input-large" name="contact_name">
				<div class="space-2"></div>
		</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">

				<label style="width: 25%">联系方式</label> 
				<input type="text" placeholder="联系方式" id="contact_info" class="input-large" name="contact_info">
				</div>
<div class="form-group" style="width: 45%;float:left;">
<label style="width: 25%">邮箱</label> <input type="text" placeholder="邮箱"
					id="email" class="input-large" name="email">
				<div class="space-2"></div>
			</div>

		<div class="form-group">
			<div class="col-xs-12">
				<!-- #section:custom/file-input -->
				内容背景图片(建议大小1920X650) <input type="file" name="file" id="id-input-file-2" />
			</div>
		</div>
		<div style="margin-bottom: 30px;">
			活动概述:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="event_overview" name="event_overview" type="text/plain"
					style="width: 846px; height: 420px;">
						</script>
			</div>
			<!--endbianji-->
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

    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/ueditor.all.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/lang/zh-cn/zh-cn.js')}}"></script>

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
					$('.chosen-select').chosen({allow_single_deselect:true,
						search_contains: true,//模糊搜索
						no_results_text : "未找到此选项!", 

						}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': '211px'});
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
			//实例化编辑器
			var ue = UE.getEditor('desc');
			$('#desc').focus(function() {
				//$(this).empty();
			})
						//实例化编辑器
			var ue1 = UE.getEditor('event_overview');
			$('#event_overview').focus(function() {
				//$(this).empty();
			})
			function delRecommend(id){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{url('admin/mice/delcases')}}",
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
		  		         url: "{{url('admin/mice/delcases')}}",
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
			  			       //console.log(infoData);
			  			             $('input[name="title"]').val(infoData.title);
			  			           $('#type').val(baseData.type);
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
			  			             //$('#event_overview').val(infoData.event_overview);
			  			            //$('#desc').val(infoData.desc);
			  			          ue.setContent(infoData.desc);
			  			           ue1.setContent(infoData.event_overview);
			  			             var imageHtml='图片:<img style="width: 150px;height:150px" src="@storageAsset("'+baseData.image+'")"/>';
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
				 }
			 function addRecommend(){
				 $('#recommend-form').attr('action',"{{url('admin/mice/addcases')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
 			      $('#destination').val('');
	  			   $("#destination").trigger("chosen:updated");
				 ue.setContent('');
				 ue1.setContent('');
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
				$(element).focus();
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


		</script>
@endsection

