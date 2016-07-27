<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta charset="utf-8">
        <title>出错了 - {{$viewSiteTitle or '吉程管理后台'}}</title>

        <meta content="@yield('statusCode') Error Page" name="description">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport">

        <!-- bootstrap & fontawesome -->
        <link href="{{asset('/admin/assets/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('/admin/components/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link href="{{asset('/admin/assets/css/ace-fonts.css')}}" rel="stylesheet">

        <!-- ace styles -->
        <link id="main-ace-style" class="ace-main-stylesheet" href="{{asset('/admin/assets/css/ace.css')}}" rel="stylesheet">

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-part2.css')}}" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-ie.css')}}" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="{{asset('/admin/assets/js/ace-extra.js')}}"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="{{asset('/admin/components/html5shiv/dist/html5shiv.min.js')}}"></script>
        <script src="{{asset('/admin/components/respond/dest/respond.min.js')}}"></script>
        <![endif]-->
    </head>

    <body class="no-skin">
        <!-- #section:basics/navbar.layout -->


        <!-- /section:basics/navbar.layout -->
        <div id="main-container" class="main-container ace-save-state">


            <!-- #section:basics/sidebar -->


            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="main-content-inner">
                    <!-- #section:basics/content.breadcrumbs -->


                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">
                        <!-- #section:settings.box -->
                        <!-- /.ace-settings-container -->

                        <!-- /section:settings.box -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <!-- #section:pages/error -->
                                <div class="error-container">
                                    <div class="well">
                                        <h1 class="grey lighter smaller">
                                            <span class="blue bigger-125">
                                                <i class="ace-icon fa fa-random"></i>
                                                {{isset($exception) && method_exists($exception, 'getStatusCode') && $exception->getStatusCode() ? $exception->getStatusCode() : ''}}
                                            </span>
                                            出错了
                                        </h1>

                                        <hr>
                                        <h3 class="lighter smaller">
                                            @section('errorMsg')
                                            {{isset($exception) && $exception->getMessage() ? $exception->getMessage() : 'But we are working on it!'}}
                                            @show
                                        </h3>
                                        <div class="space"></div>

                                        <div>
                                            <h4 class="lighter smaller"></h4>
                                            @if($errors->any())
                                            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                                    @foreach($errors->all() as $error)
                                                    <li>
                                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                                        {{$error}}
                                                    </li>
                                                    @endforeach
                                            </ul>
                                            @endif
                                        </div>

                                        <hr>
                                        <div class="space"></div>

                                        <div class="center">
                                            <a class="btn btn-grey" href="javascript:history.back()">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                返回
                                            </a>

                                            <a class="btn btn-primary" href="{{route('admin::index')}}">
                                                <i class="ace-icon fa fa-tachometer"></i>
                                                管理首页
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- /section:pages/error -->

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            @include('admin.layouts.footer')

            <a class="btn-scroll-up btn btn-sm btn-inverse" id="btn-scroll-up" href="#">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="{{asset('/admin/components/jquery/dist/jquery.js')}}"></script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script src="{{asset('/admin/components/jquery.1x/dist/jquery.js')}}"></script>
        <![endif]-->
        <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("&lt;script src='{{asset('/admin/components/_mod/jquery.mobile.custom/jquery.mobile.custom.js')}}'&gt;" + "&lt;" + "/script&gt;");
        </script>
        <script src="{{asset('/admin/components/bootstrap/dist/js/bootstrap.js')}}"></script>

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->
        <script src="{{asset('/admin/assets/js/src/ace.js')}}"></script>
        <script src="{{asset('/admin/assets/js/src/ace.basics.js')}}"></script>
        <!-- inline scripts related to this page -->
    </body></html>