<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => '字段  :attribute 必须为数组',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => '字段  :attribute 不一致',
    'date'                 => '字段 :attribute 日期格式不对',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => '字段   :attribute 邮箱格式不正确',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => '字段 :attribute 必须大于 :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => '字段   :attribute 必须为数字',
    'regex'                => '字段   :attribute 匹配不通过',
    "required"             => "字段  :attribute 必须填写。",
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => '此 :attribute 已被使用.',
    'url'                  => 'The :attribute format is invalid.',
    'captcha'              => '验证码错误',
    'int_array'            => '参数类型或范围错误',
    'cnphone'              => '请输入有效的手机号码',
    'sms_captcha'          => '短信验证码不匹配',
    'password'             => '密码含有非法字符',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'user_id' => [
            'exists' => '指定的用户ID无效',
        ],
        'avatar_text' => [
            'required_without' => '请上传图片文件或输入图片地址',
        ],
        'attachment_text' => [
            'required_without' => '请上传文件或输入文件地址',
        ],
        'logo_text' => [
            'required_without' => '请上传LOGO或输入LOGO地址',
        ],
        'id' => [
            'required_without_all' => '必须至少输入一项',
        ],
        'username' => [
            'required_without_all' => '必须至少输入一项',
        ],
        'name' => [
            'required_without_all' => '必须至少输入一项',
        ],
        'phone' => [
            'unique' => '该手机号已被使用'
        ],
    ],
    'mice'=>[
        'destination'=>'请输入目的地!',
        'name'=>'请输入姓名!',
        'name_max'=>'姓名长度不超过30',
        'phone'=>'请填写手机号!',
        'isMobile'=>'请填写正确的手机号!',
        'departure_date'=>'请输入出发日期!',
        'email'=>'请输入邮箱!',
        'isEmail'=>'请输入正确的邮箱!',
        'QQorWeixin'=>'请输入QQ/微信!',
        'isQQorWeixin'=>'请输入正确的QQ/微信!',
        'people_num'=>'请选择人数',
        'budget'=>'请选择预算',
        'type'=>'请选择项目类型',
        'duration'=>'请填写出行天数'
    ],
    'tour'=>[
        'adult_num'=>'成人票数至少为1!',
        'contact_name'=>'请输入联系人姓名!',
        'contact_gender'=>'请选择联系人性别!',
        'contact_email'=>'请输入联系人邮箱!',
        'is_contact_email'=>'请输入正确的联系人邮箱!',
        'contact_phone'=>'请填写联系人手机号!',
        'is_contact_phone'=>'请填写正确的联系人手机号!',
        'isNeedFapiao'=>'请选择是否需要发票!',
        'fapiao_taitou'=>'请输入发票抬头!',
        'address'=>'请填写详细地址(发票)!',
        'tourist[adult][name][]'=>'请输入旅客姓名!',
        'checkName'=>'联系人名字格式错误',
        'must'=>'必填项!',
        'wrong_format'=>'格式错误!'
    ],
    'hotel'=>[
        'room_num_lest'=>'房间数至少为',
        'room_num_must'=>'请输入房间数量',
        'room_num_must_num'=>'房间数量必须为数字',
        'is_contact_wx'=>'请输入正确的联系人微信或者QQ!',
        'contact_wx'=>'请输入联系人微信或者QQ!',

    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
