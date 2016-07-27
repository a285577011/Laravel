@extends('index.misc')

@section('title', trans('index.contact_us'))

@section('misc-content')
<section class="about-us">
  <img class="about-banner" src="{{asset('/img/contact-banner.jpg')}}">
  <div class="cu-title clear">
    <img src="{{asset('/img/contact-us.jpg')}}">
    <div class="text">
      <p class="p1">
        {{trans('misc.contact_us_desc')}}
      </p>
      <p class="p2">
        {{trans('misc.please_call_our_phone')}}<span>400-8755-800</span>
      </p>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.join_exhibition')}}</span>
    </div>
    <div class="cu-msg clear">
      <div class="cu-msg-item">
        <p class="p1">{{trans('misc.exhibition_business')}}</p>
        <p class="p2">{{trans('common.tel')}}: 0592-2950720 {{trans('common.forward')}}821</p>
        <p class="p2">{{trans('common.fax')}}: 0592-2950728</p>
        <p class="p2">{{trans('common.email')}}: fair@orangeway.cn</p>
        <p class="p2">QQ:2449320574</p>
      </div>
      <div class="cu-msg-item">
        <p class="p1">{{trans('misc.individual_reservation')}}（{{trans('misc.hotel_visa_insurance')}}）</p>
        <p class="p2">{{trans('common.tel')}}: 0592-2950720 {{trans('common.forward')}}859</p>
        <p class="p2">{{trans('common.fax')}}: 0592-2950728</p>
        <p class="p2">{{trans('common.email')}}: hotel@orangeway.cn</p>
        <p class="p2">QQ:2671064832</p>
      </div>
      <div class="cu-msg-item">
        <p class="p1">{{trans('misc.individual_reservation')}}（{{trans('misc.hotel_visa_insurance')}}）</p>
        <p class="p2">{{trans('common.tel')}}: 0592-2950720 {{trans('common.forward')}}859</p>
        <p class="p2">{{trans('common.fax')}}: 0592-2950728</p>
        <p class="p2">{{trans('common.email')}}: hotel@orangeway.cn</p>
        <p class="p2">QQ:2411627174</p>
      </div>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
      <span>{{trans('misc.other_business')}}</span>
    </div>
    <div class="cu-msg clear">
      <div class="cu-msg-item">
        <p class="p1">{{trans('misc.cooperation_propaganda')}}</p>
        <p class="p2">{{trans('common.tel')}}: 0592-2950720 {{trans('common.forward')}}821</p>
        <p class="p2">{{trans('common.fax')}}: 0592-2950728</p>
        <p class="p2">{{trans('common.email')}}: fair@orangeway.cn</p>
        <p class="p2">QQ:2602925908</p>
      </div>
      <div class="cu-msg-item">
        <p class="p1">{{trans('misc.website_cooperation')}}（{{trans('misc.links_ad_exchange_traffic')}}）</p>
        <p class="p2">{{trans('common.tel')}}: 0592-2950720 {{trans('common.forward')}}821</p>
        <p class="p2">{{trans('common.fax')}}: 0592-2950728</p>
        <p class="p2">{{trans('common.email')}}: hotel@orangeway.cn</p>
        <p class="p2">QQ:2449688409</p>
      </div>
    </div>
  </div>
  <div class="about-item">
    <div class="img-title">
    </div>
    <div class="cu-msg">
      <p class="p3">{{trans('common.address')}}：{{trans('misc.company_addr')}}</p>
      <p class="p3">{{trans('common.zip_code')}}：361008</p>
      <p class="p3">{{trans('common.email')}}：service@orangeway.cn</p>
      <p class="p3">{{trans('common.website')}}：www.orangeway.cn</p>
      <img src="{{asset('/img/contact-map.jpg')}}">
    </div>
  </div>
</section>
@endsection