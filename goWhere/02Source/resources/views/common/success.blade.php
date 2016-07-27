@extends('layouts.master')

@section('title', trans('message.operate_successfully'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/reg.css')}}">
@endsection

@section('header-nav-content')
<div class="header-reg-text">{{trans('message.operate_successfully')}}</div>
@endsection

@section('content')

<section style="padding-bottom: 70px;background-color: #f5f5f5">
  <div class="reg-wrap">
    <div class="reg-success-tip" style="margin-top: 70px">
      <i class="iconfont icon-success"></i>
      <span class="s1">{{isset($msg)&&$msg ? $msg : trans('message.operate_successfully')}}&nbsp;
          <a id="owSucReturnBtn"{!!isset($url)&&$url ? ' href="'.$url.'"' : ''!!}>{{trans('common.goback')}}</a></span>
    </div>
  </div>
</section>
@endsection

@section('inner-script')
<script type="text/javascript">
$(function(){
    var owReturnBtn = $('#owSucReturnBtn');
    owReturnBtn.on('click', function(){
        if(this.href) {
            window.location.href = this.href;
        } else {
            history.go(-1);
        }
        return false;
    });
});
</script>
@endsection