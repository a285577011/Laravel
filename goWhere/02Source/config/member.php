<?php

return [
    // openid
    'oauthType' => [
        'weibo' => 1,
        'qq' => 2,
        'wechat' => 3,
    ],
    // 注册确认邮件标题
    'registerConfirmMail' => [
        'subject' => 'email.register_confirm_mail_subject',
        'expire' => 1440, //有效期，分钟
    ],
    // 确认邮件有效期(分钟)
    'changeEmailConfirmMail' => [
        'subject' => 'email.change_email_subject',
        'expire' => 1440,
    ],
    'emailLinkTime' => 1440,
    // Email Token Type
    'emailTokenType' => [
        'retrieve' => 1, //找回密码，不可修改
        'register' => 2, //注册确认
        'modify' => 3, //修改邮箱
    ],
    // 我的吉程页订单显示数量
    'memberOrderNum' => 5,
    'avatarSize' => [200, 200, true], // 头像尺寸 [宽, 高, 无条件缩放并截取中间部分]
];