@extends('admin.layouts.master') @section('title', '详细行程(线路:'.$data['name'].')')
@section('content')
<link rel="stylesheet"
	href="{{asset('admin/components/dropzone/dist/dropzone.css')}}" />
	<style></style>
<div class="page-content">
@include('admin.tour.common_nav')
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
									<th>图片</th>
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
									<td><img style="width: 150px;height:150px" src="@storageAsset($v->image)"/></td>
									<td>
										<div
											class="visible-md visible-lg hidden-sm hidden-xs btn-group">
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
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div>
									<form action="{{route('admin::addTourImage')}}" class="dropzone well" id="dropzone">
											{!! csrf_field() !!}
										<div class="fallback">
											<input name="file" type="file" multiple="" />
										</div>
										<input type="hidden" name="tourId" value="{{Input::get('id')}}">
									</form>
								</div>

								<div id="preview-template" class="hide">
									<div class="dz-preview dz-file-preview">
										<div class="dz-image">
											<img data-dz-thumbnail="" />
										</div>

										<div class="dz-details">
											<div class="dz-size">
												<span data-dz-size=""></span>
											</div>

											<div class="dz-filename">
												<span data-dz-name=""></span>
											</div>
										</div>

										<div class="dz-progress">
											<span class="dz-upload" data-dz-uploadprogress=""></span>
										</div>

										<div class="dz-error-message">
											<span data-dz-errormessage=""></span>
										</div>

										<div class="dz-success-mark">
											<span class="fa-stack fa-lg bigger-150">
												<i class="fa fa-circle fa-stack-2x white"></i>

												<i class="fa fa-check fa-stack-1x fa-inverse green"></i>
											</span>
										</div>

										<div class="dz-error-mark">
											<span class="fa-stack fa-lg bigger-150">
												<i class="fa fa-circle fa-stack-2x white"></i>

												<i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
											</span>
										</div>
									</div>
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->

	<!--[if !IE]> -->
</div>
@endsection @section('pageScript') @parent
<script src="{{ asset('admin/components/dropzone/dist/dropzone.min.js')}}"></script>
<!-- 下拉选择 -->

@endsection @section('inlineScript')
		<script type="text/javascript">
jQuery(function($){
	
	try {
	  Dropzone.autoDiscover = false;
	  var myDropzone = new Dropzone("#dropzone" , {
	    paramName: "file", // The name that will be used to transfer the file
	    maxFilesize:2, // MB
		addRemoveLinks : false,
		dictDefaultMessage :
		'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop files</span> to upload \
		<span class="smaller-80 grey">(or click)(建议大小500X300 不超过2M)</span> <br /> \
		<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>'
	,
		dictResponseError: 'Error while uploading file!',
		
		//change the previewTemplate to use Bootstrap progress bars
		previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
	  });
	  
	   $(document).one('ajaxloadstart.page', function(e) {
			try {
				myDropzone.destroy();
			} catch(e) {}
	   });
	
	} catch(e) {
	  alert('Dropzone.js does not support older browsers!');
	}
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
	});
function delRecommend(id){
    if(!confirm('确认删除？')){
        return false;
    }
		  $.ajax({
		         type: "GET",
		         url: "{{route('admin::delTourImage')}}",
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
		         url: "{{route('admin::delTourImage')}}",
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
		</script>
@endsection

