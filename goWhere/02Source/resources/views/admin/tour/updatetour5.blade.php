<?php
use App\Helpers\Calendar;
?>
@extends('admin.layouts.master') @section('title', '详细行程(线路:'.$data['name'].')')
@section('content')
<div class="page-content">
@include('admin.tour.common_nav')
	<button class="btn btn-xs btn-success" onclick="add();">
		<span>新增</span>
	</button>
	<button class="btn btn-xs btn-danger" onclick="dels();">
		<i class="ace-icon fa fa-trash-o bigger-120"></i>
	</button>
	</br>
<?php
$priceData=[];
//print_r($data['list']);die;
$startTime=$endTime='';
if($data['list']->count()){
    foreach ($data['list'] as $v){
        $priceData[$v->price_date]=['stock'=>$v->stock,'adult_price'=>$v->adult_price,'child_price'=>$v->child_price,'id'=>$v->id];
    }
}
if($data['selectMonth']){
    echo '<select class="input-large" id="chooseTime" name="chooseTime">';
    foreach ($data['selectMonth'] as $v){
        if(Input::get('calendarTime')==$v){
            echo "<option value='{$v}' selected>{$v}</option>";
        }
        else{
        echo "<option value='{$v}' @if(Input::get(''))>{$v}</option>";
        }
    }
            echo '</select>';
}
?>
	<form class="form-horizontal" role="form" action="{{route('admin::updatePriceDate')}}" enctype="multipart/form-data"
		method="post" id="updatePriceTable">
		{!! csrf_field() !!}
<?php
$calc=new Calendar($priceData,isset($data['selectMonth'][0])?$data['selectMonth'][0]:''); 
$calc->showCalendar();
//echo $calc->rili(time());
?>
<button class="btn btn-sm btn-success" type="submit">保存修改</button>
</form>
	<!-- /.main-content -->
	
	<div class="hr hr-24"></div>
	<!-- basic scripts -->
		<!-- basic scripts -->
	<form class="form-horizontal" role="form" action="{{route('admin::addPriceDate')}}" enctype="multipart/form-data"
		method="post" id="addPrice" style="display: none;">
			<h4>已经添加过的日期不会覆盖</h4>
			</br>
		{!! csrf_field() !!}
				<div class="form-group" style="width: 45%;float:left;margin-left:100px">


				<label style="width: 25%;">指定日期:</label> <select class="input-large"
					id="departure_type" name="departure_type">
					@foreach(config('tour.departure_type') as $k=>$v)
					<option value="{{$k}}"@yield('formDepartureType'.$k,'')>{{$v}}</option>
					@endforeach
				</select>
				</div>
				<div class="form-group" style="width: 45%;float:left;">
				<label style="width: 25%;">票数:</label> 
				<input type="text" placeholder="票数" class="input-large" name="stock"value="">
				<div class="space-2"></div>
		</div>
		<div class="form-group departure_type2" style="display: none;">


			<div class="col-sm-11" style="text-align: center">
				<label style="width: 25%">请选择星期:</label>
				@foreach(config('common.weeks') as $k=>$v) <input
					name="outdate_str[]" class="ace ace-checkbox-2 outdate_str"
					type="checkbox" value="{{$k}}" @yield('formOutdateStr'.$k,'')/> <span
					class="lbl">{{$v}}</span> @endforeach
				<div class="space-2"></div>
			</div>
		</div>
		<div class="form-group departure_type3" style="display: none;"
			style="margin-bottom: 30px;">


			<label style="text-align: right; margin-right: 53px; width: 16.5%;">出发日期:</label><div class="inline"><input type="text" class="input-large" name="departure_day" id="form-field-tags" value="@yield('formDepartureDay','')" placeholder="格式如2011-02-02" />
		</div>
		</div>
		<div class="form-group departure_type4" style="width: 45%;float:left;margin-left:100px">


				<label style="width: 25%">出发日期起始时间:</label>

				<!-- #section:plugins/date-time.datepicker -->

				<input class="date-picker input-large time" type="text"
					name="start_day" value="@yield('formStartDay','')" />

				</div>
				<div class="form-group departure_type4" style="width: 45%;float:left;">
				<label style="width: 25%">出发日期截止时间:</label>

				<!-- #section:plugins/date-time.datepicker -->

				<input class="date-picker input-large time" type="text" name="end_day"
					value="@yield('formEndDay','')" />

				<div class="space-2"></div>
			</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">



				<label style="width: 25%">价格:</label>
				<input type="text" placeholder="价格" id="price" class="input-large" name="price">
		</div>
			<div class="form-group" style="width: 45%;float:left;">
					<label style="width: 25%">儿童价格</label> 
					 <input type="text"
					placeholder="儿童价格" class="input-large" name="child_price"
					value="@yield('formChildPrice','')">
				<div class="space-2"></div>
		</div>

	<input type="hidden" name="tourId" value="{{Input::get('id')}}">
		<button class="btn btn-sm btn-success" type="submit">提交</button>
	</form>
	<form class="form-horizontal" role="form" action="{{route('admin::updatePriceDate')}}" enctype="multipart/form-data"
		method="post" id="updatePrice" style="display: none;">
		{!! csrf_field() !!}
		<div id="updateId"></div>
				<div class="form-group" style="width: 45%;float:left;margin-left:100px">


				<label style="width: 25%;">日期:</label> 
				<input class="date-picker input-large" type="text" name="price_date" value="" readonly/>
				</div>
				<div class="form-group" style="width: 45%;float:left;">
				<label style="width: 25%;">票数:</label> 
				<input type="text" placeholder="票数" class="input-large" name="stock"value="">
				<div class="space-2"></div>
		</div>
		<div class="form-group" style="width: 45%;float:left;margin-left:100px">



				<label style="width: 25%">价格:</label>
				<input type="text" placeholder="价格" id="price" class="input-large" name="price">
		</div>
			<div class="form-group" style="width: 45%;float:left;">
					<label style="width: 25%">儿童价格</label> 
					 <input type="text"
					placeholder="儿童价格" class="input-large" name="child_price"
					value="@yield('formChildPrice','')">
				<div class="space-2"></div>
		</div>

	<input type="hidden" name="tourId" value="{{Input::get('id')}}">
		<button class="btn btn-sm btn-success" type="submit">提交</button>
	</form>
	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
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
@endsection @section('inlineScript')
		<script type="text/javascript">
jQuery(function($){
	//时间
    $('.time').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    $('#chooseTime').on('change',function(){
        var time = $(this).val();
    	var url=document.location.href;
    	var icon=url.indexOf("calendarTime");
    	var fuhao=url.indexOf("?");
    	if(icon==-1)
    	{
    		if(fuhao==-1)
    		{
    			url=url+'?calendarTime='+time;
    		}
    		else
    		{
    			url=url+'&calendarTime='+time;
    		}
    	}
    	else
    	{
    		var number='';
    		var start=url.indexOf("calendarTime=");
    		var end=url.indexOf("&",start);
    		if(end==-1)
    		{
    			oldTime=url.substring(Number(start)+13);
    		}
    		else
    		{
    			oldTime=url.substr(Number(start)+13,end);
    		}
    		url=url.replace("calendarTime="+oldTime,"calendarTime="+time);
    	}
        
        window.location.href=url; 
        });
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
				source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
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
	});
function delRecommend(id){
    if(!confirm('确认删除？')){
        return false;
    }
		  $.ajax({
		         type: "GET",
		         url: "{{route('admin::delPriceDate')}}",
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
		         url: "{{route('admin::delPriceDate')}}",
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
 function add(){
	 $('#addPrice').show();
	 $('#updatePrice').hide();
	// $('#updateImage').html('');
	 //$('#updateId').html('');
	 $('#addPrice')[0].reset();
	 location.href = "#addPrice";
	// ue.setContent('');
	 //showForm();
	 }
 function update(id){
		  $.ajax({
		         type: "GET",
		         url: "{{route('admin::getPriceDateById')}}?id="+id,
		         data: {},
		         beforeSend : function(){
		    },
		             success: function(data){
			             if(data.status){
				             $('#updatePrice').show();
				             $('#addPrice').hide();
				             location.href = "#updatePrice";
 			             $('input[name="price_date"]').val(data.data.price_date);
 			           $('input[name="stock"]').val(data.data.stock);
 			          $('input[name="price"]').val(data.data.adult_price);
 			          $('input[name="child_price"]').val(data.data.child_price);
			             var idInput='<input type="hidden" value='+id+' name="id">';
  			             $('#updateId').html(idInput);
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
		$('#addPrice').validate({
			rules: {
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
		    	var departureType=parseInt($('#departure_type').val());
		    	if(departureType==2){
			    	var outdateStr=[];
		            $(".outdate_str").each(function() {  
		                if ($(this).is(':checked')) {  
		                    outdateStr.push($(this).val());  
		                }  
		            });
			    	if(!outdateStr.length){
	                    alert('请选择指定的星期!');
	                   return false;  	
	                }  
			    	}
		    	if(departureType==3){
                       if(!$('input[name="departure_day"]').val()){
   	                    alert('请填写指定日期!');
 	                   return false;  	
                           }
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
	             return false;

	  	},
		});
		$('#updatePrice').validate({
			rules: {
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
				stock:{
					required: true,
					number: true,
					min:1
					}
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
	             return false;

	  	},
		});

		</script>
@endsection

