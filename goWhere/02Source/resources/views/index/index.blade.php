@extends('layouts.master')

@section('title', trans('common.site_name'))

@section('style')
<link rel="stylesheet" href="{{asset('/css/src/place-select.css')}}">
<link rel="stylesheet" href="{{asset('/css/lib/slick.css')}}">
<link rel="stylesheet" href="{{asset('/css/src/ow-index.css')}}">
<link rel="stylesheet" href="{{asset('/areaSelect/cityquery.css')}}">
@endsection

@section('content')
<!--首页轮播大图-->
<section class="ow-slide">
    <div class="mask"></div>
    <div class="welcome"></div>
    <ul class="ow-slide-ul"></ul>
</section>
<section class="one-stop-service">
    <div class="oss-bg"></div>
    <div class="ow-index-content-warp">
        <div class="ow-index-title">
            <div class="t1 fs24 c6">
                <span>{{trans('index.one_stop_service')}}</span>
            </div>
            <div class="t2 fs14 c6">
                <span>ONE-STOP MICE SERVICE</span>
            </div>
            <div class="t3 fs12 c9">
                <span>{{trans('index.2m_input_2h_contact_48h_plan')}}</span>
            </div>
        </div>
        <div class="ossContent">
            <form class="ossForm" method="post" action="{{url('mice/addneedsall')}}">
                <div class="clear">
                    <p class="fs18 main-color">
                        <i class="mr5 iconfont icon-edit"></i>
                        <span>{{trans('index.basic_need')}}</span>
                    </p>

                    <div class="oss-group mr">
                        <span class="oss-label">{{trans('common.destination')}}:</span>
                        <input id="selectCity1" class="fs16 c3" data-state="1" placeholder="" autocomplete="off">
                        <input id="selectCity1_id" name="area" autocomplete="off" type="hidden">
                    </div>
                    <div class="oss-group">
                        <span class="oss-label">{{trans('mice.project_type')}}:</span>
                        <input class="ossSelect j-select fs16 c3" placeholder="" readonly>
                        <input class="form-hide hide" name="type">
                        <i class="iconfont icon-xiala"></i>
                        <ul class="oss-options j-options hide">
                            @foreach ($caseTypeConf as $ct => $cType)
                            @unless($ct ==1 || $ct ==2)
                            <li data-text="{{trans($cType)}}" data-val="{{$ct}}">{{trans($cType)}}</li>
                            @endunless
                            @endforeach
                        </ul>
                    </div>
                    <div class="oss-group mr">
                        <span class="oss-label">{{trans('mice.departure_date')}}:</span>
                        <input class="fs16 c3 datePick" placeholder="" name="departure_date" readonly>
                        <i class="iconfont icon-date"></i>
                    </div>
                    <div class="oss-group">
                        <span class="oss-label">{{trans('mice.travel_days')}}:</span>
                        <input class="fs16 c3" placeholder="" name="duration"
                               onkeyup="if (this.value.length == 1) {
                                           this.value = this.value.replace(/[^1-9]/g, '')
                                       } else {
                                           this.value = this.value.replace(/\D/g, '')
                                       }" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                    </div>
                    <div class="oss-group mr">
                        <span class="oss-label">{{trans('common.people_num')}}:</span>
                        <input class="ossSelect j-select fs16 c3" placeholder="" readonly>
                        <input class="form-hide hide" name="people_num">
                        <i class="iconfont icon-xiala"></i>
                        <ul class="oss-options j-options hide">
                            @foreach($peopleNumConf as $pnk => $pnd)
                            <li data-text="{{trans($pnd)}}" data-val="{{$pnk}}">{{trans($pnd)}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="oss-group">
                        <span class="oss-label">{{trans('mice.budget')}}:</span>
                        <input class="ossSelect j-select fs16 c3" placeholder="" readonly>
                        <input class="form-hide hide" name="budget">
                        <i class="iconfont icon-xiala"></i>
                        <ul class="oss-options j-options hide">
                            @foreach($budgetConf as $bgk => $bgd)
                            <li data-text="{{trans($bgd)}}" data-val="{{$bgk}}">{{trans($bgd)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt20 clear">
                    <p class="fs18 main-color">
                        <i class="mr5 iconfont icon-phone2"></i>
                        <span>{{trans('common.contact_information')}}</span>
                    </p>

                    <div class="oss-group mr">
                        <span class="oss-label">{{trans('common.contact_name')}}:</span>
                        <input class="fs16 c3" name="name">
                    </div>
                    <div class="oss-group">
                        <span class="oss-label">{{trans('common.contact_phone')}}:</span>
                        <input class="fs16 c3" name="phone">
                    </div>
                    <div class="oss-group mr">
                        <span class="oss-label">{{trans('common.email')}}:</span>
                        <input class="fs16 c3" name="email">
                    </div>
                    <div class="oss-group">
                        <span class="oss-label">{{trans('mice.qq_wechat')}}:</span>
                        <input class="fs16 c3" name="qq_wechat">
                    </div>
                </div>
                <a class="oss-btn">
                    <i class="iconfont icon-submit"></i>
                    <span>{{trans('common.submit')}}</span>
                </a>
            </form>
        </div>
    </div>
</section>
<section class="our-commitment">
    <div class="ow-index-content-warp">
        <div class="ow-index-title">
            <div class="t1 fs24 c6">
                <span>{{trans('index.our_commitment')}}</span>
            </div>
            <div class="t2 fs14 c6">
                <span>OUR COMMITMENT</span>
            </div>
        </div>
        <div class="oc-content">
            <ul class="clear">
                <li>
                    <div class="six-rect">
                        <i class="iconfont icon-zhiyou"></i>
                    </div>
                    <div class="six-rect-shadow"></div>
                    <p class="fs16 c6">{{trans('index.product_quality')}}</p>

                    <p class="mt5 fs14 c9">PRODUCT QUALITY</p>
                </li>
                <li>
                    <div class="six-rect">
                        <i class="iconfont icon-touming"></i>
                    </div>
                    <div class="six-rect-shadow"></div>
                    <p class="fs16 c6">{{trans('index.transparent_info')}}</p>

                    <p class="mt5 fs14 c9">TRANSPARENCY</p>
                </li>
                <li>
                    <div class="six-rect">
                        <i class="iconfont icon-yueding"></i>
                    </div>
                    <div class="six-rect-shadow"></div>
                    <p class="fs16 c6">{{trans('index.performance_guarantee')}}</p>

                    <p class="mt5 fs14 c9">PERFORMANCE</p>
                </li>
                <li>
                    <div class="six-rect">
                        <i class="iconfont icon-baozhang"></i>
                    </div>
                    <div class="six-rect-shadow"></div>
                    <p class="fs16 c6">{{trans('index.right_defending')}}</p>

                    <p class="mt5 fs14 c9">RIGHT-DEFENDING</p>
                </li>
                <li>
                    <div class="six-rect">
                        <i class="iconfont icon-peifu"></i>
                    </div>
                    <div class="six-rect-shadow"></div>
                    <p class="fs16 c6">{{trans('index.charge-back')}}</p>

                    <p class="mt5 fs14 c9">ADVANCE PAYMENT</p>
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="exhibition-demand hide">
    <div class="ow-index-content-warp">
        <div class="ow-index-title">
            <div class="t1 fs24 c6">
                <span>{{trans('index.reservation')}}</span>
            </div>
            <div class="t2 fs14 c6">
                <span>EXHIBITION DEMAND</span>
            </div>
        </div>
        <ul class="ed-option-item clear">
            <li class="cur" data-book="hotel">{{trans('index.hotel_reservation')}}</li>
            <li data-book="plane">{{trans('index.flight_reservation')}}</li>
        </ul>
        <div class="ed-forms">
            <form class="ow-hotel-form">
                <p class="title">{{trans('hotel.domestic_oversea_hotel')}}</p>

                <div class="clear">
                    <div class="od-group">
                        <span>{{trans('common.destination')}}</span>
                        <input class="long destination-select" data-state="1">
                    </div>
                    <div class="od-group mr">
                        <span>{{trans('hotel.check-in_date')}}</span>
                        <input id="hFrom" class="datePick">
                    </div>
                    <div class="od-group">
                        <span>{{trans('hotel.check-out_date')}}</span>
                        <input id="hTo" class="datePick">
                    </div>
                    <div class="od-group mr">
                        <span>{{trans('hotel.star_rated')}}</span>
                        <input class="odSelect j-select" readonly>
                        <input class="form-hide hide">
                        <ul class="od-options j-options hide">
                            @foreach($hotelStarConf as $starK => $starV)
                            <li data-text="{{trans($starV)}}" data-val="{{$starK}}">{{trans($starV)}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="od-group">
                        <span>{{trans('common.price')}}</span>
                        <input class="odSelect j-select" readonly>
                        <input class="form-hide hide">
                        <ul class="od-options j-options hide">
                            @foreach($hotelPriceConf as $prcK => $prcV)
                            <li data-text="{{trans($prcV)}}" data-val="{{$prcK}}">{{trans($prcV)}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="od-group">
                        <span>{{trans('common.keywords')}}</span>
                        <input class="long">
                    </div>
                </div>
                <button>{{trans('common.search')}}</button>
            </form>
            <div class="air-forms hide">
                <ul class="air-forms-ul clear">
                    <li class="cur" data-airType="oneWay">
                        <i class="iconfont wxz icon-unselected4"></i>
                        <i class="iconfont xz icon-selected4"></i>
                        <span>{{trans('flight.one_way')}}</span>
                    </li>
                    <li data-airType="roundWay">
                        <i class="iconfont wxz icon-unselected4"></i>
                        <i class="iconfont xz icon-selected4"></i>
                        <span>{{trans('flight.round_trip')}}</span>
                    </li>
                    <li data-airType="manyWay">
                        <i class="iconfont wxz icon-unselected4"></i>
                        <i class="iconfont xz icon-selected4"></i>
                        <span>{{trans('flight.multi_way')}}</span>
                    </li>
                </ul>
                <form class="ow-oneLine-air-form">
                    <div class="clear">
                        <div class="od-group mr">
                            <span>{{trans('flight.from_city')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.departure_date')}}</span>
                            <input class="datePick">
                        </div>
                        <div class="od-group mr">
                            <span>{{trans('flight.to_city')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="od-group noBack">
                            <span>{{trans('flight.back_date')}}</span>
                            <input readonly>
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.passenger')}}</span>
                            <input class="short">
                            <span class="tips mr">{{trans('flight.adult')}}（{{trans('flight.above_12_years_old')}}）</span>
                            <input class="short">
                            <span class="tips">{{trans('flight.child')}}（{{trans('flight.2-12_years_old')}}）</span>
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.fare_class')}}</span>
                            <input class="odSelect j-select long" readonly>
                            <input class="form-hide hide">
                            <ul class="od-options j-options hide">
                                @foreach($flightClassConf as $fcK => $fcV)
                                <li data-text="{{trans($fcV)}}" data-val="{{trans($fcK)}}">{{trans($fcV)}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button>{{trans('common.submit')}}</button>
                </form>
                <form class="ow-roundLine-air-form hide">
                    <div class="clear">
                        <div class="od-group mr">
                            <span>{{trans('flight.from_city')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.departure_date')}}</span>
                            <input id="roundFrom" class="datePick">
                        </div>
                        <div class="od-group mr">
                            <span>{{trans('flight.to_city')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.back_date')}}</span>
                            <input id="roundTo" class="datePick">
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.passenger')}}</span>
                            <input class="short">
                            <span class="tips mr">{{trans('flight.adult')}}（{{trans('flight.above_12_years_old')}}）</span>
                            <input class="short">
                            <span class="tips">{{trans('flight.child')}}（{{trans('flight.2-12_years_old')}}）</span>
                        </div>
                        <div class="od-group">
                            <span>{{trans('flight.fare_class')}}</span>
                            <input class="odSelect j-select long" readonly>
                            <input class="form-hide hide">
                            <ul class="od-options j-options hide">
                                @foreach($flightClassConf as $fcK => $fcV)
                                <li data-text="{{trans($fcV)}}" data-val="{{trans($fcK)}}">{{trans($fcV)}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button>{{trans('common.submit')}}</button>
                </form>
                <form class="air-more-trip-form hide">
                    <div class="more-trip-group clear">
                        <div class="part mr">
                            <span>{{trans('flight.from_where')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="part mr">
                            <span>{{trans('flight.to_where')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="part">
                            <span>{{trans('common.date')}}</span>
                            <input class="datePick">
                        </div>
                    </div>
                    <div class="more-trip-group clear">
                        <div class="part mr">
                            <span>{{trans('flight.from_where')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="part mr">
                            <span>{{trans('flight.to_where')}}</span>
                            <input class="destination-select" data-state="1">
                        </div>
                        <div class="part">
                            <span>{{trans('common.date')}}</span>
                            <input class="datePick">
                        </div>
                    </div>
                    <a class="add-more">{{trans('flight.add_more_flight')}}</a>

                    <div class="passenger">
                        <span>{{trans('flight.passenger')}}</span>
                        <input class="short">
                        <span class="tips mr">{{trans('flight.adult')}}（{{trans('flight.above_12_years_old')}}）</span>
                        <input class="short">
                        <span class="tips">{{trans('flight.child')}}（{{trans('flight.2-12_years_old')}}）</span>
                    </div>
                    <button>{{trans('common.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="classic-tour">
    <div class="ow-index-content-warp">
        <div class="ow-index-title">
            <div class="t1 fs24 c6">
                <span>{{trans('index.classic_europe_tour')}}</span>
            </div>
            <div class="t2 fs14 c6">
                <span>CLASSIC TOUR</span>
            </div>
        </div>
        <div class="ct-content">
            <ul class="clear">
                @foreach($recList as $rec)
                <li>
                    <a href="{{url($rec->url)}}">
                        <div>
                            <img src="@storageAsset($rec->image)">
                            <div>
                                <p class="fs16 c3">{{$rec->name}}</p>
                                <p class="fs14 c6">{!!nl2br($rec->desc)!!}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@if($caseList->count())
<section class="successful-case">
    <div class="ow-index-content-warp">
        <div class="ow-index-title">
            <div class="t1 fs24 c6">
                <span>{{trans('index.successful_case')}}</span>
            </div>
            <div class="t2 fs14 c6">
                <span>SUCCESSFUL CASE</span>
            </div>
        </div>
        <div class="case-slide slide">
            @foreach($caseList as $case)
            <div class="case-slide-item">
                <a href="{{url($case->url)}}">
                    <img src="@storageAsset($case->image)">
                    <div>
                        <p class="p1">{{$case->name}}</p>
                        <p class="p2">
                            {{$case->desc}}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@section('script')
<script src="{{asset('/js/lib/slick.js')}}"></script>
<script src="{{asset('/js/src/ow-index.js')}}"></script>
<script src="{{asset('/js/src/jQuery.owSlide.js')}}"></script>
<script src="@assetWithVer('/areaSelect/citylists.js',\Cache::get('Area:all_data_version'))"></script>
<script src="{{ asset('/areaSelect/querycity.js')}}"></script>
@endsection

@section('inner-script')
<script>
   $(function () {
       $(".ow-slide-ul").owSlide();
        $('#selectCity1').querycity({'inputCityIdName': 'selectCity1_id', 'data': citysFlight, 'tabs': labelFromcity, 'hotList': '', 'defaultText': "{{trans('common.ChineseOrpPinyin')}}", 'popTitleText': "{{trans('common.cityselectOS')}}", 'suggestTitleText': "{{trans('common.suggest_city_select')}}", 'nofundText': "{{trans('common.city_notfound')}}", 'pingyinOrder': "{{trans('common.pingyinOrder')}}"});
   });
</script>
@endsection