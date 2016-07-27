@extends('admin.tour.addtour') 
@section('title', '更新跟团游基本信息(线路:'.$data['name'].')')
@section('updateTourNav')
@include('admin.tour.common_nav')
@endsection
@section('formActionUrl',route('admin::updateTour',['id'=>Input::get('id'),'step'=>Input::get('step')]))
@section('formName',$data['baseData']->name)
@section('formStatus'.$data['baseData']->tour_status,'selected')
@section('formPrice',$data['baseData']->price)
@section('formChildPrice',$data['baseData']->child_price)
@section('formLowestPeople',$data['baseData']->lowest_people)
@section('formAdvanceDay',$data['baseData']->advance_day)
   <?php
           if ($data['baseData']->destination) {
            $newArr = [];
            $array = explode(',', $data['baseData']->destination);
            foreach ($array as $v) {
                $newArr[] = App\Models\Area::getNameById($v);
            }
            $data['baseData']->destination = implode(',', $newArr);
        }
        ?>
           <?php
           if ($data['baseData']->leave_area) {
            $newArr = [];
            $array = explode(',', $data['baseData']->leave_area);
            foreach ($array as $v) {
                $newArr[] = App\Models\Area::getNameById($v);
            }
            $data['baseData']->leave_area = implode(',', $newArr);
        }
        ?>
@section('formDestination',$data['baseData']->destination)
@section('formLeaveArea',$data['baseData']->leave_area)
@section('formDepartureType'.$data['baseData']->departure_type,'selected')
@if($data['baseData']->departure_type==2)
@foreach(explode(',',$data['baseData']->departure_day) as $k=>$v)
@section('formOutdateStr'.$v,'checked')
@endforeach
@else
@section('formDepartureDay',$data['baseData']->departure_day)
@endif
@if($data['baseData']->start_day)
@section('formStartDay',date('Y-m-d',$data['baseData']->start_day))
@endif
@if($data['baseData']->end_day)
@section('formEndDay',date('Y-m-d',$data['baseData']->end_day))
@endif
@section('formCurrency'.$data['baseData']->currency,'selected')
@section('formType'.$data['baseData']->type,'selected')
@section('formArea'.$data['baseData']->area,'selected')
@section('formTheme'.$data['baseData']->theme,'selected')
@section('formScheduleDays',$data['baseData']->days)
@section('formNigths',$data['baseData']->nights)
@section('formStock',$data['baseData']->stock)
@section('formStockReadonly','readonly')
@section('formNigthsReadonly','readonly')
@section('formDesc',$data['infoData']->desc)
@section('formVisitView',$data['infoData']->visit_view)
@section('formRouteFeature',$data['infoData']->route_feature)
@section('formSimpleRoute',$data['infoData']->simple_route)

