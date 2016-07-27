@extends('admin.layouts.master')
@section('title', '地区管理')
@section('content')
<link rel="stylesheet" href="{{asset('admin/components/chosen/chosen.css')}}" />
	<div class="page-content">
														<button class="btn btn-xs btn-success" onclick="addRecommend();">
																<span>新增</span>
															</button>
															<button class="btn btn-xs btn-danger" onclick="delsRecommend();" style="display:none;">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>
	<form action="">
			<label style="margin-left:10px;">地区名称(中文):</label>
			<input type="text" placeholder="地区名称" class="input-sm"
			name="name" value="{{Input::get('name')}}">
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
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace checkall"/>
																<span class="lbl"></span>
															</label>
														</th>
														<th>中文名</th>
														<th>英文名</th>
														<th>繁体中文名</th>
														<th>名称拼音</th>
														<th>国际机场代码</th>
														<th>经度</th>
														<th>纬度</th>
														<th>热门程度</th>
                                                        <th>类型</th>
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
															{{$v->name_zh_cn}}
														</td>
																												<td>
															{{$v->name_en_us}}
														</td>
																												<td>
															{{$v->name_zh_tw}}
														</td>
																												<td>
															{{$v->name_py}}
														</td>
																												<td>
															{{$v->name_iata}}
														</td>
																												<td>
															{{$v->longitude}}
														</td>
														<td>{{$v->latitude}}</td>
														<td >{{$v->hot}}</td>
                                                         <td >{{config('common.area_type')[$v->type]}}</td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-info" onclick="updateRecommend({{$v->id}});">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>
															<button class="btn btn-xs btn-danger" onclick="delRecommend({{$v->id}});" style="display:none;">
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
		<form class="form-horizontal" role="form" action="{{route('admin::addArea')}}" enctype="multipart/form-data" method="post" id="recommend-form" style="display:none;">
		<div style="float: left;">
		{!! csrf_field() !!}
		<div id="updateId"></div>
                                 <div class="form-group">

										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">请选择上级地区</label>

										<div class="col-sm-9">
										<select name="parent_id" class="chosen-select" id="pid">
											 <option value="0" data-path="0">根区域</option>
											 @if($treeList)
											 @foreach($treeList as $k=>$v)
                                              <option value="{{$v['id']}}" data-path="{{trim($v['path'].'-'.$v['id'],'-')}}">
                                              <?php 
                                              $pathArr=[];
                                              $string='';
                                              if($v['path'])
                                              $pathArr=explode('-', $v['path']);
                                              $size=count($pathArr);
                                              for($i=0;$i<$size;$i++){
                                              $string.='----';
                                              }
                                              ?>
                                              {{$string.$v['name_zh_cn']}}</option>
                                         @endforeach
                                         @endif
                                         </select>
											<div class="space-2"></div>
										</div>
										<input type="hidden" name="path" value="0">
									</div>
									                                 <div class="form-group">

										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">请选择地区类型</label>

										<div class="col-sm-9">
										<select name="type" class="input-large" id="type">
											 @foreach(config('common.area_type') as $k=>$v)
                                              <option value="{{$k}}">{{$v}}</option>
                                         @endforeach
                                         </select>(洲 ->区域->国家 省/州->城市 ->区/县 ->乡镇)
											<div class="space-2"></div>
										</div>
										<input type="hidden" name="path" value="0">
									</div>
                                <div class="form-group">

										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">中文名称</label>

										<div class="col-sm-9">
											<input id="searchTextField" type="text" placeholder="中文名称"  class="input-large" name="name_zh_cn">
											<div class="space-2"></div>
										</div>
									</div>
									                                <div class="form-group">

										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">英文名称</label>

										<div class="col-sm-9">
											<input type="text" placeholder="英文名称"  class="input-large" name="name_en_us">
											<div class="space-2"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">名称拼音</label>

										<div class="col-sm-9">
											<input type="text" placeholder="名称拼音"  class="input-large" name="name_py">
											<div class="space-2"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">国际机场代码</label>

										<div class="col-sm-9">
											<input type="text" placeholder="国际机场代码"  class="input-large" name="name_iata" >
											<div class="space-2"></div>
										</div>
									</div>
										<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">经度</label>

										<div class="col-sm-9">
											<input type="text" placeholder="经度"  class="input-large" name="longitude" id="longitude" readonly>
											<div class="space-2"></div>
										</div>
									</div>
																		<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">纬度</label>

										<div class="col-sm-9">
											<input id="latitude" type="text" placeholder="纬度"  class="input-large" name="latitude" readonly>
											<div class="space-2"></div>
										</div>
									</div>
										<div class="form-group">
										<label for="form-field-4" class="col-sm-3 control-label no-padding-right">热门程度</label>

										<div class="col-sm-9">
											<input type="text" placeholder="热门程度"  class="input-large" name="hot">(1以上为热门，会在前台地区列表优先出现)
											<div class="space-2"></div>
										</div>
									</div>																																				
															<button class="btn btn-sm btn-success" type="submit">
																提交
																<i class="icon-arrow-right icon-on-right bigger-110"></i>
															</button>
															</div>
																								<div style="float:right;"><h3>经纬度获取</h3>地区搜索:<input id="searchTextFields" type="text" placeholder="请输入名字搜索"  class="input-large"><div id="googleMap" style="width:500px;height:380px;"></div></div>
									</form>
									   

		<!--[if !IE]> -->
</div>
@endsection
@section('pageScript')
@parent
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('admin/components/chosen/chosen.jquery.js')}}"></script>
<script src="http://maps.google.com/maps/api/js?libraries=places&sensor=true&key=AIzaSyA-qk722H03vsGZO5nakrQlf-KCzZSQ8vE"></script>
<script>
function map(){
    var lat = 24.475316846930042,
    lng = 118.08929443359375,
    latlng = new google.maps.LatLng(lat, lng),
    image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

//zoomControl: true,
//zoomControlOptions: google.maps.ZoomControlStyle.LARGE,

var mapOptions = {
    center: new google.maps.LatLng(lat, lng),
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
    },
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.TOP_left
    }
},
map = new google.maps.Map(document.getElementById('googleMap'), mapOptions),
    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: image
    });

var input = document.getElementById('searchTextFields');
var autocomplete = new google.maps.places.Autocomplete(input, {
    types: ["geocode"]
});

autocomplete.bindTo('bounds', map);
var infowindow = new google.maps.InfoWindow();

google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
    infowindow.close();
    var place = autocomplete.getPlace();
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);
    }

    moveMarker(place.name, place.geometry.location);
    $('#latitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());
});
google.maps.event.addListener(map, 'click', function (event) {
    $('#latitude').val(event.latLng.lat());
    $('#longitude').val(event.latLng.lng());
    infowindow.close();
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                "latLng":event.latLng
            }, function (results, status) {
                console.log(results, status);
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results);
                    var lat = results[0].geometry.location.lat(),
                        lng = results[0].geometry.location.lng(),
                        placeName = results[0].address_components[0].long_name,
                        latlng = new google.maps.LatLng(lat, lng);

                    moveMarker(placeName, latlng);
                    $("#searchTextFields").val(results[0].formatted_address);
                }
            });
});

function moveMarker(placeName, latlng) {
    marker.setIcon(image);
    marker.setPosition(latlng);
    infowindow.setContent(placeName);
    //infowindow.open(map, marker);
}
}
</script>
<!-- 下拉选择 -->
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
				//chosen 搜索
				if(!ace.vars['touch']) {
	$('.chosen-select').chosen({
		allow_single_deselect:true,
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
				$('#pid').change(function(){
					_val = $('#pid option:selected').attr('data-path');
					$('input[name="path"]').val(_val);
					});
				var cnmsg = {
					required: '<span class="has-error"><span style="color:#a94442;">必填项</span></span>',
					equalTo: '<span class="has-error"><span style="color:#a94442;">请再次输入相同的值</span></span>',
					maxlength: jQuery.format('<span class="has-error"><span style="color:#a94442;">最多输入{0}个字符</span></span>'),
					minlength: jQuery.format('<span class="has-error"><span style="color:#a94442;">最少输入{0}个字符</span></span>'),
					rangelength: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入{0}到{1}个字符</span></span>'),
					range: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入{0}到{1}之间的值</span></span>'),
					max: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入小于 {0}的值</span></span>'),
					min: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入大于 {0}的值</span></span>'),
					email: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入正确的邮箱</span></span>'),
					url: jQuery.format('<span class="has-error"><span style="color:#a94442;">请输入正确的URL</span></span>'),
					number :'<span class="has-error"><span style="color:#a94442;">请输入数字</span></span>',
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
				}, '<span class="has-error"><span style="color:#a94442;">长度在{0}-{1}之间，请重新输入</span></span>');
				$('#recommend-form').validate({
					rules: {
						parent_id: {
							required: true,
							number: true,
							min:0
						},
						name_zh_cn: {
							required: true,
						},
						name_zh_tw: {
							//required: true,
						},
						name_en_us: {
							required: true,
						},
						name_py: {
							required: true,
						},
						name_iata: {
							//required: true,
						},
						longitude: {
							required: true,
							//number: true,
							//min:0
						},
						latitude: {
							required: true,
							//number: true,
							//min:0
						},
						hot: {
							required: true,
							number: true,
							min:0
						},

					},
					messages: {
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
		  		         url: "{{route('admin::delArea')}}",
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
		  		         url: "{{route('admin::delArea')}}",
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
		  		         url: "{{route('admin::getAreaById')}}",
		  		         data: {'id':id},
		  		         beforeSend : function(){
		  		    },
		  		             success: function(data){
		  			             if(data.status){
			  			             var info=data.data;
			  			             $('input[name="path"]').val(info.path);
			  			             $('#pid').val(info.parent_id);
			  			           $("#pid").trigger("chosen:updated");
			  			             $('input[name="name_zh_cn"]').val(info.name_zh_cn);
			  			            $('input[name="name_zh_tw"]').val(info.name_zh_tw);
			  			            $('input[name="name_en_us"]').val(info.name_en_us);
			  			             $('input[name="name_py"]').val(info.name_py);
			  			             $('input[name="name_iata"]').val(info.name_iata);
			  			           $('input[name="latitude"]').val(info.latitude);
			  			         $('input[name="longitude"]').val(info.longitude);
			  			           $('input[name="hot"]').val(info.hot);
			  			         $('#type').val(info.type);
			  			             var updateUrl="{{route('admin::updateArea')}}";
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
				 map();
				 location.href = "#recommend-form";
				 }
			 function addRecommend(){
				 $('#recommend-form').attr('action',"{{route('admin::addArea')}}");
				 $('#updateImage').html('');
				 $('#updateId').html('');
				 $('#recommend-form')[0].reset();
				 showForm();
				 }			 
		</script>
@endsection
