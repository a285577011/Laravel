@extends('admin.layouts.master')
@section('title', '货币管理(注意:汇率统一为人民币汇率)')
@section('content')
	<div class="page-content">
														<button class="btn btn-xs btn-success" onclick="addRecommend();">
																<span>新增</span>
															</button>
															<button class="btn btn-xs btn-danger" onclick="delsRecommend();">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>
								<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace checkall"/>
																<span class="lbl"></span>
															</label>
														</th>
														<th>ID</th>
														<th>货币名称</th>
														<th class="hidden-480">货币代码</th>

														<th>
															货币汇率
														</th>

														<th>操作</th>
													</tr>
												</thead>

												<tbody>
												@if($data->count())
												@foreach($data as $v)
											<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace ids" value="{{$v->id}}"/>
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															{{$v->id}}
														</td>
														<td>{{$v->name}}</td>
														<td class="hidden-480">{{$v->code}}</td>
														<td>{{$v->value}}</td>

														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-info" onclick="updateRecommend({{$v->id}});">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>
															<button class="btn btn-xs btn-danger" onclick="delRecommend({{$v->id}});">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>
															</div>
														</td>
													</tr>
													@endforeach
												@else
												<tr><td>暂无数据</td></tr>
												@endif
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
								</div><!-- /row -->

							
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
				{!!$data->appends(Input::get())->render()!!}
<div class="hr hr-24"></div>
		<!-- basic scripts -->
		<form class="form-horizontal" role="form" action="{{route('admin::currencyLists')}}" enctype="multipart/form-data" method="post" id="recommend-form" style="display:none;">
		{!! csrf_field() !!}
		<div id="updateImage"></div>
		<div id="updateId"></div>
<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">货币名称</label>

										<div class="col-sm-9">
											<input type="text" placeholder="货币名称" id="name" class="input-sm" name="name">
											<div class="space-2"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">货币代码</label>

										<div class="col-sm-9">
											<input type="text" placeholder="货币代码" id="sort" class="input-sm" name="code">
											<div class="space-2"></div>
										</div>
									</div>																		<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">
货币汇率 </label>

										<div class="col-sm-9">
											<input type="text" placeholder="货币汇率 " id="value" class="input-sm" name="value">
											<div class="space-2"></div>
										</div>
									</div>																											<div class="form-group">

															<button class="btn btn-sm btn-success" type="submit">
																提交
																<i class="icon-arrow-right icon-on-right bigger-110"></i>
															</button>
									</form>

		<!--[if !IE]> -->
</div>
@endsection
@section('pageScript')
@parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
@endsection



@section('inlineScript')
		<script type="text/javascript">
			$(function () {
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
				$.validator.setDefaults({
					errorElement:'span'
				});
				
				var cnmsg = {
					required: '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">必填项</span></span>',
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
				}, '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">长度在{0}-{1}之间，请重新输入</span></span>');
				jQuery.validator.addMethod("weixinOrqq", function(value, element) {
					return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
				}, '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请输入正确的QQ或微信号</span></span>');
				jQuery.validator.addMethod("isMobile", function(value, element) {
					var length = value.length;
					return this.optional(element) || (length == 11 && /^(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/.test(value))
				}, '<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请填写正确的手机号</span></span>');
				$('#recommend-form').validate({
					rules: {
						name: {
							required: true,
						},
						value: {
							required: true,
							number: true,
							min:0
						},
						code: {
							required: true,
						},
					},
					messages: {
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
				//.form-group.has-error .control-label, .form-group.has-error .help-block, .form-group.has-error .help-inline
				});
			function delRecommend(id){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{route('admin::delCurrency')}}",
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
			function delsRecommend(){
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
		  		         url: "{{route('admin::delCurrency')}}",
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
		  		         url: "{{route('admin::getCurrency')}}",
		  		         data: {'id':id},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
			  			             var info=data.data;
			  			             $('input[name="name"]').val(info.name);
			  			             $('input[name="code"]').val(info.code);
			  			             $('input[name="value"]').val(info.value);
			  			             var updateUrl="{{route('admin::updateCurrency')}}";
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
				 $('#recommend-form').attr('action',"{{route('admin::currencyLists')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
				 showForm();
				 }			 
		</script>
@endsection

