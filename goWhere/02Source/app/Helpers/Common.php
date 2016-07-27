<?php

namespace App\Helpers;

use DB;
use App;
use Illuminate\Support\Str;
use App\Models\Currency;
use Illuminate\Support\Facades\Input;

/**
 * 公共方法类
 *
 * @author jishu01
 *        
 */
class Common
{

    /**
     * 文本过滤
     *
     * @param unknown $string            
     * @param string $addslanshes            
     */
    public static function filterStr($string, $addslanshes = false)
    {
        // $string = nl2br($string);
        $string = strip_tags($string);
        $addslanshes && $string = addslashes($string);
        $string = trim($string);
        return $string;
    }

    /*
     * Method to strip tags globally.
     */

    public static function globalXssClean()
    {
        // Recursive cleaning for array [] inputs, not just strings.
        $sanitized = static::arrayStripTags(Input::get());
        Input::merge($sanitized);
    }

    public static function arrayStripTags($array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            // Don't allow tags on key either, maybe useful for dynamic forms.
            $key = strip_tags($key);

            // If the value is an array, we will just recurse back into the
            // function to keep stripping the tags out of the array,
            // otherwise we will set the stripped value.
            if (is_array($value)) {
                $result[$key] = static::arrayStripTags($value);
            } else {
                // I am using strip_tags(), you may use htmlentities(),
                // also I am doing trim() here, you may remove it, if you wish.
                $result[$key] = trim(htmlspecialchars($value));
            }
        }

        return $result;
    }

    public static function sqlDump()
    {
        DB::listen(function ($sql, $bindings, $time) {
            $i = 0;
            $rawSql = preg_replace_callback('/\?/', function ($matches) use ($bindings, &$i) {
                $item = isset($bindings[$i]) ? $bindings[$i] : $matches[0];
                $i ++;
                return gettype($item) == 'string' ? "'$item'" : $item;
            }, $sql);
            echo $rawSql, "\n<br /><br />\n";
        });
    }

    /**
     * 根据当前语言获取数据库语言字段值
     *
     * @return int
     */
    public static function getDbLangType()
    {
        $curLang = App::getLocale();
        $dbLangType = \Config('common.dbLang');
        return isset($dbLangType[$curLang]) ? $dbLangType[$curLang] : 0;
    }

    /**
     * 根据config\urlrule.php中定义的规则解析url参数
     *
     * @param string $originParam
     *            原始url参数字符串
     * @param string $definerRuleId
     *            规则标识符
     * @return array 解析后的url参数数组 [name=>value,...]
     */
    public static function parseSeoUrlParams($originParam, $definerRuleId)
    {
        $params = [];
        $rule = \Config('urlrule.' . $definerRuleId);
        if ($rule) {
            \preg_match($rule['rule'], $originParam, $matches);
            foreach ($rule['name'] as $key => $value) {
                $params[$value] = isset($matches[$key]) ? $matches[$key] : '';
            }
        }
        return $params;
    }

    /**
     * 验证图形验证码是否正确
     *
     * @param string $code            
     * @param boolean $expire 是否将验证码清除
     * @return boolean
     */
    public static function captchaValidate($code, $expire = true)
    {
        if ($code !== '' && session('orangewayCaptcha.expire') > \time() && session('orangewayCaptcha.phrase') === $code) {
            $expire ? session()->forget('orangewayCaptcha') : '';
            return true;
        }
        return false;
    }

    /**
     * 验证短信验证码是否正确
     * @param string $code 
     * @param string|false $phone 传入号码时则同时验证号码是否一致,false时仅验证短信
     * @param boolean $expire 是否将验证码清除
     * @return boolean
     */
    public static function smsCaptchaValidate($code, $phone = false, $expire = true)
    {
        if ($code !== '' && !is_null($code) && session('orangewaySMSCaptcha.expire') > \time()
            && session('orangewaySMSCaptcha.phrase') === $code
            && (!$phone || session('orangewaySMSCaptcha.phone') == md5($phone))) {
            if($expire) {
                session()->forget('orangewaySMSCaptcha');
                self::removeCanDoSession('askSms');
            }
            return true;
        }
        return false;
    }

    /**
     * 验证输入参数是否是整数数组/递归的整数数组
     *
     * @param array $value            
     * @param integer $min            
     * @param integer $max            
     * @param
     *            boolean 是否递归检查
     * @return boolean
     */
    public static function intArrayValidte($value, $min = false, $max = false, $recursive = false)
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                if (is_array($v) && $recursive) {
                    if (!self::intArrayValidte($v)) {
                        return false;
                    }
                } elseif (!is_numeric($v) || $v != intval($v)) {
                    return false;
                } elseif ($min && $v < $min || $max && $v > $max) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 获取Storage的完整路径
     *
     * @param string $dbPath
     *            数据库中保存的路径
     * @return string
     */
    public static function getStorageRealPath($dbPath)
    {
        $pathPrefix = \Storage::getDriver()->getAdapter()->getPathPrefix();
        $pathPrefix = rtrim(str_replace('\\', '/', $pathPrefix), '/');
        return $pathPrefix . '/' . $dbPath;
    }

    /**
     * 获取Storage的前端路径
     */
    public static function getStoragePath($dbPath, $driver = null)
    {
        if (Str::startsWith($dbPath, [
                '#',
                '//',
                'mailto:',
                'tel:',
                'http://',
                'https://'
            ]) || $dbPath == '') {
            return $dbPath;
        }
        $driver = $driver === null ? config('filesystems.default') : $driver;
        $prefix = config('filesystems.disks.' . $driver . '.prefix') ? : '';
        return trim($prefix, '\\/') . '/' . $dbPath;
    }

    /**
     * 获取当前货币
     */
    public static function getCurrency()
    {
        static $currency = null;
        if (!$currency) {
            $currency = isset($_COOKIE['currency']) && array_search($_COOKIE['currency'], config('common.currency')) ? $_COOKIE['currency'] : 'CNY';
        }
        return $currency;
    }

    /**
     * 获取当前货币符号
     */
    public static function getCurrencySymbol()
    {
        static $symbol = null;
        if (!$symbol) {
            switch (self::getCurrency()) {
                case 'CNY':
                    $symbol = '￥';
                    break;
                case 'USD':
                    $symbol = '$';
                    break;
                case 'EUR':
                    $symbol = '€';
                    break;
                default:
                    $symbol = '￥';
                    break;
            }
        }
        return $symbol;
    }

    /**
     * 根据当前货币汇率获取对应价格
     */
    public static function getPriceByValue($price, $saveDecimals = true)
    {
        $data = Currency::getAll();
        $value = '';
        $code = self::getCurrency();
        foreach ($data as $k => $v) {
            if ($v->code == $code) {
                $value = $v->value;
            }
        }
        if (!$value) {
            throw new \Exception('system error');
        }
        if ($saveDecimals) {
            return round($price * $value, 2);
        }
        return $price * $value;
    }

    /**
     * 获取全部GET参数 $excludeArray排除的数组key
     *
     * @param string $excludeArray            
     * @return string|mixed
     */
    public static function getAllGetParams($excludeArray = '')
    {
        $excludeArray = (array) $excludeArray;
        $get = [];
        if (Input::get()) {
            foreach (Input::get() as $k => $v) {
                if (!in_array($k, $excludeArray) && strlen($v) > 0) {
                    $get[$k] = $v;
                }
            }
        }

        return $get;
    }

    /**
     * 对邮箱*号处理
     * 
     * @param string $email            
     */
    public static function maskEmail($email)
    {
        if (strpos($email, '@') !== false) {
            $emailArr = explode('@', $email, 2);
            $count = strlen($emailArr[0]);
            switch (true) {
                case $count <= 4:
                    $emailArr[0] = substr($emailArr[0], 0, 1) . str_repeat('*', $count - 1);
                    break;
                default:
                    $emailArr[0] = substr($emailArr[0], 0, $count - 4) . str_repeat('*', 3) . substr($emailArr[0], - 1);
                    break;
            }
            $email = implode('@', $emailArr);
        }
        return $email;
    }

    /**
     * 对手机*号处理
     * 
     * @param string $password            
     */
    public static function maskPhone($phone)
    {
        if ($phone) {
            $count = strlen($phone);
            switch (true) {
                case $count == 11:
                    $phone = substr($phone, 0, 2) . str_repeat('*', 5) . substr($phone, - 4);
                    break;
                case 6 < $count && $count < 11:
                    if ($count - 5 > 3) {
                        $phone = substr($phone, 0, $count - 5 > 3 ? 2 : 1) . str_repeat('*', 5) . substr($phone, - ($count - 7));
                    } else {
                        $phone = substr($phone, 0, 1) . str_repeat('*', 5) . substr($phone, - ($count - 6));
                    }
                    break;
                default:
                    $phone = substr($phone, 0, 1) . str_repeat('*', $count - 1);
            }
        }
        return $phone;
    }

    /*
     * 获取首页显示的登录用户名称
     */

    public static function getLoginUserName()
    {
        $name = '';
        if (\Auth::check() && $user = \Auth::user()) {
            $name = $user->nickname ? : ($user->username ? : ($user->email ? : $user->phone));
        }
        return $name;
    }

    /**
     * 设置一个允许操作的session
     * @param string $action 操作名称
     * @param int $time 有效期
     */
    public static function setCanDoSession($action, $time = false)
    {
        $time = $time ? : config('common.canDoTime');
        return session()->put('canDo.' . $action, time() + $time);
    }

    /**
     * 判断session中允许操作的状态是否有效
     * @param string $action
     * @return boolean
     */
    public static function checkCanDo($action)
    {
        $canDo = (int) (session('canDo.' . $action));
        return $canDo && ($canDo >= time());
    }

    /**
     * 清除session中指定的允许操作标记
     * @param string $action
     * @return boolean
     */
    public static function removeCanDoSession($action)
    {
        return session()->forget('canDo.' . $action);
    }

    /**
     * 生成带版本号的js src
     * @param string $path
     * @param string $version
     * @param boolean $lang 是否附加语言变量，默认是
     */
    public static function assetWithVer($path, $version, $lang = true)
    {
        return asset($path)
            . (strpos($path, '?') !== false ? '&' : '?')
            . ($lang ? 'lang=' . \App::getLocale() . '&' : '')
            . ('ver=' . $version);
    }

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid Tree的根id
     * @param string $pid parent字段名
     * @return array
     */
    public static function listToTree($list, $pid = 0, $i=0, $pKey='parent_id')
    {
        // 创建Tree
        static $tree = [];
        if (is_array($list)) {
            foreach ($list as $key => $data) {
                if ($data[$pKey] == $pid) {
                    $data['tree_layer'] = $i;
                    $tree[$data['id']] = $data;
                    static::listToTree($list, $data['id'], $i+1);
                }
            }
        }
        return $tree;
    }

}
