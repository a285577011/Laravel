<!DOCTYPE html>
<html>
<head lang="zh">
  <meta charset="UTF-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  @include('layouts.style')
</head>
<body>
<!--头部-->
@section('header')
@include('layouts.header')
@show
<!--导航-->
@section('header-nav')
@include('layouts.header-nav')
@show

@yield('content')

@include('layouts.footer')
@include('layouts.script')
</body>
</html>