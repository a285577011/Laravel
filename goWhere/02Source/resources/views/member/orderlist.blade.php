@extends('layouts.master')

@section('title', $title)
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/lib/slick.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/personal.css')}}">
@endsection

@section('content')
<section class="pc-warp clear">
    @include('member.left-sidebar')
    <div class="my-order-warp">
        @section('orderSearchBar')
        <div class="my-order-search">
            <div class="all-type-order clear">
                @foreach ($orderStatusCfcConf as $orderStatusCfcK => $orderStatusCfcV)
                <a data-val="{{$orderStatusCfcK}}" {!!$condition['status_cfc']==$orderStatusCfcK?' class="cur"':''!!}>{{trans($orderStatusCfcV)}}</a>
                @endforeach
            </div>
            <div class="other-order-condition clear">
                @unless(isset($noSearchType) && $noSearchType)
                <div class="ooc-item">
                    <span class="label">{{trans('member.order_type')}}</span>
                    <select id="oocType">
                        @foreach($typeConf as $otypeK => $otypeV)
                        <option value="{{$otypeK}}" {{$condition['type']==$otypeK ? 'selected': ''}}>{{trans($otypeV)}}</option>
                        @endforeach
                    </select>
                </div>
                @endunless
                <div class="ooc-item">
                    <span class="label">{{trans('member.order_created_time')}}</span>
                    <input  class="ooc-begin" readonly placeholder="yyyy-mm-dd">
                    <span>-</span>
                    <input  class="ooc-end" readonly placeholder="yyyy-mm-dd">
                </div>
                <a class="ooc-query">{{trans('common.lookup')}}</a>
                <div class="ooc-time-range">
                    @foreach($periodSearchConf as $periodK => $periodV)
                    <a data-val="{{$periodK}}">{{trans($periodV)}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @show
        <div class="my-order-result-warp clear">
        @include('member.orderlist-table')
        </div>
        <div id="ooCondition"></div>
    </div>
</section>
<div id="test"></div>
@endsection

@section('script')
<script src="{{asset('/js/src/personal.js')}}"></script>
<script src="{{asset('/js/src/myOrder.js')}}"></script>
@endsection

@section('inner-script')
<script type="text/javascript">
    var orderSubmitUrl = '{{$submitUrl}}';
    var orderSearchCdt = {!!json_encode($condition)!!};
</script>
@endsection
