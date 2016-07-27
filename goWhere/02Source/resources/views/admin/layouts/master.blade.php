<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />

        <title>@yield('title') - {{$viewSiteTitle or '吉程管理后台'}}</title>	

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('admin.layouts.style')
    </head>

    <body class="no-skin">
        @include('admin.layouts.navbar')

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.loadState('main-container')
                } catch (e) {
                }
            </script>

            @include('admin.layouts.sidebar')

            <div class="main-content"><div class="main-content-inner">
                    @unless(isset($viewNoBreadcrumbs))
                    @include('admin.layouts.breadcrumbs')
                    @endunless

                    <div class="page-content">
                        @include('admin.layouts.settings')

                        @unless(isset($viewNoHeader))
                        <div class="page-header">
                            <h1>@yield('title') @unless(!isset($viewPageDescription) || !$viewPageDescription)<small><i class="ace-icon fa fa-angle-double-right"></i> {{$viewPageDescription}}</small>@endunless</h1>
                        </div><!-- /.page-header -->
                        @endunless
                        @include('admin.layouts.message')
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                @yield('content')
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->

                    </div><!-- /.page-content -->
                </div></div><!-- /.main-content -->

            @include('admin.layouts.footer')

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        @include('admin.layouts.scripts')
    </body>
</html>
