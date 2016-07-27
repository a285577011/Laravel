@extends('admin.layouts.master')
@section('title', '需求详情')
@section('content')

    <div class="tabbable">
        <div class="tab-content profile-edit-tab-content">
            <div class="tab-pane active" id="edit-basic">
                <div class="profile-user-info">
                    <div class="profile-info-row">
                        <div class="profile-info-name">ID</div>
                        <div class="profile-info-value">
                            <span>{{$need->id}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">姓名</div>

                        <div class="profile-info-value">
                            <span>{{$need->name}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">性别</div>

                        <div class="profile-info-value">
                            <span>@transLang($genderConf[$need->gender])</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">电话</div>
                        <div class="profile-info-value">
                            <span>{{$need->phone}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">邮箱</div>

                        <div class="profile-info-value">
                            <span>{{$need->email}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">联系时间</div>

                        <div class="profile-info-value">
                            <span>
                                @foreach(explode(',', $need->contact_time) as $ct)
                                @transLang($contactConf[$ct])
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">目的地</div>

                        <div class="profile-info-value">
                            <i class="fa fa-map-marker light-orange bigger-110"></i>
                            <span>{{$need->destination}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">计划出发时间</div>

                        <div class="profile-info-value">
                            <span>{{$need->departure_date}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">旅行天数</div>

                        <div class="profile-info-value">
                            <span>{{$need->duration}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">出发城市</div>

                        <div class="profile-info-value">
                            <i class="fa fa-map-marker light-orange bigger-110"></i>
                            <span>{{$need->from_city}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">主题</div>

                        <div class="profile-info-value">
                            <span>@transLang($subjectConf[$need->subject])</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">人数</div>

                        <div class="profile-info-value">
                            <span>{{$need->people}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">机票</div>

                        <div class="profile-info-value">
                            <span>@transLang($airlineConf[$need->airline])</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">酒店</div>

                        <div class="profile-info-value">
                            <span>@transLang($hotelConf[$need->hotel])</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">用餐</div>

                        <div class="profile-info-value">
                            <span>
                                @foreach(explode(',', $need->dinner) as $dn)
                                @transLang($dinnerConf[$dn])
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">服务人员</div>

                        <div class="profile-info-value">
                            <span>@transLang($attendantConf[$need->attendant])</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">签证</div>

                        <div class="profile-info-value">
                            <span>@transLang($visaConf[$need->visa])</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">特殊需求</div>

                        <div class="profile-info-value">
                            <span>{{$need->extra}}</span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">状态</div>

                        <div class="profile-info-value">
                            <span>
                                <form id="validation-form" method="post" action="{{route('admin::customNeedStatus', ['id'=>$need->id])}}">
                                    {!!csrf_field()!!}
                                    <select autocomplete="off" name="status">
                                        @foreach($statusConf as $sKey => $status)
                                        <option value="{{$sKey}}" {{$need->status==$sKey ? 'selected' : ''}} >{{trans($status)}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-xs btn-primary">修改状态</button>
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pageScript')
<!--[if lte IE 8]>
  <script src="{{asset('/admin/components/ExplorerCanvas/excanvas.js')}}"></script>
<![endif]-->
<script src="{{asset('/admin/components/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{asset('/admin/components/jquery-validation/dist/additional-methods.js')}}"></script>
<script src="{{asset('/admin/components/jquery-validation/src/localization/messages_zh.js')}}"></script>
@endsection

@section('inlineScript')
<script type="text/javascript">
jQuery(function ($) {
    jQuery.validator.addMethod("phone", function (value, element) {
        return this.optional(element) || /(^1(3[0-9]|4[57]|5[0-35-9]|7[6-8]|8[0-9])\d{8}$)|(^170[0-25]\d{7}$)/.test(value);
    }, "{{trans('validation.cnphone')}}");
    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            status: {
                required: true,
            }
        },
        messages: {
        },
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('[type="password"]')) {
                error.insertAfter(element);
            } else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else
                error.insertAfter(element);
        },
        submitHandler: function (form) {
            form.submit();
        },
        invalidHandler: function (form) {
        }
    });
});
</script>
@endsection