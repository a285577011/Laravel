<?php
return [
    'admin::index' => [
        'text' => '后台首页',
        'route' => 'admin::index',
        'parent' => null,
        'icon' => 'fa-tachometer',
        'permission' => 'admin:index',
        'hide' => true
    ],
    'admin::profile' => [
        'text' => '个人设置',
        'route' => 'admin::profile',
        'parent' => null,
        'permission' => 'admin:profile',
        'hide' => true
    ],
    'admin::memberList' => [
        'text' => '会员管理',
        'route' => 'admin::memberList',
        'parent' => null,
        'permission' => 'member:show-list',
        'icon' => 'fa-users'
    ],
    'admin::member' => [
        'text' => '会员详情',
        'route' => 'admin::member',
        'permission' => 'member:item-detail-*',
        'parent' => 'admin::memberList',
        'hide' => true, // 不显示在左侧菜单
    ],
    '订单管理' => [
        'text' => '订单管理',
        'parent' => null,
        'icon' => 'fa-credit-card'
    ],
//    '机票订单列表' => [
//        'text' => '机票订单列表',
//        'parent' => '订单管理',
//        'permission' => 'flight:order-list'
//    ],
//    '机票订单详情' => [
//        'text' => '机票订单详情',
//        'parent' => '机票订单列表',
//        'permission' => 'flight:order-detail',
//        'hide' => true
//    ],
//    '酒店订单列表' => [
//        'text' => '酒店订单列表',
//        'parent' => '订单管理',
//        'permission' => 'hotel:order-list'
//    ],
//    '酒店订单详情' => [
//        'text' => '酒店订单详情',
//        'parent' => '酒店订单列表',
//        'permission' => 'hotel:order-detail',
//        'hide' => true
//    ],
    'admin::tourOrderList' => [
        'text' => '跟团游订单列表',
        'permission' => 'tour:order-list',
        'parent' => '订单管理',
        'route' => 'admin::tourOrderList',
    ],
    'admin::tourOrderDetail' => [
        'text' => '跟团游订单详情',
        'permission' => 'tour:order-detail',
        'parent' => '跟团游订单列表',
        'hide' => true,
        'route' => 'admin::tourOrderDetail',
    ],
    '定制旅游订单列表' => [
        'text' => '定制旅游订单列表',
        'permission' => 'custom:order-list',
        'parent' => '订单管理',
        'hide' => true
    ],
    '定制旅游订单详情' => [
        'text' => '定制旅游订单列表',
        'permission' => 'custom:order-detail',
        'parent' => '订单管理',
        'hide' => true
    ],
    'admin::adManagement' => [
        'text' => '广告管理',
        'route' => 'admin::adManagement',
        'permission' => 'ad:show-list',
        'parent' => null,
        'icon' => 'fa-bullhorn'
    ],
    'admin::editAd' => [
        'text' => '广告详情',
        'permission' => 'ad:edit-detail',
        'parent' => 'admin::adManagement',
        'hide' => true
    ],
    'admin::removeAd' => [
        'text' => '删除广告',
        'permission' => 'ad:remove-item',
        'parent' => 'admin::adManagement',
        'hide' => true
    ],
    '产品管理' => [
        'text' => '产品管理',
        'parent' => null,
        'icon' => 'fa-briefcase'
    ],
    'admin::tourList' => [
        'text' => '跟团游产品列表',
        'parent' => '产品管理',
        'permission' => 'tour:show-list',
        'route' => 'admin::tourList'
    ],
    'admin::addTour' => [
        'text' => '添加跟团游',
        'parent' => '产品管理',
        'permission' => 'tour:add-tour',
        'route' => 'admin::addTour',
        'hide' => true
    ],
    'admin::updateTour' => [
        'text' => '修改跟团游',
        'parent' => '产品管理',
        'permission' => 'tour:edit-tour',
        'route' => 'admin::updateTour',
        'hide' => true
    ],
    'admin::delTour' => [
        'text' => '删除跟团游',
        'parent' => '产品管理',
        'permission' => 'tour:remove-tour',
        'route' => 'admin::delTour',
        'hide' => true
    ],
    'admin::addTourToTravel' => [
        'text' => '跟团游详细行程',
        'parent' => '产品管理',
        'route' => 'admin::addTourToTravel',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::updateTourToTravel' => [
        'text' => '更新跟团游详细行程',
        'parent' => '产品管理',
        'route' => 'admin::updateTourToTravel',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::getTravelById' => [
        'text' => '获取跟团游详细行程',
        'parent' => '产品管理',
        'route' => 'admin::getTravelById',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::delTourToTravel' => [
        'text' => '删除跟团游详细行程',
        'parent' => '产品管理',
        'route' => 'admin::delTourToTravel',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::addTourRemark' => [
        'text' => '添加跟团游备注说明',
        'parent' => '产品管理',
        'route' => 'admin::addTourRemark',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::addTourImage' => [
        'text' => '添加跟团游图片',
        'parent' => '产品管理',
        'route' => 'admin::addTourImage',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::delTourImage' => [
        'text' => '删除跟团游图片',
        'parent' => '产品管理',
        'route' => 'admin::delTourImage',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::ueditorUpload' => [
        'text' => '上传图片',
        'parent' => '产品管理',
        'route' => 'admin::ueditorUpload',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::addPriceDate' => [
        'text' => '添加产品价格日期',
        'parent' => '产品管理',
        'route' => 'admin::addPriceDate',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::getPriceDateById' => [
        'text' => '获取产品价格日期',
        'parent' => '产品管理',
        'route' => 'admin::getPriceDateById',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::updatePriceDate' => [
        'text' => '更新产品价格日期',
        'parent' => '产品管理',
        'route' => 'admin::updatePriceDate',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    'admin::delPriceDate' => [
        'text' => '删除产品价格日期',
        'parent' => '产品管理',
        'route' => 'admin::delPriceDate',
        'permission' => 'tour:show-list',
        'hide' => true
    ],
    '跟团游产品详情' => [
        'text' => '跟团游产品详情',
        'permission' => 'tour:edit-detail',
        'permission' => 'tour:show-list',
        'parent' => '跟团游产品列表',
        'hide' => true
    ],
    'admin::checkTour' => [
        'text' => '审核跟团游产品',
        'route' => 'admin::checkTour',
        'permission' => 'tour:checkTour',
        'parent' => '产品管理',
        'hide' => true
    ],
    '会奖案例管理' => [
        'text' => '会奖案例管理',
        'parent' => null,
        'icon' => 'fa-film',
    ],
    'admin::casesList' => [
        'text' => '会奖案例列表',
        'permission' => 'mice:case-list',
        'route' => 'admin::casesList',
        'parent' => '会奖案例管理'
    ],
    'admin::addCases' => [
        'text' => '添加案例',
        'permission' => 'mice:add-case',
        'route' => 'admin::addCases',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::delCases' => [
        'text' => '删除案例',
        'permission' => 'mice:remove-case',
        'route' => 'admin::delCases',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::updateCases' => [
        'text' => '更新案例',
        'permission' => 'mice:edit-case',
        'route' => 'admin::updateCases',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::casesDetail' => [
        'text' => '案例详情',
        'permission' => 'mice:case-detail',
        'route' => 'admin::casesDetail',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::destList' => [
        'route' => 'admin::destList',
        'permission' => 'mice:dest-list',
        'text' => '目的地列表',
        'parent' => '会奖案例管理'
    ],
    'admin::addDest' => [
        'route' => 'admin::addDest',
        'permission' => 'mice:add-dest',
        'text' => '添加目的地详情',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::getDestById' => [
        'route' => 'admin::getDestById',
        'permission' => 'mice:dest-detail',
        'text' => '获取目的地详情',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::updateDest' => [
        'route' => 'admin::updateDest',
        'text' => '更新目的地详情',
        'permission' => 'mice:edit-dest',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::delDest' => [
        'route' => 'admin::delDest',
        'permission' => 'mice:remove-dest',
        'text' => '删除目的地详情',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    'admin::needsList' => [
        'text' => '会奖需求列表',
        'permission' => 'mice:need-list',
        'route' => 'admin::needsList',
        'parent' => '会奖案例管理',
    ],
    'admin::updateNeed' => [
        'text' => '更新会奖需求',
        'permission' => 'mice:edit-need',
        'route' => 'admin::updateNeed',
        'parent' => '会奖案例管理',
        'hide' => true
    ],
    '会奖需求详情' => [
        'text' => '会奖需求详情',
        'permission' => 'mice:need-detail',
        'parent' => '会奖需求列表',
        'hide' => true
    ],
    '系统设置' => [
        'text' => '系统设置',
        'parent' => null,
        'icon' => 'fa-desktop'
    ],
    'admin::linkList' => [
        'text' => '友情链接列表',
        'permission' => 'link:show-list',
        'route' => 'admin::linkList',
        'parent' => '系统设置'
    ],
    'admin::editLink' => [
        'text' => '友情链接详情',
        'permission' => 'link:edit-detail',
        'route' => 'admin::editLink',
        'parent' => 'admin::linkList',
        'hide' => true
    ],
    'admin::removeLink' => [
        'text' => '删除友情链接',
        'permission' => 'link:remove-item',
        'route' => 'admin::removeLink',
        'parent' => 'admin::linkList',
        'hide' => true
    ],
    
//    'FAQ管理' => [
//        'text' => 'FAQ管理',
//        'parent' => '系统设置',
//    ],
//    
//    'admin::faqList' => [
//        'text' => 'FAQ列表',
//        'permission' => 'faq:show-list',
//        'parent' => 'FAQ管理',
//        'route' => 'admin::faqList',
//    ],
//    'admin::faq' => [
//        'text' => 'FAQ详情',
//        'permission' => 'faq:item-detail',
//        'parent' => 'admin::faqList',
//        'route' => 'admin::faq',
//        'hide' => true,
//    ],
//    'admin::removeFaq' => [
//        'text' => '删除FAQ',
//        'permission' => 'faq:remove-item',
//        'parent' => 'admin::faqList',
//        'route' => 'admin::removeFaq',
//        'hide' => true,
//    ],
//    
//    'admin::faqCategoryList' => [
//        'text' => 'FAQ分类',
//        'permission' => 'faq:category-list',
//        'parent' => 'FAQ管理',
//        'route' => 'admin::faqCategoryList',
//    ],
//    'admin::faqCategory' => [
//        'text' => 'FAQ分类详情',
//        'permission' => 'faq:category-detail',
//        'parent' => 'admin::faqCategoryList',
//        'route' => 'admin::faqCategory',
//        'hide' => true,
//    ],
//    'admin::removeFaqCategory' => [
//        'text' => '删除FAQ分类',
//        'permission' => 'faq:remove-category',
//        'parent' => 'admin::faqCategoryList',
//        'route' => 'admin::removeFaqCategory',
//        'hide' => true,
//    ],
    
    'admin::userList' => [
        'text' => '用户列表',
        'permission' => 'user:show-list',
        'route' => 'admin::userList',
        'parent' => '系统设置'
    ],
    'admin::editUser' => [
        'text' => '用户详情',
        'permission' => 'user:edit-detail',
        'route' => 'admin::editUser',
        'parent' => 'admin::userList',
        'hide' => true
    ],
    'admin::addUser' => [
        'text' => '添加用户',
        'permission' => 'user:add-item',
        'route' => 'admin::addUser',
        'parent' => 'admin::userList',
        'hide' => true
    ],
    'admin::removeUser' => [
        'text' => '删除用户',
        'permission' => 'user:remove-item',
        'route' => 'admin::removeUser',
        'parent' => 'admin::userList',
        'hide' => true
    ],
    'admin::roleList' => [
        'text' => '角色列表',
        'permission' => 'role:show-list',
        'route' => 'admin::roleList',
        'parent' => '系统设置'
    ],
    'admin::addRole' => [
        'text' => '添加角色',
        'permission' => 'role:add-item',
        'route' => 'admin::addRole',
        'parent' => 'admin::roleList',
        'hide' => true
    ],
    'admin::editRole' => [
        'text' => '角色详情',
        'permission' => 'role:edit-detail',
        'route' => 'admin::editRole',
        'parent' => 'admin::roleList',
        'hide' => true
    ],
    'admin::removeRole' => [
        'text' => '删除角色',
        'permission' => 'role:remove-item',
        'route' => 'admin::removeRole',
        'parent' => 'admin::roleList',
        'hide' => true
    ],
    'admin::grantPermission' => [
        'text' => '权限分配',
        'permission' => 'role:grant-perm',
        'route' => 'admin::grantPermission',
        'parent' => 'admin::roleList',
        'hide' => true
    ],
    'admin::roleUser' => [
        'text' => '角色用户管理',
        'permission' => 'role:manage-user',
        'route' => 'admin::roleUser',
        'parent' => 'admin::roleList',
        'hide' => true
    ],
    'admin::searchUser' => [
        'text' => '角色用户管理',
        'permission' => 'role:manage-user',
        'route' => 'admin::searchUser',
        'parent' => 'admin::roleUser',
        'hide' => true
    ],
    '定制游' => [
        'text' => '定制游',
        'parent' => null,
        'icon' => 'fa-gavel'
    ],
    'admin::customNeedList' => [
        'text' => '定制需求',
        'permission' => 'custom:need-list',
        'route' => 'admin::customNeedList',
        'parent' => '定制游'
    ],
    'admin::customNeedDetail' => [
        'text' => '需求详情',
        'permission' => 'custom:edit-need',
        'route' => 'admin::customNeedDetail',
        'parent' => 'admin::customNeedList',
        'hide' => true
    ],
    'admin::customNeedStatus' => [
        'text' => '修改定制游需求状态',
        'permission' => 'custom:handle-need*',
        'route' => 'admin::customNeedStatus',
        'parent' => 'admin::customNeedList',
        'hide' => true
    ],
    'admin::customPlannerList' => [
        'text' => '旅行规划师',
        'permission' => 'custom:planner-list',
        'route' => 'admin::customPlannerList',
        'parent' => '定制游'
    ],
    'admin::customAddPlanner' => [
        'text' => '添加规划师',
        'permission' => 'custom:add-planner',
        'route' => 'admin::customAddPlanner',
        'parent' => 'admin::customPlannerList',
        'hide' => true
    ],
    'admin::customEditPlanner' => [
        'text' => '编辑规划师',
        'permission' => 'custom:edit-planner',
        'route' => 'admin::customEditPlanner',
        'parent' => 'admin::customPlannerList',
        'hide' => true
    ],
    'admin::customRemovePlanner' => [
        'text' => '删除规划师',
        'permission' => 'custom:remove-planner',
        'route' => 'admin::customRemovePlanner',
        'parent' => 'admin::customPlannerList',
        'hide' => true
    ],
    'admin::customCaseList' => [
        'text' => '案例列表',
        'permission' => 'custom:case-list',
        'route' => 'admin::customCaseList',
        'parent' => '定制游',
    ],
    'admin::customCase' => [
        'text' => '案例详情',
        'permission' => 'custom:case-detail',
        'route' => 'admin::customCase',
        'parent' => 'admin::customCaseList',
        'hide' => true
    ],
    'admin::removeCustomCase' => [
        'text' => '删除案例',
        'permission' => 'custom:remove-case',
        'route' => 'admin::removeCustomCase',
        'parent' => 'admin::customCaseList',
        'hide' => true
    ],

    // 推荐
    'admin::recommendList' => [
        'text' => '推荐管理',
        'permission' => 'recommend:show-list',
        'route' => 'admin::recommendList',
        'parent' => null,
        'icon' => 'fa-heart',
    ],
    'admin::addRecommend' => [
        'text' => '添加推荐',
        'permission' => 'recommend:add-item',
        'route' => 'admin::addRecommend',
        'parent' => null,
        'hide' => true
    ],
    'admin::delRecommend' => [
        'text' => '删除推荐',
        'permission' => 'recommend:remove-item',
        'route' => 'admin::delRecommend',
        'parent' => null,
        'hide' => true
    ],
    'admin::getRecommendById' => [
        'text' => '获取推荐内容',
        'permission' => 'recommend:item-detail',
        'route' => 'admin::getRecommendById',
        'parent' => null,
        'hide' => true
    ],
    'admin::updateRecommend' => [
        'text' => '更新推荐',
        'permission' => 'recommend:edit-detail',
        'route' => 'admin::updateRecommend',
        'parent' => null,
        'hide' => true
    ],
    // end
    // 货币
    'admin::currencyLists' => [
        'text' => '货币管理',
        'permission' => 'currency:show-list',
        'route' => 'admin::currencyLists',
        'parent' => null,
        'icon' => 'fa-bar-chart-o',
    ],
    'admin::getCurrency' => [
        'text' => '获取货币信息',
        'permission' => 'currency:currency-detail',
        'route' => 'admin::getCurrency',
        'parent' => null,
        'hide' => true
    ],
    'admin::updateCurrency' => [
        'text' => '获取货币信息',
        'permission' => 'currency:edit-currency',
        'route' => 'admin::updateCurrency',
        'parent' => null,
        'hide' => true
    ],
    'admin::delCurrency' => [
        'text' => '删除货币信息',
        'permission' => 'currency:remove-currency',
        'route' => 'admin::delCurrency',
        'parent' => null,
        'hide' => true
    ],
    // end
    // 地区
    'admin::areaList' => [
        'text' => '地区管理',
        'permission' => 'area:show-list',
        'route' => 'admin::areaList',
        'parent' => null,
        'icon' => 'fa-globe',
    ],
    'admin::addArea' => [
        'text' => '添加地区',
        'permission' => 'area:add-area',
        'route' => 'admin::addArea',
        'parent' => null,
        'hide' => true
    ],
    'admin::getAreaById' => [
        'text' => '获取地区',
        'permission' => 'area:area-detail',
        'route' => 'admin::getAreaById',
        'parent' => null,
        'hide' => true
    ],
    'admin::updateArea' => [
        'text' => '更新地区',
        'permission' => 'area:edit-area',
        'route' => 'admin::updateArea',
        'parent' => null,
        'hide' => true
    ],
    'admin::delArea' => [
        'text' => '删除地区',
        'permission' => 'area:remove-area',
        'route' => 'admin::delArea',
        'parent' => null,
        'hide' => true
    ],
]
// end
;
