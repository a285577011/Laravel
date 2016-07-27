@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/about.css')}}">
@endsection

@section('navClass', 'ow-inner-nav')

@section('content')

@include('index.misc-nav')

@section('misc-content')
@show

@endsection

@section('inner-script')
<script type="text/javascript">
$(function(){
  var curUrl = location.href;
  var miscNav = $(".other-nav ul li a");
  var len = miscNav.length;
  for (var i = 0; i < len; i++) {
    var link = miscNav.get(i);
    if (link.href && curUrl.indexOf(link.href) !== -1) {
      $(link).parent().addClass('active').siblings().removeClass('active');
      return;
    }
  }
});
</script>
@endsection