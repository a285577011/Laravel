<?php
use App\Models\Area;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
?>
@extends('admin.layouts.master') @section('title', '添加跟团游基本信息')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.css')}}" />
<div class="page-content">
	@yield('updateTourNav','')
	<!-- basic scripts -->
	<form class="form-horizontal" role="form"
		action="@yield('formActionUrl',route('admin::addTour'))"
		enctype="multipart/form-data" method="post" id="recommend-form">
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
				<label style="width: 12%">线路名称:</label><input type="text"
					placeholder="线路名称" class="input-large" name="name"
					value="@yield('formName','')">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 12%">线路状态:</label> <select class="input-large" name="status">
					@foreach(config('tour.tour_status') as $k=>$v)
					<?php if($k==-2||$k==-3||$k==1){
					    continue;
					}?>
					<option value="{{$k}}"@yield('formStatus'.$k,'')>{{$v}}</option>
					@endforeach
				</select>
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 12%">价格:</label> <input type="text"
					placeholder="价格" class="input-large" name="price"
					value="@yield('formPrice','')">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 12%">儿童价格:</label> <input type="text"
					placeholder="儿童价格" class="input-large" name="child_price"
					value="@yield('formChildPrice','')">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 12%">最低成团人数:</label> <input type="text"
					placeholder="最低成团人数" class="input-large" name="lowest_people"
					value="@yield('formLowestPeople','')">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
					style="width: 12%">提前几天预订:</label> <input type="text"
					placeholder="提前几天出发" class="input-large" name="advance_day"
					value="@yield('formAdvanceDay','')">
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<!-- <label style="width: 12%">出发城市</label> <select class="chosen-select"
					id="leave_area" data-placeholder="出发城市" name="leave_area">
					<option value=""></option>
					@foreach(Area::getAllCity('zh_cn') as $k=>$v)
					<option value="{{$k}}" @yield('formLeaveArea'.$k,'')>{{$v}}</option>
					@endforeach
				</select>-->
											<label style="width: 12%">出发城市:</label>
						<div class="inline"><input type="text" class="input-large" name="leave_area" id="form-field-tags"  placeholder="" value="@yield('formLeaveArea','')"/>
				</div><a target="_blank" href="{{route('admin::areaList')}}"  style="position: absolute;line-height:30px" >
									新增
								</a>	
				<!--  <a onclick="addArea(1)" style="position: absolute;line-height:30px" href="javascript:void(0);">新增</a>-->

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
								<label style="width: 12%">目的地:</label><div class="inline">
						<input type="text" class="input-large" name="destination" id="form-field-tags2"  placeholder="" value="@yield('formDestination','')"/>
				</div><a target="_blank" href="{{route('admin::areaList')}}"  style="position: absolute;line-height:30px" >
									新增
								</a>	
				<div class="space-2"></div>
			</div>
		</div>

		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
	
								<label style="width: 12%">行程天数:</label> <input type="text"
					placeholder="几天" class="" name="days"
					value="@yield('formScheduleDays','')" style="width:103px;" @yield('formNigthsReadonly','')>-
					<input type="text"
					placeholder="几夜" class="" name="nights"
					value="@yield('formNigths','')" style="width:103px;" @yield('formNigthsReadonly','')>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label style="width: 12%">区域:</label> <select class="chosen-select input-large"
					id="area" data-placeholder="选择目的地." name="area">
					@foreach(config('tour.tour_area') as $k=>$v)
					<option value="{{$k}}"@yield('formArea'.$k,'')>{{$v}}</option>
					@endforeach
				</select>
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 12%">主题:</label> <select class="input-large"  name="theme">
					@foreach(config('tour.tour_theme') as $k=>$v)
					<option value="{{$k}}"@yield('formTheme'.$k,'')>{{$v}}</option>
					@endforeach
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label
					style="width: 12%">货币</label> <select class="input-large" id="currency" name="currency">
					@foreach(App\Models\Currency::getAll() as $k=>$v)
					<option value="{{$v->id}}" @yield('formCurrency'.$v->id,'')>{{$v->name}}</option>
					@endforeach
				</select>
				<div class="space-2"></div>
			</div>
		</div>
		<!--  		<div style="margin-bottom: 30px;">
			描述:
				
				<script id="desc" name="desc" type="text/plain"
					style="width: 846px; height: 420px;">
						@yield('formDesc','')
</script>
			</div>
		<div style="margin-bottom: 30px;">
			访问景点:
				
				<script id="visit_view" name="visit_view" type="text/plain"
					style="width: 846px; height: 420px;">
						@yield('formVisitView','')
</script>
			</div>
			-->
						<!--bianji-->
			<div style="margin-bottom: 30px;">
			行程特色:
				<!-- 加载编辑器的容器 -->
				<script id="route_feature" name="route_feature" type="text/plain"
					style="width: 846px; height: 420px;">@yield('formRouteFeature','')
</script>
			</div>
					<!--bianji-->
			<div style="margin-bottom: 30px;">
			简要行程:
				<!-- 加载编辑器的容器 -->
				<script id="simple_route" name="simple_route" type="text/plain"
					style="width: 846px; height: 420px;">@yield('formSimpleRoute','')
</script>
			</div>
		<button class="btn btn-sm btn-success" type="button" id="simpleButton">提交</button>
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




   <script src="{{ asset('admin/components/_mod/bootstrap-tag/bootstrap-tag.js')}}"></script><!-- 文本框 -->
   
   <script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.all.min.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/lang/zh-cn/zh-cn.js')}}"></script>
	<script type="text/javascript">
//实例化编辑器
var ue = UE.getEditor('simple_route');
$('#simple_route').focus(function() {
	//$(this).empty();
})
					//实例化编辑器
	var ue = UE.getEditor('route_feature');
	$('#route_feature').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('visit_view');
	$('#visit_view').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('desc');
	$('#desc').focus(function() {
		//$(this).empty();
	})

		 
		</script>
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
				$('#departure_type').change(function(){
                    var val=parseInt($(this).val());                    
                    $('.departure_type'+val).show();
                    if(val==2){
                    	$('.departure_type3').hide();
                    	$('.departure_type4').show();
                     }
                    else if(val==3){
                    $('.departure_type2').hide();
                    $('.departure_type4').hide();
                    }
                    else{
                    	$('.departure_type2').hide();
                    	$('.departure_type3').hide();
                    	$('.departure_type4').show();
                        }
					})
					if($('#departure_type').val()){
						$('.departure_type'+$('#departure_type').val()).show();
						}
				     if(parseInt($('#departure_type').val())==3){
				    	 $('.departure_type4').hide();
					     }
					//更新页面的时候用

						var tag_input = $('#form-field-tags');
				try{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: {!!json_encode(array_values(Area::getAllIdName('zh_cn')))!!}//ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
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
				var tag_input2 = $('#form-field-tags2');
				try{
					tag_input2.tag(
					  {
						placeholder:tag_input2.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: {!!json_encode(array_values(Area::getAllIdName('zh_cn')))!!}//ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
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
					tag_input2.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//autosize($('#form-field-tags'));
				}
				});
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
		jQuery.validator.addMethod("endDate",function(value, element) {
				var startDate = $('input[name="start_day"]').val();
				return this.optional(element) || new Date(startDate.replace("-", "/").replace("-", "/")) <= new Date(value.replace("-", "/").replace("-", "/"));
				},'<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">截止日期必须大于开始日期!</span></span>');
		jQuery.validator.addMethod("isAfterToday",function(value, element) {
			var curDate=new Date();
			//alert(curDate);
			//alert(Date.parse(value.replace("-", "/")));
			//alert(new Date(Date.parse(value.replace("-", "/"))));
			return this.optional(element) || curDate <= new Date(value.replace("-", "/").replace("-", "/"));
			},'<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">比今天小!</span></span>');
		jQuery.validator.addMethod("checkDestination",function(value, element) {
            var destination=[];
	    	$("#destination option:selected").each(function(){
	    		destination.push($(this).val()); //这里得到的就是
	        });
	        alert(destination.length);
			return this.optional(element) || destination.length;
			},'<span class="has-error" style="position: absolute;line-height:30px"><span style="color:#a94442;">请选择目的地!</span></span>');
		$('#recommend-form').validate({
			rules: {
				name: {
					required: true,
				},
				visit_view: {
					required: true,
				},
				desc: {
					required: true,
				},
				lowest_people: {
					required: true,
					number: true,
					min:1
				},
				advance_day: {
					required: true,
					number: true,
					min:0
				},
				days: {
					required: true,
					number: true,
					min:1
				},
				nights: {
					required: true,
					number: true,
					min:0
				},
				price: {
					required: true,
					number: true,
					min:1
				},
				child_price: {
					required: true,
					number: true,
					min:1
				},
				route_feature: {
					required: true,
				},
				simple_route: {
					required: true,
				},
				start_day: {
					required: true,
					isAfterToday:true,
				},
				end_day: {
					required: true,
					isAfterToday:true,
					endDate:true,
				},
				stock:{
					required: true,
					number: true,
					min:1
					},
				destination: {
					required: true,
				},
				 leave_area: {
						required: true,
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
				$(element).focus();
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
		    	if(!$('input[name="destination"]').val()){
	                    alert('请填写目的地!');
	 	                   return false;  	}
		    	if(!$('input[name="leave_area"]').val()){
                    alert('请填写出发城市!');
 	                   return false;  	}
                 if((parseInt($('input[name="days"]').val())-parseInt($('input[name="nights"]').val())>1)||(parseInt($('input[name="days"]').val())-parseInt($('input[name="nights"]').val())<-1)){
                	 alert('行程天数跟夜数大小要相差1!');
return false;
                     }
		    	var data=$(form).serialize();
		    	//console.log(data);
		    	//return false;
		   $.post($(form).attr("action"), data, success, "json");
	        return false;
	
	           function success(data){
			             if(data.status){
                          alert(data.info);
                          setTimeout(function(){
                        	  window.location.href=data.toUrl;
                             },150);
			             }
			             else{
			            	 alert(data.info);
  			             }     
		             }
	             return false;

	  	},
		});
		$(document).on('click', '#simpleButton', function () { 
			$(this).submit();
			});
		</script>
@endsection

