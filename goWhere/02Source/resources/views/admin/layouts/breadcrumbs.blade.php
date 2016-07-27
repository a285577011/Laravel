
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="ace-icon fa fa-home home-icon"></i> <a href="{{route('admin::index')}}">首页</a></li>
                @foreach($viewBreadcrumbs['links'] as $viewBreadcrumb)
                    @if(isset($viewBreadcrumb['route']) && $viewBreadcrumb['route'])
                        <li><a href="{{route($viewBreadcrumb['route'])}}">{{$viewBreadcrumb['text']}}</a></li>
                    @else
                        <li><a href="#">{{$viewBreadcrumb['text']}}</a></li>
                    @endif
                @endforeach
		<li class="active">{{$viewBreadcrumbs['title']}}</li>
	</ul><!-- /.breadcrumb -->
	@include('admin.layouts.searchbox')
</div>