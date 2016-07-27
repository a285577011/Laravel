<?php
namespace App\Http\Controllers\Auth;

use App\Extensions\Captcha\CaptchaBuilder;
use App\Extensions\Captcha\PhraseBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\Sms;
use App\Helpers\Common as CommonHelper;

class CaptchaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function captcha($tmp)
    {
        $phraseBuilder = new PhraseBuilder();
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->setMaxFrontLines(3);
        // 可以设置图片宽高及字体
        $builder->build($width = 150, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        session([
            'orangewayCaptcha' => [
                'phrase' => $phrase,
                'expire' => \time() + \Config('common.captchaTime'),
            ],
        ]);
        // 生成图片
        return response($builder->get())->header('Cache-Control', 'no-cache, must-revalidate')
                ->header('Content-Type', 'image/jpeg');
    }

    /**
     * 为指定手机号获取短信验证码
     */
    public function getSMSCode(Request $request)
    {
        if(!\Auth::check() && isset($_SERVER['HTTP_REFERER']) && \strpos($_SERVER['HTTP_REFERER'], 'auth/password')!== false) {
            $this->validate($request, [
                'phone' => 'required|string|cnphone',
            ]);
        } else {
            $this->validate($request, [
                'phone' => 'required|string|cnphone|unique:members',
            ]);
        }
        if(CommonHelper::checkCanDo('askSms') || Sms::checkCanDo($request->input('captcha', ''))) {
            return $this->getSMSCodeForPhone($request->input('phone'));
        }
        return $this->error(trans('message.need_reinput_captcha'), \URL::previous());
    }

    /**
     * 为当前用户获取短信验证码
     * @param Request $request
     * @return type
     */
    public function getMySMSCode(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|string|min:1'
        ]);
        if(!\Auth::check()) {
            return $this->error(trans('message.need_to_be_logined'));
        }
        $member = \Auth::user();
        if(is_null($member) || $request->input('user')!= md5($member->id)) {
            return $this->error(trans('message.illegal_operation'));
        }
        return $this->getSMSCodeForPhone($member->phone);
    }

    /**
     * 获取手机验证码
     * @param string $phone
     * @return type
     */
    protected function getSMSCodeForPhone($phone)
    {
        if(!$phone) {
            return $this->error(trans('message.invalid_phone_number'));
        }
        $smsInterval = config('common.smsInterval');
        $sendTime = (int) session('orangewaySMSCaptcha.expire') - config('common.smsCaptchaTime');
        $passed = time() - $sendTime;
        if ($passed < $smsInterval) {
            $left = $smsInterval - $passed;
            return $this->ajaxReturn(['smsInterval' => $left], 1, trans('message.send_sms_code_after',['time'=>$left]));
        }
        $result = Sms::SendSMSCode($phone);
        if ($result!==false) {
            return $this->ajaxReturn(['smsInterval' => $smsInterval], 0, \App::environment('local') ? $result : trans('message.send_sms_suc'));
        }
        return $this->error(trans('message.send_sms_fail'));
    }

}

