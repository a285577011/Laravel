<?php
return [
    // 订单列表每页显示数量
    'orderListNum' => 10,
    // 快捷搜索选项
    'periodSearch' => [
        '1m' => 'member.last_month',
        '3m' => 'member.last_3_months',
        '1y' => 'member.last_year',
    ],
    // 订单类型选项
    'orderType' => [
        0 => 'member.all_orders',
//        4 => 'member.flight_orders',
//        3 => 'member.hotel_orders',
        1 => 'member.tour_orders',
//        2 => 'member.cust_orders',
    ],
    // 订单类型（短名称）
    'orderTypeShort' => [
        4 => 'index.hotels',
        3 => 'index.flights',
        1 => 'index.package_tours',
        2 => 'index.customized_tours',
    ],
    // 订单状态
    'orderStatus' => [
        1 => 'member.order_unpaid',
        2 => 'member.order_paid',
        3 => 'member.order_cancelled',
        4 => 'member.order_refunded',
    ],
    // 订单状态分类
    'orderStatusCfc' => [
        'all' => 'member.all_orders', //全部订单
        'awaitPay' => 'member.order_awaitPay',    //待付款订单
        'notTravel' => 'member.order_notTravel',   //未出行订单
        //'awaitReview' => 'member.order_awaitReview', //待评价订单
        'refund' => 'member.order_refund',  //退款订单
    ],
    //支付方式
    'payType'=>[
        1=>'支付宝'
    ]
];