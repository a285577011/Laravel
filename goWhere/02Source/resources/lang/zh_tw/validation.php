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
    'array'                => '欄位  :attribute 必須為陣列',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => '欄位  :attribute 不一致',
    'date'                 => '欄位 :attribute 日期格式不對',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => '欄位   :attribute 郵箱格式不正確',
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
        'numeric' => '欄位 :attribute 必須大於 :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => '欄位   :attribute 必須為數位',
    'regex'                => '欄位   :attribute 匹配不通過',
    "required"             => "欄位  :attribute 必須填寫。",
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
    'captcha'              => '驗證碼錯誤',
    'int_array'            => '參數類型或範圍錯誤',
    'cnphone'              => '請輸入有效的手機號碼',
    'sms_captcha'          => '短信驗證碼不匹配',
    'password'             => '密碼含有非法字元',

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
            'exists' => '指定的用戶ID無效',
        ],
        'avatar_text' => [
            'required_without' => '請上傳圖片檔或輸入圖片位址',
        ],
        'attachment_text' => [
            'required_without' => '請上傳檔或輸入檔位址',
        ],
        'logo_text' => [
            'required_without' => '請上傳LOGO或輸入LOGO位址',
        ],
        'id' => [
            'required_without_all' => '必須至少輸入一項',
        ],
        'username' => [
            'required_without_all' => '必須至少輸入一項',
        ],
        'name' => [
            'required_without_all' => '必須至少輸入一項',
        ],
        'phone' => [
            'unique' => '該手機號已被使用'
        ],
    ],
    'mice'=>[
        'destination'=>'請輸入目的地!',
        'name'=>'請輸入姓名!',
        'phone'=>'請填寫手機號!',
        'isMobile'=>'請填寫正確的手機號!',
        'departure_date'=>'請輸入出發日期!',
        'email'=>'請輸入郵箱!',
        'isEmail'=>'請輸入正確的郵箱!',
        'QQorWeixin'=>'請輸入QQ/微信!',
        'isQQorWeixin'=>'請輸入正確的QQ/微信!',
        'people_num'=>'請選擇人數',
        'budget'=>'請選擇預算',
        'type'=>'請選擇項目類型',
        'duration'=>'請填寫出行天數'
    ],
    'tour'=>[
        'adult_num'=>'成人票數至少為1!',
        'contact_name'=>'請輸入連絡人姓名!',
        'contact_gender'=>'請選擇連絡人性別!',
        'contact_email'=>'請輸入連絡人郵箱!',
        'is_contact_email'=>'請輸入正確的連絡人郵箱!',
        'contact_phone'=>'請填寫連絡人手機號!',
        'is_contact_phone'=>'請填寫正確的連絡人手機號!',
        'isNeedFapiao'=>'請選擇是否需要發票!',
        'fapiao_taitou'=>'請輸入發票抬頭!',
        'address'=>'請填寫詳細地址(發票)!',
        'tourist[adult][name][]'=>'請輸入旅客姓名!',
        'checkName'=>'連絡人名字格式錯誤',
        'must'=>'必填項!',
        'wrong_format'=>'格式錯誤!'
    ],
    'hotel'=>[
        'room_num_lest'=>'房間數至少為',
        'room_num_must'=>'請輸入房間數量',
        'room_num_must_num'=>'房間數量必須為數位',
        'is_contact_wx'=>'請輸入正確的連絡人微信或者QQ!',
        'contact_wx'=>'請輸入連絡人微信或者QQ!',

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
