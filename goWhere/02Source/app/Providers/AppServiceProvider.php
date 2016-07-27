<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addValidators();
        $this->addBladeDirectives();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * 添加验证规则
     */
    protected function addValidators()
    {
        //添加验证码的验证规则
        \Validator::extend('captcha', function ($attribute, $value, $parameters) {
            return \App\Helpers\Common::captchaValidate($value);
        });
        //添加短信验证码的验证规则 sms_captcha:phone(同时验证该手机号，可选),1(清除session，可选,默认清除)
        \Validator::extend('sms_captcha', function ($attribute, $value, $parameters) {
            $param = array_merge([$value], $parameters);
            return call_user_func_array('\App\Helpers\Common::smsCaptchaValidate', $param);
        });
        // 添加数字数组的验证规则 int_array:minValue,maxValue,isRecursive
        \Validator::extend('int_array', function ($attribute, $value, $parameters) {
            $min = isset($parameters[0]) && trim($parameters[0]) !== '' ? intval($parameters[0]) : false;
            $max = isset($parameters[1]) && trim($parameters[1]) !== '' ? intval($parameters[1]) : false;
            $isRecursive = isset($parameters[2]) && $parameters[2] ? true : false;
            return \App\Helpers\Common::intArrayValidte($value, $min, $max, $isRecursive);
        });
        // 添加逗号分隔的数字字符串的验证规则 comma_int:minValue,maxValue,isRecursive
        \Validator::extend('comma_int', function ($attribute, $value, $parameters) {
            $value = explode(',', $value);
            $min = isset($parameters[0]) && trim($parameters[0]) !== '' ? intval($parameters[0]) : false;
            $max = isset($parameters[1]) && trim($parameters[1]) !== '' ? intval($parameters[1]) : false;
            $isRecursive = isset($parameters[2]) && $parameters[2] ? true : false;
            return \App\Helpers\Common::intArrayValidte($value, $min, $max, $isRecursive);
        });
        // 添加中国大陆手机号的验证规则
        \Validator::extend('cnphone', function ($attribute, $value, $parameters) {
            return preg_match('/(^1(3[0-9]|4[57]|5[0-35-9]|7[6-8]|8[0-9])\\d{8}$)|(^170[0-25]\\d{7}$)/', $value) ? true : false;
        });
        // 添加密码的验证规则
        \Validator::extend('password', function ($attribute, $value, $parameters) {
            return preg_match('/^[\^\-\[\]~`|!@#$%&*()_=+{};:\'"?\/><,.a-zA-z0-9\\\\]+$/', $value) ? true : false;
        });
    }

    /**
     * 添加视图指令
     */
    protected function addBladeDirectives()
    {
        // 添加视图指令 @storageAsset($storagePath)
        Blade::directive('storageAsset', function($expression) {
            return "<?php echo asset(\App\Helpers\Common::getStoragePath(with{$expression})); ?>";
        });
        // 添加视图指令 @assetWithVer($path, $version, $lang=true)
        // asset附加版本号
        Blade::directive('assetWithVer', function($expression) {
            return "<?php echo \App\Helpers\Common::assetWithVer{$expression}; ?>";
        });
        // 添加视图指令 @transLang($var, $fallback='') $var存在时输出本地化的$var，否则输出$fallback
        Blade::directive('transLang', function($expression) {
            $params = explode(',', $expression, 2);
            if (!isset($params[1])) {
                $params[1] = '\'\'';
            } else {
                $params[0].=')';
                $params[1] = rtrim($params[1], ')');
            }
            return "<?php echo isset{$params[0]} ? trans{$params[0]} : {$params[1]}; ?>";
        });
    }

}
