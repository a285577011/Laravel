<!-- #section:basics/sidebar -->
@section('sidebar')
<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

    @include('admin.layouts.sidebar_shortcuts')
    <ul class="nav nav-list">
        @foreach($viewMenuList as $viewMenu)
        @unless(isset($viewMenu['hide']) && $viewMenu['hide'])
        @if((!isset($viewMenu['parent']) || !$viewMenu['parent']) && $viewMenu['show'])
            @include('admin.layouts.sidebar_item',['viewMenu'=>$viewMenu])
        @endif
        @endunless
        @endforeach
    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
</div>
@show