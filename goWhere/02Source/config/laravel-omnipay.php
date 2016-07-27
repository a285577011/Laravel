<?php
return [
    
    // The default gateway to use
    'default' => 'alipay',
    
    // Add in each gateway here
    'gateways' => [
        /*
         * 'paypal' => [
         * 'driver' => 'PayPal_Express',
         * 'options' => [
         * 'solutionType' => '',
         * 'landingPage' => '',
         * 'headerImageUrl' => ''
         * ]
         * ],
         */
        'alipay' => [
            'driver' => 'Alipay_Express',
            'options' => [
                'partner' => '2088301659063775',
                'key' => '2lnpknxqudhtnrb8oyauu2fxe72y1qrk',
                'sellerEmail' => 'imagetrans@orangeway.cn',
                'returnUrl' => PHP_SAPI === 'cli' ? false : url('tour/alipay/payreturn'),
                'notifyUrl' => PHP_SAPI === 'cli' ? false : url('tour/alipay/paynotify')
            ]
        ]
    ],
    
    /**
     * add by xiening
     * 酒店订单支付接口
     */
    'hotel' => [
	    'alipay' => [
		    'driver' => 'Alipay_Express',
			'options' => [
			    'partner' => '2088301659063775',
			    'key' => '2lnpknxqudhtnrb8oyauu2fxe72y1qrk',
			    'sellerEmail' => 'imagetrans@orangeway.cn',
			    'returnUrl' => PHP_SAPI === 'cli' ? false : url('hotel/alipay/payreturn'),
			    'notifyUrl' => PHP_SAPI === 'cli' ? false : url('hotel/alipay/paynotify')
			]
	    ]
    ]
]
;