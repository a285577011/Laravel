<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="{{asset('/admin/assets/css/bootstrap.css')}}" />
<link rel="stylesheet" href="{{asset('/admin/components/font-awesome/css/font-awesome.css')}}" />

<!-- page specific plugin styles -->

<!-- text fonts -->
<link rel="stylesheet" href="{{asset('/admin/assets/css/ace-fonts.css')}}" />

<!-- ace styles -->
<link rel="stylesheet" href="{{asset('/admin/assets/css/ace.css')}}" class="ace-main-stylesheet" id="main-ace-style" />

<!--[if lte IE 9]>
        <link rel="stylesheet" href="admin/assets/css/ace-part2.css" class="ace-main-stylesheet" />
<![endif]-->
<link rel="stylesheet" href="{{asset('/admin/assets/css/ace-skins.css')}}" />
<link rel="stylesheet" href="{{asset('/admin/assets/css/ace-rtl.css')}}" />

<!--[if lte IE 9]>
  <link rel="stylesheet" href="admin/assets/css/ace-ie.css" />
<![endif]-->

<!-- inline styles related to this page -->

<!-- ace settings handler -->
<script src="{{asset('/admin/assets/js/ace-extra.js')}}"></script>

<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

<!--[if lte IE 8]>
<script src="{{asset('/admin/components/html5shiv/dist/html5shiv.min.js')}}"></script>
<script src="{{asset('/admin/components/respond/dest/respond.min.js')}}"></script>
<![endif]-->
@section('page-style')
@show
