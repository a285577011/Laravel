<?php

namespace App\Helpers;

/**
 * Description of MailLogin
 *
 * @author wangw
 */
class Register
{
    //put your code here
    protected static $providers = [
        'sina.com.cn' => 'sina',
        'sina.com' => 'sina',
        'sina.cn' => 'sina',
        'sina.com' => 'sina',
        'qq.com' => 'qq',
        'vip.qq.com' => 'qq',
        'outlook.com' => 'outlook',
        'hotmail.com' => 'outlook',
        'live.cn' => 'outlook',
        'msn.com' => 'outlook',
        'msn.cn' => 'outlook',
        'live.com' => 'outlook',
        '163.com' => 'wy',
        '126.com' => 'wy',
        'yeah.net' => 'wy',
        'vip.163.com' => 'wy_vip',
        '188.com' => 'wy_188',
        'sohu.com' => 'sohu',
        'vip.sohu.com' => 'sohu_vip',
        'vip.tom.com' => 'tom_vip',
        '163.net' => 'tom_vip',
        'tom.com' => 'tom',
        'gmail.com' => 'google',
        'yahoo.com' => 'yahoo',
        'ymail.com' => 'yahoo',
        '21cn.com' => '21cn',
        '189.cn' => 'chinanet',
        '139.cn' => 'chinamobile',
        'wo.cn' => 'chinaunicom',
        'aliyun.com' => 'aliyun',
        'cntv.cn' => 'cntv',
        'vip.cntv.cn' => 'cntv',
        'icloud.com' => 'icloud',
        'me.com' => 'icloud',
        'mac.com' => 'icloud',
        'ymail.cn' => 'ymail',
        'aol.com' => 'aol',
        'china.com' => 'china',
    ];
    
    protected static $loginAddr = [
        'wy' => 'http://hw.mail.163.com/',
        'wy_188' => 'http://www.188.com/',
        'wy_vip' => 'http://vip.163.com/',
        'sina' => 'https://mail.sina.com.cn/',
        'sohu' => 'http://mail.sohu.com/',
        'sohu_vip' => 'http://vip.sohu.com/',
        'qq' => 'https://mail.qq.com/',
        'tom_vip' => 'http://vip.tom.com/',
        'tom' => 'http://mail.tom.com/',
        'google' => 'http://www.gmail.com/',
        'yahoo' => 'http://mail.yahoo.com/',
        'outlook' => 'https://www.outlook.com/',
        '21cn' => 'http://mail.21cn.com/',
        'chinanet' => 'http://mail.189.cn/',
        'chinamobile' => 'http://mail.10086.cn/',
        'chinaunicom' => 'http://mail.wo.cn/',
        'aliyun' => 'http://mail.aliyun.com/',
        'cntv' => 'http://mail.cntv.cn/',
        'icloud' => 'https://www.icloud.com/',
        'ymail' => 'http://www.ymail.cn/',
        'aol' => 'http://mail.aol.com/',
        'china' => 'http://mail.china.com/'
    ];

    public static function getLoginAddr($email)
    {
        $domain = ltrim(strstr($email, '@'), '@');
        return isset(self::$providers[$domain]) && isset(self::$loginAddr[self::$providers[$domain]]) ? self::$loginAddr[self::$providers[$domain]] : '';
    }
}
