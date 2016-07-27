<footer>
  <hr>
  <div class="f1 clear">
    <div class="fLogo fl">
      <img src="{{asset('/images/logo.png')}}">
    </div>
    <div class="fTwoCode fl">
      <img src="{{asset('/images/ow-two-code.jpg')}}">
    </div>
    <div class="fContact fl">
      <p>{{trans('common.company_address')}}</p>

      <P>{{trans('common.contact_phone')}}：400-8866-879</P>

      <P>{{trans('common.email')}}：tour@orangeway.cn</P>
    </div>
    <div class="fShare fl hide">
      <i class="iconfont icon-Sina"></i>
      <i class="iconfont icon-weixin"></i>
      <i class="iconfont icon-facebook"></i>
      <i class="iconfont icon-in"></i>
    </div>
  </div>
  <div class="f2">
    <div class="abouts clear">
      <a href="{{url('about-us',null,false)}}">{{trans('index.about_us')}}</a>
      <a href="{{url('events',null,false)}}">{{trans('index.events')}}</a>
      <a href="{{url('team',null,false)}}">{{trans('index.our_team')}}</a>
      <a href="{{url('faq',null,false)}}">{{trans('index.frequently_asked_questions')}}</a>
      <a href="{{url('contact-us',null,false)}}">{{trans('index.contact_us')}}</a>
      <a href="{{url('partners',null,false)}}" class="last-abouts">{{trans('index.our_partners')}}</a>
    </div>
    <span>{{trans('common.copyright')}}</span>
  </div>
</footer>
@unless(\Auth::check())
@include('layouts.login-form')
@endunless