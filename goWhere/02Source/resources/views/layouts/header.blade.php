<?php
use App\Helpers\Common;
?>
<header>
    <div class="header-warp clear">
        <div class="fs12 c9 fl">
            <span>{{trans('index.hello_welcome_to_orangeway', ['username'=>\App\Helpers\Common::getLoginUserName()])}}</span>
            @if(\Auth::check())
            <a class="login-reg" href="{{url('auth/logout',null,false)}}">{{trans('index.logout')}}</a>
            @else
            <a id="goLogin" class="login-reg">{{trans('index.please_login')}}</a>
            <div class="line"></div>
            <a class="login-reg" href="{{url('auth/register',null,false)}}">{{trans('index.free_to_register')}}</a>
            @endif
        </div>
        <div class="fs12 c9 fr">
            <div class="top-bar sina">
                <a href="http://weibo.com/orangeway" target="_blank"><i class="fs16 iconfont icon-Sina"></i></a>
            </div>

            <div class="line"></div>
            <div class="top-bar weChat">
                <i class="fs16 iconfont icon-weixin"></i>

                <div class="ow-weChat top-bar-msg hide">
                    <img src="{{asset('/images/ow-weChat.png')}}">

                    <p>{{trans('index.scan_qrcode')}}</p>

                    <p>{{trans('index.follow_our_wechat')}}</p>
                </div>
            </div>

            <div class="line"></div>
            <div class="top-bar">
                <span>{{trans('index.contact_us')}}</span>
                <div class="top-contactUs top-bar-msg hide">
                    <p class="p1">
                        <i class="iconfont icon-kefu"></i>
                        <span>{{trans('index.customer_service_phone')}}</span>
                    </p>
                    <p class="p2">800-8866-879</p>
                    <p class="p1">
                        <i class="iconfont icon-qq"></i>
                        <span>{{trans('index.online_qq')}}</span>
                    </p>
                    <p class="p2 hide"></p>
                </div>
            </div>
            <div class="line"></div>
            <div class="top-bar">
                <a href="{{url('member/index',null,false)}}">{{trans('index.my_orangeway')}}</a>
            </div>
            <div class="line"></div>
                  <div class="top-bar money-type">
      <span>
              {{Common::getCurrency()}}</span>
        <ul class="sub-list">
        @foreach(config('common.currency') as $v)
        <li data-cookie="{{$v}}">{{$v}}</li>
        @endforeach
        </ul>
        </div>

            <div class="line"></div>
      <div class="top-bar lang-type">
              <span>        <?php switch (\App::getLocale()){
            case 'zh_cn':
                echo '简体中文';
                break;
            case 'zh_tw':
                echo '繁體中文';
                break;
            case 'en_us':
                echo 'English';
                break;
        }?></span>
        <ul class="sub-list">
          <li data-cookie="zh_cn">简体中文</li>
          <li data-cookie="zh_tw">繁體中文</li>
          <!-- <li data-cookie="en_us">English</li> -->
        </ul>
      
      </div>
        </div>
      </div>
</header>