@extends('admin.layouts.master') @section('title', '添加跟团游基本信息')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/chosen/chosen.min.css')}}" />
<div class="page-content">
	@include('admin.tour.common_nav')
	<!-- basic scripts -->
	<form class="form-horizontal" role="form"
		action="{{route('admin::addTourRemark')}}"
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
		<div style="margin-bottom: 30px;">
			费用包含:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="fee_includes" name="fee_includes" type="text/plain" style="width: 846px; height: 420px;">{!!$data?$data->feeIncludes:''!!}
</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			费用不包含:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="fee_not" name="fee_not" type="text/plain"
					style="width: 846px; height: 420px;">{!!$data?$data->feeNot:''!!}
</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			预定须知:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="preferential_policy" name="preferential_policy"
					type="text/plain" style="width: 846px; height: 420px;">{!!$data?$data->preferentialPolicy:config('tour.preferentialPolicy')[0]!!}
</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			签证信息:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="cancel_policy" name="cancel_policy" type="text/plain"
					style="width: 846px; height: 420px;">{!!$data?$data->cancelPolicy:''!!}
						</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			注意事项:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="note_matter" name="note_matter" type="text/plain"
					style="width: 846px; height: 420px;">{!!$data?$data->noteMatter:''!!}
</script>
			</div>
			<!--endbianji-->
		</div>
		<div style="margin-bottom: 30px;">
			备注说明:

			<!--bianji-->
			<div style="margin-top: 15px;">
				<!-- 加载编辑器的容器 -->
				<script id="remark" name="remark" type="text/plain"
					style="width: 846px; height: 420px;">{!!$data?$data->remark:''!!}
</script>
			</div>
			<!--endbianji-->
		</div>
		<input type="hidden" name="tourId" value="{{Input::get('id')}}">
		<button class="btn btn-sm btn-success" type="submit">提交</button>
	</form>

	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>


<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/ueditor.all.min.js')}}"></script>
<script type="text/javascript" charset="utf-8"
	src="{{ asset('admin/components/utf8-php/lang/zh-cn/zh-cn.js')}}"></script>

@endsection @section('inlineScript')
<script type="text/javascript">
//实例化编辑器
var ue = UE.getEditor('fee_includes');
$('#fee_includes').focus(function() {
	//$(this).empty();
})
					//实例化编辑器
	var ue = UE.getEditor('fee_not');
	$('#fee_not').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('preferential_policy');
	$('#preferential_policy').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('cancel_policy');
	$('#cancel_policy').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('note_matter');
	$('#note_matter').focus(function() {
		//$(this).empty();
	})
						//实例化编辑器
	var ue = UE.getEditor('remark');
	$('#remark').focus(function() {
		//$(this).empty();
	})
		 
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

