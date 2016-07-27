<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default          ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="{{route('admin::index')}}" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    吉程管理后台
                </small>
            </a>

            <!-- /section:basics/navbar.layout.brand -->

            <!-- #section:basics/navbar.toggle -->

            <!-- /section:basics/navbar.toggle -->
        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset('/admin/assets/avatars/user.png')}}" />
                        <span class="user-info">
                            <small>欢迎,</small>
                            {{\Auth::user()->name}}
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{route('admin::profile')}}">
                                <i class="ace-icon fa fa-user"></i>
                                个人设置
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{route('admin::logout')}}">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>
        
                <div class="navbar-buttons navbar-header" role="navigation" style="text-align: center;">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue dropdown-modal">
                     <select id="lang">
                        @foreach(config('app.lang')as $k=>$v)
					                        <option value="{{$v}}" @if(App::getLocale()==$v) selected @endif>
                                {{config('app.lang_cn')[$k]}}
                        </option>
                        @endforeach                       
                        </select>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>
        <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>
