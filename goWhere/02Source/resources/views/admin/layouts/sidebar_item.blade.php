@if($viewMenu['show'] && (!isset($viewMenu['hide']) || !$viewMenu['hide']))
<li class="{{isset($viewMenu['active']) && $viewMenu['active'] ? 'active' : ''}}{{isset($viewMenu['open']) && $viewMenu['open'] ? ' open' : ''}}">
    <a href="{{isset($viewMenu['route']) && $viewMenu['route'] ? route($viewMenu['route']) : '#'}}" class="{{isset($viewMenu['submenu']) && $viewMenu['submenu'] ? 'dropdown-toggle' : ''}}">
        @if(!isset($viewMenu['parent']) || !$viewMenu['parent'])
        <i class ="menu-icon fa {{$viewMenu['icon'] or ''}}"></i>
        @else
        <i class="menu-icon fa fa-caret-right"></i>
        @endif
        <span class="menu-text">{{$viewMenu['text']}}</span>
        @unless(!isset($viewMenu['submenu']) || !$viewMenu['submenu'])
        <b class="arrow fa fa-angle-down"></b>
        @endunless
    </a>
    <b class="arrow"></b>
    @if(isset($viewMenu['submenu']) && $viewMenu['submenu'])
    <ul class="submenu">
        @foreach($viewMenu['submenu'] as $viewSubMenu)
        @include('admin.layouts.sidebar_item',['viewMenu'=>$viewSubMenu])
        @endforeach
    </ul>
    @endif
</li>
@endif