<?php

namespace App\Helpers;

use PhpSms;
use \App\Helpers\Common as CommonHelper;

class Sms
{

    public static function SendSMSCode($phone, $length = 6)
    {
        $code = self::getCodeByLength($length);
        $captchaTime = config('common.smsCaptchaTime');
        // 把内容存入session
        session([
            'orangewaySMSCaptcha' => [
                'phrase' => $code,
                'expire' => \time() + $captchaTime,
                'phone' => md5($phone),
            ],
        ]);
        if(\App::environment('local')) {
            return $code;
        }
        $result = PhpSms::make()->to($phone)->template(config('common.smsCaptchaTemplate'))->data([
                'code' => $code, 'minute' => ceil($captchaTime / 60)
            ])->send();
        if (isset($result['success']) && $result['success']) {
            return true;
        }
        return false;
    }

    /**
     * 获取指定长度的随机数字字符串
     * @param int $length
     * @return string
     */
    public static function getCodeByLength($length)
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        $code = (string) mt_rand($min, $max);
        $time = floor($length / 2);
        for ($i = 0; $i < $time; $i++) {
            $code[mt_rand(0, $length - 1)] = mt_rand(0, 9);
        }
        return $code;
    }

    /**
     * 是否输入了有效验证码，验证码有效则一段时间内用户可以请求短信
     * @param obj $request
     * @return boolean
     */
    public static function checkCanDo($captcha)
    {
        if(CommonHelper::captchaValidate($captcha)) {
            CommonHelper::setCanDoSession('askSms', config('common.smsCaptchaTime'));
            return true;
        }
        return false;
    }
}
