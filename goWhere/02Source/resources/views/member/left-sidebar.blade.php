<!-- 个人中心 左导航 begin -->
@section('member.left-sidebar')
<div class="pc-nav">
    <div class="pc-nav-item cur">
        <a href="{{url('member/index')}}">
            {{trans('index.my_orangeway')}}
        </a>
    </div>
    <div class="pc-nav-item">
        <a>
            {{trans('member.my_orders')}}
            <i class="iconfont icon-down2"></i>
        </a>
        <ul class="pc-sub-nav hide">
            <li>
                <a href="{{url('member/order')}}">{{trans('member.all_orders')}}</a>
            </li>
<!--            <li>
                <a href="{{url('member/order/flight')}}">{{trans('member.flight_orders')}}</a>
            </li>
            <li>
                <a href="{{url('member/order/hotel')}}">{{trans('member.hotel_orders')}}</a>
            </li>-->
            <li>
                <a href="{{url('member/order/tour')}}">{{trans('member.tour_orders')}}</a>
            </li>
<!--            <li>
                <a href="{{url('member/order/customization')}}">{{trans('member.cust_orders')}}</a>
            </li>-->
        </ul>
    </div>
    <div class="pc-nav-item no-bottom">
        <a href="{{url('member/account')}}">{{trans('member.account_setting')}}</a>
    </div>
</div>
<!-- 个人中心 左导航 end -->
@show