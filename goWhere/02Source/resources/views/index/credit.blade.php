@extends('index.misc')

@section('title', trans('index.tos_credit'))

@section('misc-content')
<section>
  <img class="about-banner" src="{{asset('/img/jfgz-banner.jpg')}}">
  <div class="event-title">
    <p class="p1">
      {{trans('index.tos_credit')}}
    </p>
  </div>
  <div class="integral-rule">
    <dl>
      <dt>Q: {{trans('misc.question_1')}}</dt>
      <dd>A：{!!trans('misc.answer_1')!!}</dd>
    </dl>

    <dl>
      <dt>Q：{{trans('misc.question_2')}}</dt>
      <dd>A：{!!trans('misc.answer_2')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_3')}}</dt>
      <dd>A：{!!trans('misc.answer_3')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_4')}}</dt>
      <dd>A：{!!trans('misc.answer_4')!!}</dd>
    </dl>
    <dl>
      <dt>Q：{{trans('misc.question_5')}}</dt>
      <dd>A：{!!trans('misc.answer_5')!!}</dd>


      <dd>
        <table cellpadding="0" cellspacing="1" class="jif_tab">
          <tr>
            <th>{{trans('member.member_level')}}</th>
            <th>{{trans('misc.reserve_by_phone')}}</th>
            <th>{{trans('misc.reserve_online')}}</th>
          </tr>
          <tr class="even">
            <td>{{trans('member.ordinary_member')}}</td>
            <td>1.0  </td>
            <td>1.1</td>
          </tr>
          <tr>
            <td>{{trans('member.golden_member')}}</td>
            <td>1.0 </td>
            <td>1.2</td>
          </tr>
          <tr class="even">
            <td>{{trans('member.platinum_member')}}</td>
            <td>1.0</td>
            <td>1.5</td>
          </tr>
          <tr>
            <td>{{trans('member.diamond_member')}}</td>
            <td>1.0</td>
            <td>2.0</td>
          </tr>
        </table>
      </dd>
      <!--<dd>展会：基本积分＝展会订单成交金额；</dd>
      <dd>机票：基本积分＝机票订单成交金额；</dd>
      <dd>酒店：基本积分＝酒店订单成交金额；</dd>
      <dd>行程：基本积分＝行程订单成交金额；</dd>
      <dd>评论（酒店、展会、行程）：基本积分=评论条数X100；</dd>
      <dd>上传展会图片：基本积分=图片数量X100；</dd>-->
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_6')}}</dt>
      <dd>A：{!!trans('misc.answer_6')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_7')}}</dt>
      <dd>A：{!!trans('misc.answer_7')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_8')}}</dt>
      <dd>A：{!!trans('misc.answer_8')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_9')}}</dt>
      <dd>A：{!!trans('misc.answer_9')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_10')}}</dt>
      <dd>A：{!!trans('misc.answer_10')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_11')}}</dt>
      <dd>A：{!!trans('misc.answer_11')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_12')}}</dt>
      <dd>A：{!!trans('misc.answer_12')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_13')}}</dt>
      <dd>A：{!!trans('misc.answer_13')!!}</dd>
    </dl>
    <dl>
      <dt>Q: {{trans('misc.question_14')}}</dt>
      <dd>A：{!!trans('misc.answer_14')!!}
      </dd>
    </dl>
  </div>
</section>
@endsection