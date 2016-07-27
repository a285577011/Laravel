@extends('admin.layouts.master') @section('title', '详细行程(线路:'.$data['name'].')')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.css')}}" />
		<link rel="stylesheet" href="{{ asset('admin/components/kindeditor/themes/default/default.css')}}" />
	<link rel="stylesheet" href="{{ asset('admin/components/kindeditor/plugins/code/prettify.css')}}" />
<div class="page-content">
@include('admin.tour.common_nav')
		<button class="btn btn-xs btn-success" onclick="addRecommend();">
			<span>新增</span>
		</button>
		<button class="btn btn-xs btn-danger" onclick="dels();">
			<i class="ace-icon fa fa-trash-o bigger-120"></i>
		</button>
	</br>
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
									<th>第几天</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@if($data['list']->count()) @foreach($data['list'] as $v)
								<tr>
									<td class="center"><label> <input type="checkbox"
											class="ace ids" value="{{$v->id}}" /> <span class="lbl"></span>
									</label></td>
									<td>{{$v->id}}</td>
									<td>{{$v->day}}</td>
								
									<td>
										<div
											class="visible-md visible-lg hidden-sm hidden-xs btn-group">
											<button class="btn btn-xs btn-info" onclick="updateRecommend({{$v->id}});">
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
	{!!$data['list']->appends(Input::get())->render()!!}
	<div class="hr hr-24"></div>
	<!-- basic scripts -->
	<form class="form-horizontal" role="form"
		action="{{route('admin::addTourToTravel',['tourId'=>Input::get('id')])}}" enctype="multipart/form-data"
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
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">第几天:</label>

										<div class="col-sm-9">
											<input type="text" placeholder="第几天:" id="day" class="input-large" name="day">
											<div class="space-2"></div>
										</div>
									</div>

									
									
									
																											<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right">出发地点:</label><div class="inline col-sm-3"><input type="text" class="input-sm" name="area" id="form-field-tags2"  placeholder="" />
																							<a target="_blank" href="{{route('admin::areaList')}}"  style="position: absolute;line-height:30px" >
									新增
								</a>
										<div class="col-sm-9">
											<div class="space-2"></div>
										</div>
									</div>		
									</div>
																		<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right">目的地地点:</label><div class="inline col-sm-3"><input type="text" class="input-sm" name="destination" id="form-field-tags"  placeholder="" />
																							<a target="_blank" href="{{route('admin::areaList')}}"  style="position: absolute;line-height:30px" >
									新增
								</a>
										<div class="col-sm-9">
											<div class="space-2"></div>
										</div>
									</div>		
									</div>
									<!-- 
						<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right">交通工具:</label><div class="inline"><input type="text" class="input-sm" name="transport" id="form-field-tags2"  placeholder="" />
										<div class="col-sm-9">
											<div class="space-2"></div>
										</div>
									</div>	
									</div>																											<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">
图片:</label>

										<div class="col-sm-3">
											<input type="file" name="file" id="id-input-file-2" />
											<div class="space-2"></div>
										</div>
									</div>-->	
<h4>详细行程流程:</h4>
<div class="hr hr-24"></div>									
						<!--endbianji-->
				<div style="margin-bottom: 30px;">
			景点:
							<textarea placeholder="景点" id="jingdian" class="form-control" name="jingdian"></textarea>
			</div>
			<div style="margin-bottom: 30px;">
				餐饮:
<textarea placeholder="餐饮" id="cangyin" class="form-control" name="cangyin"></textarea>
			</div>
						<!--endbianji-->
			<div style="margin-bottom: 30px;">
			住宿信息:
<textarea placeholder="住宿信息" id="zhusu" class="form-control" name="zhusu"></textarea>
			</div>
					<div style="margin-bottom: 30px;">
			集合:
						<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="jihe" name="jihe" type="text/plain"
					style="width: 846px; height: 420px;">
</script>
			</div>
			</div>
					<div style="margin-bottom: 30px;">
			交通:
									<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="jiaotong" name="jiaotong" type="text/plain"
					style="width: 846px; height: 420px;">
</script>
			</div>
			<!--bianji-->
			</div>
			<!--endbianji-->
			<div style="margin-bottom: 30px;">
			行程介绍:
												<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="xingcheng_jieshao" name="xingcheng_jieshao" type="text/plain"
					style="width: 846px; height: 420px;">
</script>
			</div>
			<!--bianji-->
			</div>
		</div>
		<button class="btn btn-sm btn-success" type="button" id="simpleButton">提交</button>
	</form>
	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('admin/components/chosen/chosen.jquery.js')}}"></script>
<!-- 下拉选择 -->
   <script src="{{ asset('admin/components/_mod/bootstrap-tag/bootstrap-tag.js')}}"></script><!-- 文本框 -->
<!-- 配置文件 -->
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.all.min.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/lang/zh-cn/zh-cn.js')}}"></script>
@endsection @section('inlineScript')
<script type="text/javascript">
			$(function () {
			   

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
							 $this.next().css({'width': '210px'});
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
				 var tag_input = $('#form-field-tags');
					try{
						tag_input.tag(
						  {
							placeholder:tag_input.attr('placeholder'),
							//enable typeahead by specifying the source array
							source: {!!json_encode(array_values(App\Models\Area::getAllIdName('zh_cn')))!!}//["Alabama","Alaska","Arizona"]
							//source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
							/**
							//or fetch data from database, fetch those that match "query"
							source: function(query, process) {
							  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
							  .done(function(result_items){
								process(result_items);
							  });
							}
							*/
						  }
						)
				
						//programmatically add/remove a tag
						var $tag_obj = $('#form-field-tags').data('tag');
						//$tag_obj.add('Programmatically Added');
						
						var index = $tag_obj.inValues('some tag');
						$tag_obj.remove(index);
					}
					catch(e) {
						//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
						tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
						//autosize($('#form-field-tags'));
					}
					var tag_input = $('#form-field-tags2');
					try{
						tag_input.tag(
						  {
							placeholder:tag_input.attr('placeholder'),
							//enable typeahead by specifying the source array
							source:{!!json_encode(array_values(App\Models\Area::getAllIdName('zh_cn')))!!},
							//source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
							/**
							//or fetch data from database, fetch those that match "query"
							source: function(query, process) {
							  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
							  .done(function(result_items){
								process(result_items);
							  });
							}
							*/
						  }
						)
				
						//programmatically add/remove a tag
						var $tag_obj = $('#form-field-tags2').data('tag');
						//$tag_obj.add('Programmatically Added');
						
						var index = $tag_obj.inValues('some tag');
						$tag_obj.remove(index);
					}
					catch(e) {
						//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
						tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
						//autosize($('#form-field-tags'));
					}								
				//.form-group.has-error .control-label, .form-group.has-error .help-block, .form-group.has-error .help-inline
				});
			//实例化编辑器
			var ue = UE.getEditor('jihe');
			$('#jihe').focus(function() {
				//$(this).empty();
			})
								//实例化编辑器
				var ue1 = UE.getEditor('jiaotong');
				$('#jiaotong').focus(function() {
					//$(this).empty();
				})
									//实例化编辑器
				var ue2 = UE.getEditor('xingcheng_jieshao');
				$('#xingcheng_jieshao').focus(function() {
					//$(this).empty();
				})

					 
			/*var editor=null;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="desc"]', {
					cssPath : '{{ asset('admin/components/kindeditor/plugins/code/prettify.css')}}',
					uploadJson : '{{ asset('admin/components/kindeditor/php/upload_json.php')}}',
					fileManagerJson : '{{ asset('admin/components/kindeditor/php/file_manager_json.php')}}',
					allowFileManager : true,
					afterCreate : function() {
						
					}
				});
				editor.html('{!!config('tour.tour_detail')[1]!!}');
				prettyPrint();
			});*/
			function delRecommend(id){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{route('admin::delTourToTravel')}}",
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
		  		         url: "{{route('admin::delTourToTravel')}}",
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
		  		         url: "{{route('admin::getTravelById')}}/"+id+"",
		  		         data: {},
		  		         beforeSend : function(){
		  					 $('#jingdian').val('');
		  					$('#cangyin').val('');
		  					$('#zhusu').val('');
		  					 ue.setContent('');
		  					 ue1.setContent('');
		  					 ue2.setContent('');
		  		    },
		  		             success: function(data){
		  			             if(data.status){
			  			            // console.log(data);
			  			             $('input[name="day"]').val(data.data.day);
			  			          $('#area').val(data.data.area);
			  			      $("#area").trigger("chosen:updated");
			  	      var $tag_obj = $('#form-field-tags').data('tag');
			  	    var $tag_obj2 = $('#form-field-tags2').data('tag');
			  			var tag_val=$('input[name="destination"]').val();
			  			if(tag_val){
					  		tag_val=tag_val.split(',');
					  			for (var i=0;i<tag_val.length;i++)
					  			{
					  				$tag_obj.remove(0);
					  			}
			  			}
			  			var tag_val_area=$('input[name="area"]').val();
			  			if(tag_val_area){
			  				tag_val_area=tag_val_area.split(',');
					  			for (var i=0;i<tag_val_area.length;i++)
					  			{
					  				$tag_obj2.remove(0);
					  			}
			  			}
			  			for (var i=0;i<data.data.destination.length;i++)
			  			{
			  				$tag_obj.add(data.data.destination[i]);
			  			}
			  			for (var i=0;i<data.data.area.length;i++)
			  			{
			  				$tag_obj2.add(data.data.area[i]);
			  			}
			  			 	  	var desc = data.data.desc;
			  			 	  	if(desc){
				  			 	  	if(desc.jihe){
			  			 	  	 ue.setContent(desc.jihe);
				  			 	  	}
				  			 	 if(desc.jiaotong){ue1.setContent(desc.jiaotong);}
				  			 	if(desc.xingcheng_jieshao){ue2.setContent(desc.xingcheng_jieshao);}
				  			 	  $('#cangyin').val(desc.cangyin);
					  			 	$('#jingdian').val(desc.jingdian);
					  			 	$('#zhusu').val(desc.zhusu);
			  			 	  	}
			  			             var imageHtml='图片:<img src="@storageAsset("'+data.data.image+'")"/>';
			  			             //$('#updateImage').html(imageHtml);
			  			             var updateUrl="{{route('admin::updateTourToTravel')}}";
			  			             var idInput='<input type="hidden" value='+id+' name="id">';
			  			             $('#updateId').html(idInput);
			  			             $('#recommend-form').attr('action',updateUrl);
			  			             showForm();
		  			             }
		  			             else{
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
				 $('#recommend-form').attr('action',"{{route('admin::addTourToTravel',['tourId'=>Input::get('id')])}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 var $tag_obj = $('#form-field-tags').data('tag');
		  			var tag_val=$('input[name="destination"]').val();
		  			if(tag_val){
			  		tag_val=tag_val.split(',');
			  			//console.log($tag_val);
			  			//console.log($tag_val.length);
			  			for (var i=0;i<tag_val.length;i++)
			  			{
				  			//var index = $tag_obj.inValues($tag_val[i].replace(/(^\s*)|(\s*$)/g, ""));
				  			//alert(index);
			  				$tag_obj.remove(0);
			  			}
		  			}
					 var $tag_obj2 = $('#form-field-tags2').data('tag');
			  			var tag_val_area=$('input[name="area"]').val();
			  			if(tag_val_area){
			  				tag_val_area=tag_val_area.split(',');
				  			//console.log($tag_val);
				  			//console.log($tag_val.length);
				  			for (var i=0;i<tag_val_area.length;i++)
				  			{
					  			//var index = $tag_obj.inValues($tag_val[i].replace(/(^\s*)|(\s*$)/g, ""));
					  			//alert(index);
				  				$tag_obj2.remove(0);
				  			}
			  			}
				 $('#recommend-form')[0].reset();
				 ue.setContent('');
				 ue1.setContent('');
				 ue2.setContent('');
  			      $('#area').val('');
	  			   $("#area").trigger("chosen:updated");
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
				day: {
					required: true,
					number: true,
					min:1
				},
				desc: {
					//required: true,
				},
			},
			messages: {
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
		    	//if(!$('input[name="destination"]').val()){
                  //  alert('请填写目的地!');
 	                //   return false;  	}
		    	if(!$('input[name="area"]').val()){
                    alert('请填写出发地!');
 	                   return false;  	}
		    	var data=$(form).serialize();
		    	//console.log(data);
		    	//return false;
		   $.post($(form).attr("action"), data, success, "json");
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
		$(document).on('click', '#simpleButton', function () { 
			$('#recommend-form').submit();
			});
		</script>
@endsection

