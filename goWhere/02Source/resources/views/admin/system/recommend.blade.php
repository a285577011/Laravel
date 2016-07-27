@extends('admin.layouts.master')
@section('title', '推荐管理')
@section('content')
	<div class="page-content">
	<ul class="inbox-tabs nav nav-tabs padding-16 tab-size-bigger tab-space-1" id="inbox-tabs" style="padding-left:0px;">
            @foreach(config('common.recommend_type') as $k=>$v)
            												<li @if($type==$k)class="active"@endif>
													<a  href="{{url('admin/manage/recommendlist/'.$k)}}">
														<span class="bigger-110">{{$v}}</span>
													</a>
												</li>
            @endforeach
											</ul>
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
														<th>名称</th>
														<th>排序</th>
														<th>跳转URL</th>
														<th class="hidden-480">描述</th>

														<th>
															图片
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
															{{$v->name}}
														</td>
														<td>
															{{$v->order}}
														</td>
														<td>{{$v->url}}</td>
														<td class="hidden-480">{{$v->desc}}</td>
														<td><img style="width: 150px;height:150px" src="@storageAsset($v->image)" /></td>

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
		<form class="form-horizontal" role="form" action="{{url('admin/manage/addrecommend')}}" enctype="multipart/form-data" method="post" id="recommend-form" style="display:none;">
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
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">名称</label>

										<div class="col-sm-9">
											<input type="text" placeholder="名称" id="name" class="input-sm" name="name">
											<div class="space-2"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">排序值</label>

										<div class="col-sm-9">
											<input type="text" placeholder="排序值" id="sort" class="input-sm" name="sort">
											<div class="space-2"></div>
										</div>
									</div>																		<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">
跳转URL</label>

										<div class="col-sm-9">
											<input type="text" placeholder="跳转URL" id="url" class="input-sm" name="url" value="http://">
											<div class="space-2"></div>
										</div>
									</div>																											<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">
图片</label>

										<div class="col-sm-9">
											<input type="file" name="file" id="file">
											<?php switch ($type){
											    case 8:
											        echo '(建议大小:580Px*300px)';
											        break;
											        case 1:
											            echo '(建议大小:275px*210px)';
											            break;
											            case 2:
											                echo '(建议大小:600px*265ox)';
											                break;
											                case 3:
											                    echo '第一张(建议大小:368Px*360px)
													    第二张(建议大小:816Px*360px)
													    第三张(建议大小:368Px*360px)
													    第四张(建议大小:432Px*360px)
													    第五张(建议大小:368Px*360px)';
											                    break;
											                    case 8:
											                        echo '(建议大小:500Px*300px)';
											                        break;
											        
											}?>
											
											
											<div class="space-2"></div>
										</div>
									</div>
									
									<div>
															描述:

															<textarea placeholder="描述..." id="desc" class="form-control" name="desc"></textarea>
														</div>
															<button class="btn btn-sm btn-success" type="submit">
																提交
																<i class="icon-arrow-right icon-on-right bigger-110"></i>
															</button>
															<input type="hidden" name="type" value="{{$type}}">
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
					required: '<span class="has-error"><span class="lgfork"></span>必填项</span>',
					equalTo: '<span class="has-error"><span class="lgfork"></span>请再次输入相同的值</span>',
					maxlength: jQuery.format('<span class="has-error"><span class="lgfork"></span>最多输入{0}个字符</span>'),
					minlength: jQuery.format('<span class="has-error"><span class="lgfork"></span>最少输入{0}个字符</span>'),
					rangelength: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入{0}到{1}个字符</span>'),
					range: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入{0}到{1}之间的值</span>'),
					max: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入小于 {0}的值</span>'),
					min: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入大于 {0}的值</span>'),
					email: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入正确的邮箱</span>'),
					url: jQuery.format('<span class="has-error"><span class="lgfork"></span>请输入正确的URL</span>'),
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
				}, '<span class="has-error"><span class="lgfork"></span>长度在{0}-{1}之间，请重新输入</span>');
				jQuery.validator.addMethod("weixinOrqq", function(value, element) {
					return this.optional(element) || /(^[\w]{6,20}$)|([1-9][0-9]{4,})/.test(value)
				}, '<span class="has-error"><span class="lgfork"></span>请输入正确的QQ或微信号</span>');
				jQuery.validator.addMethod("isMobile", function(value, element) {
					var length = value.length;
					return this.optional(element) || (length == 11 && /^(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/.test(value))
				}, '<span class="has-error"><span class="help-block"></span>请填写正确的手机号</span>');
				$('#recommend-form').validate({
					rules: {
						name: {
							required: true,
						},
						sort: {
							required: true,
							number: true,
							min:0
						},
						url : {
							required: true,
							url : true,
						},
						desc: {
							required: true,
						},
					},
					messages: {
						url: {
							required: '<span class="has-error"><span class="help-block">请输入URL</span></span>',
							url:'<span class="has-error"><span class="help-block">请输入正确的URL</span></span>',
						},
						name: {
							required: '<span class="has-error"><span class="help-block">请输入名称</span></span>',
						},
						desc: {
							required: '<span class="has-error"><span class="help-block">请输入描述</span></span>',
						},
						sort: {
							required: '<span class="has-error"><span class="help-block">请输入排序值</span></span>',
							number: '<span class="has-error"><span class="help-block">排序值必须为数字</span></span>',
							min: '<span class="has-error"><span class="help-block">排序值最小为{0}的值</span></span>',
						},
					},
					errorPlacement: function(error, element) {
						if (element.parent().find('.clear').length > 0) error.insertBefore(element.parent().find('.clear'));
						else if (element.is(":radio")) error.appendTo(element.parent());
						else error.appendTo(element.parent());
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
		  		         url: "{{url('admin/manage/delrecommend')}}",
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
		  		         url: "{{url('admin/manage/delrecommend')}}",
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
		  		         url: "{{url('admin/manage/getrecommend')}}",
		  		         data: {'id':id},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
			  			             var info=data.data;
			  			             //console.log(info);
			  			             $('input[name="name"]').val(info.name);
			  			             $('#desc').val(info.desc);
			  			             $('input[name="sort"]').val(info.order);
			  			             $('input[name="url"]').val(info.url);
			  			             var imageHtml='图片:<img src="@storageAsset("'+info.image+'")"/>';
			  			             $('#updateImage').html(imageHtml);
			  			             $('input[name="name"]').val(info.name);
			  			             var updateUrl="{{url('admin/manage/updaterecommend')}}";
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
				 $('#recommend-form').attr('action',"{{url('admin/manage/addrecommend')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
				 showForm();
				 }			 
		</script>
@endsection

