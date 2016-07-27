<?php
return [
    
    /*
     * |--------------------------------------------------------------------------
     * | View Storage Paths
     * |--------------------------------------------------------------------------
     * |
     * | Most templating systems load templates from disk. Here you may specify
     * | an array of paths that should be checked for your views. Of course
     * | the usual Laravel view path has already been registered for you.
     * |
     */
    'page' => 10,
    'calendar_redis_key' => 'Tour:calendar_data_',
    'calendar_redis_field_key_price' => 'price_',
    'calendar_redis_field_key_child_price' => 'child_price_',
    'calendar_redis_field_key_total' => 'total_',
    'tour_status' => [
        - 1 => '未审核',
        1 => '正常',
        - 2 => '过期',
        - 3 => '删除'
    ],
    'tour_type' => [
        1 => '自由行',
        2 => '深度策划',
        3 => '尊贵定制',
        4 => '商务考察',
        5 => '参团游',
        6 => '万人法国游',
        7 => '跟团游'
    ],
    'departure_type' => [
        1 => '天天团发',
        2 => '指定星期',
        3 => '自定义'
    ],
    'tour_area' => [
        1 => '美加',
        2 => '美西',
        3 => '美东',
        4 => '中欧',
        5 => '西欧',
        6 => '东欧',
        7 => '南欧',
        8 => '北欧',
        9 => '港澳',
        10 => '东南亚',
        11 => '澳大利亚',
        12 => '中东',
        13 => '非洲',
        14 => '南美',
        15 => '特色海岛',
        16 => '日韩',
        17 => '台湾',
        18 => '新西兰'
    ],
    'tour_theme' => [
        1 => '蜜月游',
        2 => '深度游',
        3 => '健康之旅',
        4 => '深度策划',
        5 => '夏令营',
        6 => '亲子游',
        7 => '欧洲参团游经典路线',
        8 => '欧洲大巴游特色线路'
    ],
    'tour_step' => [
        1 => '基本信息',
        2 => '详细行程',
        3 => '备注说明',
        4 => '线路图片',
        5 => '线路价格日期'
    ],
    'transport_zh_cn' => [
        1 => '巴士',
        2 => '飞机',
        3 => '汽车',
        4 => '邮轮',
        5 => '火车'
    ],
    'transport_zh_tw' => [
        1 => '巴士',
        2 => '飛機',
        3 => '汽車',
        4 => '郵輪',
        5 => '火車'
    ],
    'transport_en_us' => [
        1 => 'bus',
        2 => 'aircraft',
        3 => 'Cars',
        4 => 'cruise',
        5 => 'train'
    ],
    'media_type' => [
        1 => '图片',
        2 => '视频'
    ],
    'schedule_days_zh_cn' => [
        1 => '1天',
        2 => '2天',
        3 => '3天',
        4 => '4天',
        5 => '5天',
        6 => '6天',
        7 => '7天',
        8 => '8天',
        9 => '9天',
        10 => '10天',
        11 => '11天',
        12 => '12天',
        13 => '13天',
        14 => '14天',
        15 => '15天以上'
    ],
    'schedule_days_zh_tw' => [
        1 => '1天',
        2 => '2天',
        3 => '3天',
        4 => '4天',
        5 => '5天',
        6 => '6天',
        7 => '7天',
        8 => '8天',
        9 => '9天',
        10 => '10天',
        11 => '11天',
        12 => '12天',
        13 => '13天',
        14 => '14天',
        15 => '15天以上'
    ],
    'schedule_days_en_us' => [
        1 => '1day',
        2 => '2days',
        3 => '3days',
        4 => '4days',
        5 => '5days',
        6 => '6days',
        7 => '7days',
        8 => '8days',
        9 => '9days',
        10 => '10days',
        11 => '11days',
        12 => '12days',
        13 => '13days',
        14 => '14days',
        15 => 'More than 15 days'
    ],
    'week_zh_cn' => [
        1 => '周一',
        2 => '周二',
        3 => '周三',
        4 => '周四',
        5 => '周五',
        6 => '周六',
        0 => '周日'
    ],
    'week zh_tw' => [
        1 => '週一',
        2 => '週二',
        3 => '週三',
        4 => '週四',
        5 => '週五',
        6 => '週六',
        0 => '週日'
    ],
    'week_en_us' => [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        0 => 'Sunday'
    ],
    'insurance' => [
        /*1 => [
            'name_zh_cn' => '全球旅游意外保险基础款',
            'name_zh_tw' => '全球旅遊意外保險基礎款',
            'name_en_us' => 'Global travel accident insurance basic models',
            'price' => 1000,
            'desc_zh_cn' => '全球可保，含紧急医疗，多年畅销的旅游保险',
            'desc_zh_tw' => '全球可保，含緊急醫療，多年暢銷的旅遊保險',
            'desc_en_us' => 'Global insurable, including emergency medical care, for many years the best-selling travel insurance'
        ],
        2 => [
            'name_zh_cn' => '长安交通意外险 ',
            'name_zh_tw' => '长安交通意外险 ',
            'name_en_us' => '长安交通意外险 ',
            'price' => 30,
            'desc_zh_cn' => '全球可保，含紧急医疗，多年畅销的旅游保险',
            'desc_zh_tw' => '全球可保，含紧急医疗，多年畅销的旅游保险',
            'desc_en_us' => '全球可保，含紧急医疗，多年畅销的旅游保险'
        ]*/
    ],
    'zhengjian' => [
        1 => [
            'zh_cn' => '身份证',
            'zh_tw' => '身份證',
            'en_us' => 'ID card'
        ],
        2 => [
            'zh_cn' => '护照',
            'zh_tw' => '護照',
            'en_us' => 'passport'
        ]
    ],
    'pay_time' => '3600', // 订单支付最长时间
    'preferentialPolicy' => [
        '<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px">
    <strong><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:bold;font-style:normal;font-size:14px;background:rgb(255,255,255)">【报名方式】</span></strong>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px">
    <span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">凡有意向参加本网站旅行团者，可通过以下任一方式报名</span><strong><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:bold;font-style:normal;font-size:14px;background:rgb(255,255,255)">。</span></strong>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px">
    <span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●网站在线报名：按在线流程填写报名表提交即可。</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●电子邮件报名：您可下载电子档报名表，按要求填写后通过邮件发送至以下邮箱：</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px">
    <span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">tour@imagetrans.eu&nbsp;/&nbsp;tour@orangeway.cn&nbsp;</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●传真报名：下载报名表，并按要求填写后，传真至本网站确认报名。</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●德国传真号码：0049-69-92887588</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●中国传真号码：0086-592-2950728</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●短信报名：你可以将您的主要信息（姓名，人数，参团日期等）发送至0049 17610019515，我们的工作人员在收悉短信后会在一个工作日内和您联系具体的事宜。</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">●电话报名：中国大陆报名热线：400-8866-897</span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)"><br/></span><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">*如有其它任何要求或疑问，同样可致电该客户服务热线进行咨询（电话报名后仍需要补充书面签字报名和相关材料）。</span>
</p>
<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;text-indent:0;border-bottom:1px solid rgb(255,153,0);padding:0 0 0 0 ;text-align:left;line-height:30px;background:rgb(255,255,255)">
    <strong><span style=";font-family:Tahoma;color:rgb(0,0,0);letter-spacing:0;font-weight:bold;font-style:normal;font-size:14px;background:rgb(255,255,255)">付款方式</span></strong>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:28px;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">付款方式包括现金、汇款、转账、支票、信用卡等。</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:28px;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">如果持信用卡者无法到本网站现场付款，可采用信用卡号码远程付款方式。</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:28px;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">临时参团者（出团前两日内），本网站需加收5%附加操作费。</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <strong><span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:bold;font-style:normal;font-size:14px;background:rgb(255,255,255)">账户信息：</span></strong>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">Beneficiary:&nbsp;Imagetrans&nbsp;GmbH</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">Bank&nbsp;Name:&nbsp;&nbsp;Commerzbank&nbsp;Frankfurt</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">Bank&nbsp;Account&nbsp;No.:Kontonummer:&nbsp;338880800</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">Bank&nbsp;Code:&nbsp;&nbsp;BLZ:&nbsp;5004&nbsp;0000</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">DD:Kaiserstr.&nbsp;30，60311&nbsp;Frankfurt</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">BIC:&nbsp;COBADEFFXXX</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px;background:rgb(255,255,255)">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">IBAN:&nbsp;DE11500400000338880800</span>
</p>
<p style="margin-top:20px;margin-right:0;margin-bottom:0;margin-left:0;padding:0 0 0 0 ;line-height:25px">
    <span style=";font-family:宋体;color:rgb(0,0,0);letter-spacing:0;font-weight:normal;font-style:normal;font-size:14px;background:rgb(255,255,255)">VAT&nbsp;No.:&nbsp;DE04523608218</span>
</p>
<p>
    <br/>
</p>'
    ],
    'index_tuijian_zhou'=>['亚洲','欧洲','美洲','非洲']
] // 预定须知模板
;