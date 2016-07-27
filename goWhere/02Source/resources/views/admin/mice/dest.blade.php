@extends('admin.layouts.master') @section('title', '会奖目的地')
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
									<th>会议最大容量，平方米</th>
									<th>大型会议中心数量</th>
									<th>酒店数量</th>
									<th>房间数量</th>
									<th>目的地</th>
									<th>城市名片</th>
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
									<td>{{$v->meeting_area}}</td>
									<td>{{$v->confer_center}}</td>
									<td>{{$v->hotel_num}}</td>
									<td>{{$v->hotel_rooms}}</td>
									<td><a href="{{url('mice/destdetail').'/'.$v->id}}">{{App\Models\Area::getNameById($v->area_id)}}</a></td>
									<td><img style="width: 150px;height:150px" src="@storageAsset($v->image)" /></td>
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
		action="{{url('admin/mice/adddest')}}" enctype="multipart/form-data"
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
				<label style="width: 20%">机场:</label><input type="text"
					placeholder="机场" id="airport" class="input-large" name="airport">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label style="width: 20%">会议最大容量，平方米:</label><input type="text"
					placeholder="会议最大容量，平方米" id="meeting_area" class="input-large"
					name="meeting_area">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 20%">大型会议中心数量:</label><input type="text"
					placeholder="大型会议中心数量" id="confer_center" class="input-large"
					name="confer_center">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label style="width: 20%">酒店数量</label><input type="text"
					placeholder="酒店数量" id="hotel_num" class="input-large" name="hotel_num">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 20%">目的地</label> <select class="chosen-select"
					id="destination" data-placeholder="选择目的地." name="destination">
					<option value=""></option>
					@foreach(App\Models\Area::getAllIdName('zh_cn') as $k=>$v)
					<option value="{{$k}}">{{$v}}</option>
					@endforeach
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 20%">房间数量</label> <input type="text"
					placeholder="房间数量" id="hotel_rooms" class="input-large"
					name="hotel_rooms">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="">
				<!-- #section:custom/file-input -->
				城市名片(建议大小1920X640) <input type="file" name="file" id="id-input-file-1" />
			</div>
		</div>
		<div style="margin-bottom: 30px;">
			特色活动:

			<textarea placeholder="详情..." id="feature" class="form-control"
				name="feature"></textarea>
		</div>
		<div style="margin-bottom: 30px;">
			简介:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="desc" name="desc" type="text/plain" style="width: 846px; height: 420px;">
						</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			优势:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="advantage" name="advantage" type="text/plain"
					style="width: 846px; height: 420px;">
						</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			场地:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="address" name="address" type="text/plain"
					style="width: 846px; height: 420px;">
						</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			景点:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="attractions" name="attractions" type="text/plain"
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

    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/ueditor.all.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('admin/components/utf8-php/lang/zh-cn/zh-cn.js')}}"></script>



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
				//.form-group.has-error .control-label, .form-group.has-error .help-block, .form-group.has-error .help-inline
				
				});
			var ue1 = UE.getEditor('desc');
			//ue1.setContent(infoData.desc);
			
						//实例化编辑器
		var ue2 = UE.getEditor('advantage');
		
		//ue2.setContent(infoData.advantage);	//实例化编辑器
		var ue3 = UE.getEditor('address');
		//ue3.setContent(infoData.address);
					//实例化编辑器
		var ue4 = UE.getEditor('attractions');
		//ue4.setContent(infoData.attractions);
			function delRecommend(id){
		        if(!confirm('确认删除？')){
		            return false;
		        }
		  		  $.ajax({
		  		         type: "GET",
		  		         url: "{{url('admin/mice/deldest')}}",
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
		  		         url: "{{url('admin/mice/deldest')}}",
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
		  		         url: "{{url('admin/mice/getdestbyid')}}/"+id+"",
		  		         data: {},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
		  			            	showForm();
			  			             var baseData=data.data.baseData;
			  			             var infoData=data.data.infoData;
			  			             console.log(data);
			  			             $('input[name="airport"]').val(infoData.airport);
			  			           $('input[name="meeting_area"]').val(baseData.meeting_area);
			  			         $('input[name="confer_center"]').val(baseData.confer_center);
			  			       $('input[name="hotel_num"]').val(baseData.hotel_num);
			  			               $('#destination').val(baseData.area_id);
			  			             $('#feature').val(infoData.feature);
			  			                 $("#destination").trigger("chosen:updated");
			  			                $('input[name="hotel_rooms"]').val(baseData.hotel_rooms);
			  			            //$('#desc').val(infoData.desc);
			  			          //ue1.setContent(infoData.desc);
			  			        // ue2.setContent(infoData.advantage);
			  			       //ue3.setContent(infoData.address);
			  			     //ue4.setContent(infoData.attractions);
			  			     									//实例化编辑器
					//var ue1 = UE.getEditor('desc');
					ue1.setContent(infoData.desc);
					
								//实例化编辑器
				//var ue2 = UE.getEditor('advantage');
				
				ue2.setContent(infoData.advantage);	//实例化编辑器
				//var ue3 = UE.getEditor('address');
				ue3.setContent(infoData.address);
							//实例化编辑器
				//var ue4 = UE.getEditor('attractions');
				ue4.setContent(infoData.attractions);
			  			          // $('#advantage').val(infoData.advantage);
			  			          // $('#address').val(infoData.address);
			  			          // $('#attractions').val(infoData.attractions);
			  			             var imageHtml='城市名片:<img style="width: 150px;height:150px" src="@storageAsset("'+baseData.image+'")"/>';
			  			             $('#updateImage').html(imageHtml);
			  			             $('input[name="email"]').val(baseData.email);
			  			             var updateUrl="{{url('admin/mice/updatedest')}}";
			  			             var idInput='<input type="hidden" value='+id+' name="id">';
			  			             $('#updateId').html(idInput);
			  			             $('#recommend-form').attr('action',updateUrl);
			  			           //  showForm();
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
				 $('#recommend-form').attr('action',"{{url('admin/mice/adddest')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
			      $('#destination').val('');
	  			   $("#destination").trigger("chosen:updated");
					ue1.setContent('');
					
					//实例化编辑器
	//var ue2 = UE.getEditor('advantage');
	
	ue2.setContent('');	//实例化编辑器
	//var ue3 = UE.getEditor('address');
	ue3.setContent('');
				//实例化编辑器
	//var ue4 = UE.getEditor('attractions');
	ue4.setContent('');
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
				airport: {
					required: true,
				},
				meeting_area: {
					required: true,
					number: true,
				},
				confer_center: {
					required: true,
					number: true,
					min:1
				},
				desc: {
					required: true,
				},
				hotel_num: {
					required: true,
					number: true,
					min:1
				},
				hotel_rooms: {
					required: true,
					number: true,
					min:1
				},
				advantage: {
					required: true,
				},
				address: {
					required: true,
				},
				attractions: {
					required: true,
				},
				feature:{
					required: true,
				}
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
		    	if(!$('#destination').val()){
                       alert('请选择目的地!');
                  return false;  	}
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

