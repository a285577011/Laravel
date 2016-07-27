@extends('layouts.master')
 @section('title',trans('mice.cases_list'))
 @section('style') @parent
<link href="{{ asset('/css/src/ow-mice-case-list.css') }}" rel="stylesheet"
	type="text/css">
	<style>
	.pagination {
    float: right;
    margin-top: 30px;
    margin-bottom: 20px;
}
.pagination a, .pagination span {
    border: 1px solid #dfdfdf;
    color: #666;
    cursor: pointer;
    float: left;
    font-size: 14px;
    height: 35px;
    line-height: 33px;
    text-align: center;
    width: 35px;
}
.pagination a:hover, .pagination span:hover {
    border-color: #f58220;
    color: #f58220;
}
.pagination .current {
    border-color: #f58220;
    color: #f58220;
}
.pagination .current.prev, .pagination .current.next {
    border-color: #eee;
    color: #eee;
    cursor: not-allowed;
}
.pagination .prev, .pagination .next {
    margin: 0 10px;
    width: 70px;
}
.pagination .prev i, .pagination .next i {
    font-size: 12px;
}
	</style>
@stop
@section('navClass','ow-inner-nav')
@section('content')
<section class="ow-mice-list-bg"></section>
<section class="mice-category">
  <ul class="clear">
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>1])}}">
        <div class="bgImg sports">
          <i class="iconfont icon-sports"></i>
        </div>

        <p>{{trans('mice.tiyu_saishi')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>2])}}">
        <div class="bgImg celebration">
          <i class="iconfont icon-celebration"></i>
        </div>

        <p>{{trans('mice.qindian_nianhui')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>3])}}">
        <div class="bgImg evening">
          <i class="iconfont icon-evening"></i>
        </div>

        <p>{{trans('mice.wanhui_wanyan')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>4])}}">
        <div class="bgImg meeting">
          <i class="iconfont icon-meeting"></i>
        </div>

        <p>{{trans('mice.huiyi_guanli')}}</p>
      </a>
    </li>
    <li>
      <a href="{{url('mice/caseslist').'?'.http_build_query(['type'=>5])}}">
        <div class="bgImg travel">
          <i class="iconfont icon-travel"></i>
        </div>

        <p>{{trans('mice.jiangli_lvyou')}}</p>
      </a>
    </li>
  </ul>
</section>
<section class="case-list">
  <div class="warp clear">
    <ul class="case-list-ul">
    @if($data->count())
    @foreach ($data as $v)
    <li>
    <?php 
   // list($picName,$extension)=explode('.', $v->image);
    //$v->image=$picName.'_'.config('mice.case_thumb_size')[0].'_'.config('mice.case_thumb_size')[1].'.'.$extension;
    
    ?>
    <a class="clear" href="{{url('mice/casesdetail/'.$v->id)}}">
     <img class="fl" src="@storageAsset($v->image)">
      <div class="text fl">
            <p class="tp1">{{$v->infoData->title}}</p>
            <p class="tp2">{{trans('mice.shijian')}}：{{date('Y-m-d',$v->start_time)}}</p>
            <p class="tp2">{{trans('mice.didian')}}：{{App\Models\Area::getNameById($v->destination)}}</p>
            <p class="tp2">{{trans('mice.renshu')}}：{{$v->people_num}}人</p>
            <p class="tp2">{{trans('mice.fuwu_neirong')}}：{{$v->infoData->service_content}}</p>
            {!!$v->infoData->event_overview!!}
       </div>
       </a>
    </li>
    @endforeach
    @else
    @endif
    </ul>
        {!! with(new App\Extensions\Page\CustomPaginationLinks($data->appends(Input::get())))->render()!!}
  </div>
</section>

@endsection
