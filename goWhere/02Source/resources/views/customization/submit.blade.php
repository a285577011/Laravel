@extends('layouts.master')

@section('title', trans('customization.customized_tour'))
@section('navClass', 'ow-inner-nav')

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/customize-tour.css')}}">
@endsection

@section('content')

<!--面包屑 begin -->
<section class="inner-crumbs">
    <div class="crumbs-items iBlock">
        <a class="f-crumbs" href="{{url('/',null,false)}}">{{trans('index.home_page')}}</a>
        <a href="{{url('customization/index')}}">{{trans('customization.customized_tour')}}</a>
        <a>{{trans('customization.exlusive_need_form')}}</a>
    </div>
</section>
<!--面包屑 end-->
<section class="co-detail">
    <p class="p1">{{trans('customization.need_desc_p1')}}</p>
    <p class="p1">{{trans('customization.need_desc_p2')}}</p>
    <p class="p1">{{trans('customization.need_desc_p3')}}</p>
    <form class="co-form clear" method="post">
        {!!csrf_field()!!}
        <p class="p2">
            <i class="iconfont icon-information"></i>
            <span>{{trans('common.personal_info')}}</span>
        </p>
        <div class="form-group iBlock">
            <span class="label">{{trans('common.name')}}:</span>
            <input name="name" class="need-verify" datatype="*" nullmsg="{{trans('message.fe_name_should_filled')}}" value="{{old('name')}}">
            <p class="verify-tip">{{$errors->first('name')}}</p>
        </div>
        <div class="form-group iBlock co-ml">
            <div class="iBlock radio-warp mr40{{old('gender')==1?' cur':''}}" data-val="1">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans('common.sir')}}</span>
            </div>
            <div class="iBlock radio-warp{{old('gender')==2?' cur':''}}" data-val="2">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans('common.lady')}}</span>
            </div>
            <input class="hide-input need-verify" datatype="*" nullmsg="{{trans('message.fe_gender_should_selected')}}" name="gender" autocomplete="off" value="{{old('gender')}}">
            <p class="verify-tip" style="margin-left: 0">{{$errors->first('gender')}}</p>
        </div>
        <div class="clear"></div>
        <div class="form-group iBlock clear">
            <span class="label">{{trans('common.phone')}}:</span>
            <input name="phone" value="{{old('phone')}}" class="need-verify" datatype="m" nullmsg="{{trans('message.fe_phone_should_filled')}}" errormsg="{{trans('message.fe_phone_format_error')}}">
            <p class="verify-tip">{{$errors->first('phone')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('common.email')}}:</span>
            <input name="email" value="{{old('email')}}" class="need-verify" datatype="e" nullmsg="{{trans('message.fe_email_should_filled')}}" errormsg="{{trans('message.fe_email_format_error')}}">
            <p class="verify-tip">{{$errors->first('email')}}</p>
        </div>
        <div id="contactTime" class="form-group">
            <span class="label">{{trans('customization.contact_time')}}:</span>
            @foreach($contactTimeConf as $ctK => $ctV)
            <div class="iBlock checkbox-warp minW{{strpos(','.old('contact_time').',',','.$ctK.',')!==false?' cur':''}}" data-val="{{$ctK}}">
                <span class="checkbox">
                    <i class="iconfont wxz icon-unselected2"></i>
                    <i class="iconfont xz icon-selected2"></i>
                </span>
                <span>{{trans($ctV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" nullmsg="{{trans('message.fe_contact_time_should_selected')}}" name="contact_time" value="{{old('contact_time')}}" autocomplete="off">
            <p class="verify-tip">{{$errors->first('contact_time')}}</p>
        </div>
        <div class="clear"></div>
        <p class="p2">
            <i class="iconfont icon-edit2"></i>
            <span>{{trans('customization.travel_plan')}}</span>
        </p>
        <div class="form-group iBlock">
            <span class="label">{{trans('common.destination')}}:</span>
            <input class="need-verify" value="{{old('destination')}}" datatype="*" nullmsg="{{trans('message.fe_destination_should_filled')}}" name="destination">
            <p class="verify-tip">{{$errors->first('destination')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('customization.people_num')}}:</span>
            <input class="need-verify" value="{{old('people')}}" datatype="*" nullmsg="{{trans('message.fe_people_amount_should_filled')}}" name="people"
                   onkeyup="if (this.value.length == 1) {
                               this.value = this.value.replace(/[^1-9]/g, '')
                           } else {
                               this.value = this.value.replace(/\D/g, '')
                           }" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
            <p class="verify-tip">{{$errors->first('people')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('customization.departure_date')}}:</span>
            <input class="need-verify datepicker" datatype="*" nullmsg="{{trans('message.fe_departure_should_selected')}}" readonly name="departure" value="{{old('departure')}}">
            <p class="verify-tip">{{$errors->first('departure')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('customization.tour_days')}}:</span>
            <input class="need-verify" datatype="*" nullmsg="{{trans('message.fe_duration_should_filled')}}" name="duration" value="{{old('duration')}}"
                   onkeyup="if (this.value.length == 1) {
                               this.value = this.value.replace(/[^1-9]/g, '')
                           } else {
                               this.value = this.value.replace(/\D/g, '')
                           }" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
            <p class="verify-tip">{{$errors->first('duration')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('customization.from_city')}}:</span>
            <input class="need-verify" datatype="*" nullmsg="{{trans('message.fe_from_city_should_filled')}}" name="from" value="{{old('from')}}">
            <p class="verify-tip">{{$errors->first('from')}}</p>
        </div>
        <div class="form-group iBlock">
            <span class="label">{{trans('common.budget')}}:</span>
            <input class="need-verify" datatype="*" nullmsg="{{trans('message.fe_budget_should_filled')}}" name="budget" value="{{old('budget')}}"
                   onkeyup="if (this.value.length == 1) {
                               this.value = this.value.replace(/[^1-9]/g, '')
                           } else {
                               this.value = this.value.replace(/\D/g, '')
                           }" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
            <p class="verify-tip">{{$errors->first('budget')}}</p>
        </div>
        <div class="form-group">
            <span class="label">{{trans('customization.subjects')}}:</span>
            @foreach($subjectConf as $sbK => $sbV)
            <div class="iBlock radio-warp minW{{old('subjects')==$sbK?' cur':''}}" data-val="{{$sbK}}">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans($sbV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" nullmsg="{{trans('message.fe_subject_should_selected')}}" name="subject" value="{{old('subjects')}}" autocomplete="off">
            <p class="verify-tip">{{$errors->first('subject')}}</p>
        </div>
        <div class="clear"></div>
        <p class="p2">
            <i class="iconfont icon-norm"></i>
            <span>{{trans('customization.tour_standard')}}</span>
        </p>
        <div class="form-group">
            <span class="label">{{trans('customization.air_ticket')}}:</span>
            @foreach($airLineConf as $aiK => $aiV)
            <div class="iBlock radio-warp minW{{old('airline')==$aiK?' cur':''}}" data-val="{{$aiK}}">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans($aiV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" value="{{old('airline')}}" nullmsg="{{trans('message.fe_flight_type_should_selected')}}" name="airline" autocomplete="off">
            <p class="verify-tip">{{$errors->first('airline')}}</p>
        </div>
        <div class="form-group">
            <span class="label">{{trans('customization.hotel')}}:</span>
            @foreach($hotelConf as $htK => $htV)
            <div class="iBlock radio-warp minW{{old('hotel')==$htK?' cur':''}}" data-val="{{$htK}}">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans($htV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" value="{{old('hotel')}}" nullmsg="{{trans('message.fe_hotel_type_should_selected')}}" name="hotel" autocomplete="off">
            <p class="verify-tip">{{$errors->first('hotel')}}</p>
        </div>
        <div class="clear"></div>
        <div id="repast" class="form-group">
            <span class="label">{{trans('customization.dinner')}}:</span>
            @foreach($dinnerConf as $dnK => $dnV)
            <div class="iBlock checkbox-warp minW{{strpos(','.old('dinner').',',','.$ctK.',')!==false?' cur':''}}" data-val="{{$dnK}}">
                <span class="checkbox">
                    <i class="iconfont wxz icon-unselected2"></i>
                    <i class="iconfont xz icon-selected2"></i>
                </span>
                <span>{{trans($dnV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" value="{{old('dinner')}}" nullmsg="{{trans('message.fe_dinner_type_should_selected')}}" name="dinner" autocomplete="off">
            <p class="verify-tip">{{$errors->first('dinner')}}</p>
        </div>
        <div class="clear"></div>
        <div class="form-group">
            <span class="label">{{trans('customization.attendant')}}:</span>
            @foreach($attendantConf as $atK => $atV)
            <div class="iBlock radio-warp minW{{old('attendant')==$atK?' cur':''}}" data-val="{{$atK}}">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans($atV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" value="{{old('attendant')}}" nullmsg="{{trans('message.fe_attendant_should_selected')}}" name="attendant" autocomplete="off">
            <p class="verify-tip">{{$errors->first('attendant')}}</p>
        </div>
        <div class="clear"></div>
        <div class="form-group">
            <span class="label">{{trans('customization.visa')}}:</span>
            @foreach($visaConf as $vsK => $vsV)
            <div class="iBlock radio-warp minW{{old('visa')==$vsK&&old('visa')!=''?' cur':''}}" data-val="{{$vsK}}">
                <span class="radio">
                    <i class="iconfont wxz icon-unselected3"></i>
                    <i class="iconfont xz icon-selected3"></i>
                </span>
                <span>{{trans($vsV)}}</span>
            </div>
            @endforeach
            <input class="hide-input need-verify" datatype="*" value="{{old('visa')}}" nullmsg="{{trans('message.fe_whether_visa_should_selected')}}" name="visa" autocomplete="off">
            <p class="verify-tip">{{$errors->first('visa')}}</p>
        </div>
        <div class="clear"></div>
        <div class="form-group form-area">
            <span class="label">{{trans('customization.need_note')}}:</span>
            <textarea name="extra">{{old('extra')}}</textarea>
        </div>
        <div class="clear"></div>
        <a class="customize-btn">{{trans('customization.start_cust')}}</a>
    </form>
</section>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('/js/src/customize.js')}}"></script>
@endsection

@section('inner-script')
@endsection