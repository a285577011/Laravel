<nav class="header-nav @yield('navClass')">
  <div class="header-nav-warp">
    <div class="logo fl">
        <a href="{{url('/',null,false)}}"><img src="{{asset('/images/logo.png')}}"></a>
    </div>
    @section('header-nav-content')
    <div class="nav-items fr">
      <a href="{{url('/',null,false)}}">{{trans('index.home_page')}}</a>
      <a href="{{url('mice/index',null,false)}}">{{trans('index.mice')}}</a>
<!--      <a href="{{url('hotel/index',null,false)}}">{{trans('index.hotels')}}</a>
      <a href="">{{trans('index.flights')}}</a>-->
      <a href="{{url('customization/index',null,false)}}">{{trans('index.customized_tours')}}</a>
      <a href="{{url('tour/index',null,false)}}">{{trans('index.package_tours')}}</a>
    </div>
    @show
  </div>
</nav>
