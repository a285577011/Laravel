<?php

/**
 * 公共配置
 */
return [
    // 用户默认头像
    'memberDefaultAvatar' => PHP_SAPI === 'cli' ? false : asset('img/tx.jpg'),
    
    // 数据库多语言类型字段值
    'dbLang' => [
        'zh_cn' => 1,
        'zh_tw' => 2,
        'en_us' => 3,
    ],
    
    // 验证码有效期(秒)
    'captchaTime' => 300,
    
    // 短信验证码有效期(秒)
    'smsCaptchaTime' => 600,
    // 短信验证码模版
    'smsCaptchaTemplate' => [
        'SubMail' => 'BxfC3'
    ],
    // 短信发送间隔(秒)
    'smsInterval' => 90,
    
    // 允许操作的授权时间(秒)
    'canDoTime' => 600,
    
    // 广告模块
    'adModule' => [
        1 => '首页'
    ],
    // 广告类型
    'adType' => [
        1 => '图片',
        2 => 'FLASH'
    ],
    // 广告位置
    'adPosition' => [
        1 => '页面顶部，菜单栏下方'
    ],
    // 性别
    'gender' => [
        1 => 'common.male',
        2 => 'common.female'
    ],
    // 验证状态
    'verifyStatus' => [
        0 => 'common.noVerified',
        1 => 'common.verified'
    ],
    // 激活状态
    'activeStatus' => [
        0 => 'common.inactive',
        1 => 'common.active'
    ],
    // 首页推荐线路数量
    'indexRecommendTourNum' => 4,
    // 首页成功案例数量
    'indexSucCaseNum' => 5,
    
    // 订单类型
    'orderType' => [
        1 => 'common.order_package_tour',
        2 => 'common.order_customization',
        3 => 'common.order_hotel',
        4 => 'common.order_flight'
    ],
    
    // 证件类型
    'credentialType' => [
        1 => 'common.id_card',
        2 => 'common.passport',
    ],
    
    'recommend_type' => [
        1 => '首页线路',
        2 => '首页案例',
        3 => '会奖目的地',
        4 => '酒店产品',
        5 => '酒店目的',
        6 => '机票产品',
        7 => '机票目的地',
        8 => '跟团游线路'
    ],
    'weeks' => [
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        0 => '星期日'
    ],
    'sex' => [
        1 => [
            'zh_cn' => '男',
            'zh_tw' => '男',
            'en_us' => 'man'
        ],
        2 => [
            'zh_cn' => '女',
            'zh_tw' => '女',
            'en_us' => 'women'
        ]
    ],
    'area_type' => [
        0 => '洲',
        1 => '区域',
        2 => '国家',
        7=>'大区',
        3 => '省/州',
        4 => '城市',
        5 => '区/县',
        6 => '乡镇',
    ],
    'smsTourTemplate' => [
        'SubMail' => 'pprtb4'
    ],
    
    //add by xiening 酒店订单模板
    'smsHotelTemplate' => [
    	'SubMail' => '7Ispz2'
    ],
    
    'currency'=>[
        1=>'CNY',
        2=>'USD',
        3=>'EUR',
    ],
    'selectAreaNum'=>19,//地区搜索插件 显示的数目
];
