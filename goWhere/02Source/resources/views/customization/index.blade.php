@extends('layouts.master')

@section('title', trans('common.site_name'))

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/place-select.css')}}">
<link rel="stylesheet" href="{{asset('/css/lib/slick.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/ow-index.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/customize-tour.css')}}">
@endsection

@section('content')
<section class="customize-top-bg" style="background-image: url('../images/customizebanner.png')">
    <a class="customize-btn" href="{{url('customization/submit')}}">{{trans('customization.start_cust')}}</a>
</section>
<section class="customize-type clear">
    <div class="fl">
        <div class="customize-type-item private-customize">
            <img src="{{asset('/images/srdz.png')}}">
            <p class="pt">{{trans('customization.exclusive_cust')}}</p>
            <div class="text">
                <i class="front-quote iconfont icon-quotes3"></i>
                <p>
                    {{trans('customization.exclusive_desc')}}
                    <i class="iconfont"></i>
                </p>
            </div>
        </div>
        <div class="customize-type-item business-customize">
            <img src="{{asset('/images/swdz.png')}}">
            <p class="pt">{{trans('customization.business_cust')}}</p>
            <div class="text">
                <i class="front-quote iconfont icon-quotes3"></i>
                <p>
                    {{trans('customization.business_desc')}}
                    <i class="iconfont"></i>
                </p>
            </div>
        </div>
    </div>
    <div class="fr">
        <div class="customize-type-item2">
            <img src="{{asset('/images/jzty.png')}}">
            <div class="text">
                <i class="front-quote iconfont icon-quotes3"></i>
                <p>
                    {{trans('customization.ad_desc')}}
                    <i class="iconfont"></i>
                </p>
            </div>
        </div>
    </div>
</section>

@include('customization.case')

<section class="customise-module tp-module" style="background-image: url('../images/tp-banner.png')">
    <div class="cm-zzc"></div>
    <div class="cm-title">
        <p class="p1">TRAVEL PLANNER</p>
        <div class="cm-line"></div>
        <p class="p2">{{trans('customization.tour_planner')}}</p>
    </div>
    <div class="tp-text">
        {!!trans('customization.tour_planner_desc')!!}
    </div>
    <div class="tp-list clear">
        @foreach($planners as $planner)
        <div class="tp-item">
            <div class="tp-img">
                <img src="@storageAsset($planner->avatar)">
            </div>
            <div class="tp-item-text">
                <p class="p1">{{$planner->name}}</p>
                <p class="p2">{{$planner->desc}}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="ow-customize clear">
    <div class="owc">
        {{trans('customization.orangeway_cust')}}
    </div>
    <div class="owc-step">
        <div class="owc-step-item">
            <img src="{{asset('/images/owc1.jpg')}}">
            <p class="p1">{{trans('customization.fill_the_form')}}</p>
            <p class="p2">{{trans('customization.fill_the_form_desc')}}</p>
        </div>
        <div class="owc-step-item">
            <img src="{{asset('/images/owc2.jpg')}}">
            <p class="p1">{{trans('customization.tour_design')}}</p>
            <p class="p2">{{trans('customization.tour_design_desc')}}</p>
        </div>
        <div class="owc-step-item">
            <img src="{{asset('/images/owc3.jpg')}}">
            <p class="p1">{{trans('customization.sign_pay')}}</p>
            <p class="p2">{{trans('customization.sign_pay_desc')}}</p>
        </div>
    </div>
    <div class="go-owc">
        <a href="{{url('customization/submit')}}">{{trans('customization.start_cust_journey')}}</a>
        <p>{{trans('customization.reserve_inquiry')}}:400-8755-800</p>
    </div>
</section>
@endsection

@section('script')
<script src="{{asset('/js/src/destinationSelect.js')}}"></script>
@endsection

@section('inner-script')

@endsection