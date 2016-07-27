@extends('layouts.master')

@section('title', trans('message.error_occurs'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/about.css')}}">
@endsection

@section('content')
<section class="error-404-warp">
    <img src="{{asset('/img/404.jpg')}}">
    <p>
        @section('error-msg')
        {{isset($msg) && $msg ? $msg : (isset($exception) && $exception->getMessage() ? $exception->getMessage() : trans('message.error_occurs'))}}
        @if($errors->any())
            @foreach($errors->all() as $error)
            {{ $error }}
            @endforeach
        @endif
        @show
    </p>
<div class="error-404-btn">
    <a class="back-index" href="/">{{trans('common.back_to_home')}}</a>
    <a id="owSucReturnBtn" class="pre-page" {!!isset($url)&&$url ? ' href="'.$url.'"' : ''!!}>{{trans('common.goback')}}</a>
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