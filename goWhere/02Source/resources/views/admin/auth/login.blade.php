<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>后台用户登录 - {{$viewSiteTitle or '吉程管理后台'}}</title>

        <meta name="description" content="后台用户登录" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="{{asset('/admin/assets/css/bootstrap.css')}}" />
        <link rel="stylesheet" href="{{asset('/admin/components/font-awesome/css/font-awesome.css')}}" />

        <!-- text fonts -->
        <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-fonts.css')}}" />

        <!-- ace styles -->
        <link rel="stylesheet" href="{{asset('/admin/assets/css/ace.css')}}" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-part2.css')}}" />
        <![endif]-->
        <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-rtl.css')}}" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="{{asset('/admin/assets/css/ace-ie.css')}}" />
        <![endif]-->

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="{{asset('/admin/components/html5shiv/dist/html5shiv.min.js')}}"></script>
        <script src="{{asset('/admin/components/respond/dest/respond.min.js')}}"></script>
        <![endif]-->
    </head>

    <body class="login-layout light-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">吉程旅行网</span>
                                    <span class="grey" id="id-text2">管理后台</span>
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; Orangway.cn</h4>
                            </div>
                            <div class="space-6"></div>
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="ace-icon fa fa-coffee green"></i>
                                                请输入登录信息
                                            </h4>

                                            <div class="space-6"></div>

                                            <form class="form-horizontal" method="post" id="loginForm" action="{{route('admin::postLogin')}}">
                                                {!! csrf_field() !!}
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <label for="form-field-username">用户名</label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" id="form-field-username" class="form-control" placeholder="用户名" name="username" value="{{old('username')}}"/>
                                                                <i class="ace-icon fa fa-user"></i>
                                                            </span>

                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <label for="form-field-password">密码</label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" id="form-field-password" class="form-control" placeholder="密码" name="password"/>
                                                                <i class="ace-icon fa fa-lock"></i>
                                                            </span>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <label for="form-field-captcha">验证码</label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" maxlength="5" id="form-field-captcha" class="input-medium inline" placeholder="验证码" name="captcha"/>
                                                                <img id="captcha" style="width:100px; height: 35px;cursor: pointer;"class="pull-right" src="{{url('auth/captcha/'.mt_rand())}}" onclick="re_captcha();" />
                                                            </span>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" name="remember" value="1"/>
                                                            <span class="lbl">记住我</span>
                                                        </label>

                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">登录</span>
                                                        </button>
                                                    </div>
                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /.widget-main -->
                                        @if($errors->any())
                                        <div class="alert alert-danger clearfix">
                                            @foreach($errors->all() as $error)
                                            {{ $error }}
                                            @endforeach
                                        </div>
                                        @endif
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->

                            </div><!-- /.position-relative -->

                            <div class="navbar-fixed-top align-right">
                                <br />
                                &nbsp;
                                <a id="btn-login-dark" href="#">Dark</a>
                                &nbsp;
                                <span class="blue">/</span>
                                &nbsp;
                                <a id="btn-login-blur" href="#">Blur</a>
                                &nbsp;
                                <span class="blue">/</span>
                                &nbsp;
                                <a id="btn-login-light" href="#">Light</a>
                                &nbsp; &nbsp; &nbsp;
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="{{asset('/admin/components/jquery/dist/jquery.js')}}"></script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script src="{{asset('/admin/components/jquery.1x/dist/jquery.js')}}"></script>
        <![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='{{asset('/admin/components/_mod/jquery.mobile.custom/jquery.mobile.custom.js')}}'>" + "<" + "/script>");
        </script>

        <!--[if lte IE 8]>
        <script src="{{asset('/admin/components/ExplorerCanvas/excanvas.js')}}"></script>
        <![endif]-->
        <script src="{{asset('/admin/components/jquery-validation/dist/jquery.validate.js')}}"></script>
        <script src="{{asset('/admin/components/jquery-validation/dist/additional-methods.js')}}"></script>
        <script src="{{asset('/admin/components/jquery-validation/src/localization/messages_zh.js')}}"></script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
        jQuery(function ($) {
            $('#loginForm').validate({
                errorElement: 'span',
                errorClass: 'help-block',
                focusInvalid: false,
                ignore: "",
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    captcha: {
                        required: true
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.is('#form-field-captcha')) {
                        error.insertAfter(element.parent().parent().parent());
                    } else
                        error.insertAfter(element);
                }
            });
        });
                jQuery(function ($) {
                    $(document).on('click', '.toolbar a[data-target]', function (e) {
                        e.preventDefault();
                        var target = $(this).data('target');
                        $('.widget-box.visible').removeClass('visible');//hide others
                        $(target).addClass('visible');//show target
                    });
                });
        //you don't need this, just used for changing background
        jQuery(function ($) {
            $('#btn-login-dark').on('click', function (e) {
                $('body').attr('class', 'login-layout');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-light').on('click', function (e) {
                $('body').attr('class', 'login-layout light-login');
                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-blur').on('click', function (e) {
                $('body').attr('class', 'login-layout blur-login');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'light-blue');

                e.preventDefault();
            });

        });
        function re_captcha() {
            $url = "{{url('auth/captcha')}}";
            $url = $url + "/" + Math.random();
            document.getElementById('captcha').src = $url;
        }
        </script>
    </body>
</html>
