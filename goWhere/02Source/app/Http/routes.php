<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
\App\Helpers\Common::globalXssClean();

Route::get('/', 'Index\IndexController@index');
Route::get('about-us', 'Index\IndexController@aboutUs');
Route::get('events', 'Index\IndexController@events');
Route::get('team', 'Index\IndexController@team');
Route::get('faq/{category?}', 'Index\IndexController@faq')->where('category', '[1-8]');
Route::get('credit', 'Index\IndexController@credit');
Route::get('contact-us', 'Index\IndexController@contactUs');
Route::get('partners', 'Index\IndexController@partners');
Route::get('errors/error', 'Common\CommonController@error');

/**
 * 验证
 */
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function() {
    // 登录、登出、注册
    Route::get('login', 'AuthController@getLogin');
//    Route::post('login', ['uses'=>'AuthController@postLogin', 'https']);
    Route::post('login', ['uses'=>'AuthController@postLogin']);
    Route::get('logout', 'AuthController@getLogout');
    // 注册
    Route::get('register', 'AuthController@getRegister');
    Route::get('register/1', ['uses'=>'AuthController@registerByPhone']);
//    Route::post('register/1', ['uses'=>'AuthController@registerByPhone', 'https']);
    Route::post('register/1', ['uses'=>'AuthController@registerByPhone']);
    Route::get('register/2', ['uses'=>'AuthController@registerByEmail']);
//    Route::post('register/2', ['uses'=>'AuthController@registerByEmail', 'https']);
    Route::post('register/2', ['uses'=>'AuthController@registerByEmail']);
    // 注册确认
    Route::get('confirm/{email}/{token}', 'AuthController@confirm');
    // 邮箱修改确认
    Route::get('confirm/mail/{email}/{token}', 'AuthController@confirmEmail');
    // 第三方登录
    Route::get('{driver}', 'AuthController@redirectToProvider')->where('driver', 'weibo|qq');
    Route::get('{driver}/callback', 'AuthController@handleProviderCallback');
    // 图片验证码
    Route::get('captcha/{tmp}', 'CaptchaController@captcha');
    // 短信验证码
    Route::post('captcha/getSMSCode', 'CaptchaController@getSMSCode');
    Route::post('captcha/getMySMSCode', 'CaptchaController@getMySMSCode');
    // 密码重置链接请求路由
    Route::get('password/1', 'PasswordController@index');
//    Route::post('password/2', ['uses'=>'PasswordController@postRetrieve', 'https']);
    Route::post('password/2', ['uses'=>'PasswordController@postRetrieve']);
    Route::get('password/2', 'PasswordController@getRetrieve');
    Route::post('password/resetForm', 'PasswordController@resetFormByPhone');
    Route::get('password/resetForm/{token}', 'PasswordController@resetForm');
//    Route::post('password/resetByEmail', ['uses'=>'PasswordController@postReset', 'https']);
    Route::post('password/resetByEmail', ['uses'=>'PasswordController@postReset']);
//    Route::post('password/resetByPhone', ['uses'=>'PasswordController@postResetByPhone', 'https']);
    Route::post('password/resetByPhone', ['uses'=>'PasswordController@postResetByPhone']);
});

/**
 * 后台
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin::'], function() {
    Route::get('login', ['uses'=>'Auth\AuthController@getLogin'])->name('login');
//    Route::post('login', ['uses'=>'Auth\AuthController@postLogin','https'])->name('postLogin');
    Route::post('login', ['uses'=>'Auth\AuthController@postLogin'])->name('postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout')->name('logout');
    // 需要后台权限才能访问的部分
    Route::get('index', 'System\ManageController@index')->name('index');
    Route::any('profile', 'System\ManageController@profile')->name('profile');
    Route::any('system/addpermission', 'System\PermissionController@addPermissions')->name('managePermissions');
    // 后台用户管理
    Route::get('system/userlist/{page?}', 'System\PermissionController@userList')->where('page', '[0-9]+')->name('userList');
//    Route::any('system/adduser', ['uses'=>'System\PermissionController@addUser', 'https'])->name('addUser');
    Route::any('system/adduser', ['uses'=>'System\PermissionController@addUser'])->name('addUser');
//    Route::any('system/edituser/{id}', ['uses'=>'System\PermissionController@editUser', 'https'])->name('editUser');
    Route::any('system/edituser/{id}', ['uses'=>'System\PermissionController@editUser'])->name('editUser');
    Route::any('system/removeuser/', 'System\PermissionController@removeUser')->name('removeUser');
    Route::any('system/addrole', 'System\PermissionController@addRole')->name('addRole');
    Route::any('system/grantpermission/{id}', 'System\PermissionController@grantPermission')->name('grantPermission');
    Route::get('system/rolelist/{page?}', 'System\PermissionController@roleList')->where('page', '[0-9]+')->name('roleList');
    Route::any('system/editrole/{id}', 'System\PermissionController@editRole')->name('editRole');
    Route::any('system/removerole/', 'System\PermissionController@removeRole')->name('removeRole');
    Route::any('system/roleuser/', 'System\PermissionController@roleUser')->name('roleUser');
    Route::post('system/searchuser/', 'System\PermissionController@searchUser')->name('searchUser');
    // 前台用户管理
    Route::get('system/memberlist/{page?}', 'System\MemberController@memberList')->where('page', '[0-9]+')->name('memberList');
//    Route::any('system/member/{id}', ['uses'=>'System\MemberController@member', 'https'])->where('id', '[0-9]+')->name('member');
    Route::any('system/member/{id}', ['uses'=>'System\MemberController@member'])->where('id', '[0-9]+')->name('member');
    // 广告
    Route::any('manage/advertisement/{id?}', 'System\ManageController@adManagement')->name('adManagement');
    Route::any('manage/editad/{id}', 'System\ManageController@editAd')->name('editAd');
    Route::get('manage/removead/{id}', 'System\ManageController@removeAd')->name('removeAd');
    // faq
    // 分类管理
    Route::any('manage/faqcatelist/{page?}', 'System\ManageController@faqCategoryList')->where('page', '[0-9]+')->name('faqCategoryList');
    Route::any('manage/faqcategory/{id}', 'System\ManageController@faqCategory')->name('faqCategory');
    Route::any('manage/removefaqcate/{id?}', 'System\ManageController@removeFaqCategory')->name('removeFaqCategory');
    Route::any('manage/faqlist/{page?}', 'System\ManageController@faqlist')->where('page', '[0-9]+')->name('faqList');
    Route::any('manage/faq/{id}', 'System\ManageController@faq')->name('faq');
    Route::any('manage/removefaq/{id?}', 'System\ManageController@removeFaq')->name('removeFaq');
    // 友情链接
    Route::any('manage/linklist/{page?}', 'System\ManageController@linkList')->where('page', '[0-9]+')->name('linkList');
    Route::any('manage/editLink/{id}', 'System\ManageController@editLink')->name('editLink');
    Route::get('manage/removeLink/', 'System\ManageController@removeLink')->name('removeLink');
    // 定制旅游
    Route::get('customization/needlist/{page?}', 'Customization\CustomController@needList')->where('page', '[0-9]+')->name('customNeedList');
    Route::get('customization/detail/{id}', 'Customization\CustomController@detail')->where('id', '[0-9]+')->name('customNeedDetail');
    Route::post('customization/changestatus/{id}', 'Customization\CustomController@changeStatus')->where('id', '[0-9]+')->name('customNeedStatus');
    Route::any('customization/plannerlist/{page?}', 'Customization\CustomController@plannerList')->where('page', '[0-9]+')->name('customPlannerList');
    Route::any('customization/addplanner/', 'Customization\CustomController@addPlanner')->where('page', '[0-9]+')->name('customAddPlanner');
    Route::any('customization/editplanner/', 'Customization\CustomController@editPlanner')->where('page', '[0-9]+')->name('customEditPlanner');
    Route::any('customization/removeplanner/{id?}', 'Customization\CustomController@removePlanner')->name('customRemovePlanner');
    Route::any('customization/caselist/{page?}', 'Customization\CustomController@caseList')->where('page', '[0-9]+')->name('customCaseList');
    Route::any('customization/case/{id}', 'Customization\CustomController@customCase')->name('customCase');
    Route::any('customization/removecase/{id?}', 'Customization\CustomController@removeCase')->name('removeCustomCase');
    //推荐管理
    Route::get('tour/adddictionary', 'Tour\TourController@addDictionary');
    Route::get('manage/recommendlist/{type?}', 'System\ManageController@recommendList')->where('type', '[0-9]+')->name('recommendList');
    Route::post('manage/addrecommend', 'System\ManageController@addRecommend')->name('addRecommend');
    Route::any('manage/delrecommend', 'System\ManageController@delRecommend')->name('delRecommend');
    Route::get('manage/getrecommend', 'System\ManageController@getRecommendById')->name('getRecommendById');
    Route::post('manage/updaterecommend', 'System\ManageController@updateRecommend')->name('updateRecommend');
    //会奖案例
    Route::get('mice/caseslist', 'Mice\MiceController@casesList')->name('casesList');
    Route::post('mice/addcases', 'Mice\MiceController@addCases')->name('addCases');
    Route::get('mice/delcases', 'Mice\MiceController@delCases')->name('delCases');
    Route::post('mice/updatecases', 'Mice\MiceController@updateCases')->name('updateCases');
    Route::get('mice/casesdetail/{id}', 'Mice\MiceController@casesDetail')->where('id', '[0-9]+')->name('casesDetail');

    //会奖需求
    Route::get('mice/needslist', 'Mice\MiceController@needsList')->name('needsList');
    Route::get('mice/updateneed', 'Mice\MiceController@updateNeed')->name('updateNeed');
    //会奖目的地
    Route::get('mice/destlist', 'Mice\MiceController@destList')->name('destList');
    Route::post('mice/adddest', 'Mice\MiceController@addDest')->name('addDest');
    Route::post('mice/updatedest', 'Mice\MiceController@updateDest')->name('updateDest');
    Route::get('mice/deldest', 'Mice\MiceController@delDest')->name('delDest');
    Route::get('mice/getdestbyid/{id}', 'Mice\MiceController@getDestById')->where('id', '[0-9]+')->name('getDestById');
    //跟团游
    Route::get('tour/tourlist', 'Tour\TourController@tourList')->name('tourList');
    Route::any('tour/addtour', 'Tour\TourController@addTour')->name('addTour');
    Route::any('tour/updatetour', 'Tour\TourController@updateTour')->name('updateTour');
    Route::any('tour/deltour', 'Tour\TourController@delTour')->name('delTour');
    Route::any('tour/addtourtotravel', 'Tour\TourController@addTourToTravel')->name('addTourToTravel');
    Route::any('tour/updatetourtotravel', 'Tour\TourController@updateTourToTravel')->name('updateTourToTravel');
    Route::any('tour/deltravel', 'Tour\TourController@delTourToTravel')->name('delTourToTravel');
    Route::any('tour/addtourremark', 'Tour\TourController@addTourRemark')->name('addTourRemark');
    Route::post('tour/addtourimage', 'Tour\TourController@addTourImage')->name('addTourImage');
    Route::get('tour/deltourimage', 'Tour\TourController@delTourImage')->name('delTourImage');
    Route::any('tour/ueditorupload', 'Tour\TourController@ueditorUpload')->name('ueditorUpload');
    Route::post('tour/addpricedate', 'Tour\TourController@addPriceDate')->name('addPriceDate');
    Route::post('tour/updatepricedate', 'Tour\TourController@updatePriceDate')->name('updatePriceDate');
    Route::get('tour/getpricedate', 'Tour\TourController@getPriceDateById')->name('getPriceDateById');
    Route::get('tour/delpricedate', 'Tour\TourController@delPriceDate')->name('delPriceDate');
    Route::get('tour/gettravel/{id?}', 'Tour\TourController@getTravelById')->where('id', '[0-9]+')->name('getTravelById');
    Route::get('tour/checktour', 'Tour\TourController@checkTour')->name('checkTour');
    //货币
    Route::any('tour/currencylists', 'System\ManageController@currencyLists')->name('currencyLists');
    Route::any('tour/getcurrency', 'System\ManageController@getCurrency')->name('getCurrency');
    Route::any('tour/delcurrency', 'System\ManageController@delCurrency')->name('delCurrency');
    Route::any('tour/updatecurrency', 'System\ManageController@updateCurrency')->name('updateCurrency');
    //地区管理
    Route::get('tour/arealist', 'System\ManageController@areaList')->name('areaList');
    Route::any('tour/addarea', 'System\ManageController@addArea')->name('addArea');
    Route::any('tour/getarea', 'System\ManageController@getAreaById')->name('getAreaById');
    Route::any('tour/updatearea', 'System\ManageController@updateArea')->name('updateArea');
    Route::any('tour/delarea', 'System\ManageController@delArea')->name('delArea');
    //订单管理
    Route::get('order/tourorderlist', 'System\OrderController@tourOrderList')->name('tourOrderList');
    Route::get('order/tourorderdetail', 'System\OrderController@tourOrderDetail')->name('tourOrderDetail');
});

/**
 * 展会
 */
//Route::group(['namespace' => 'Fair', 'prefix' => 'fair'], function () {
//    Route::get('index', 'FairController@index');
//    Route::any('more', 'FairController@more');
//    Route::get('detail/{fairId}', 'FairController@detail')->where('fairId', '[0-9]+');
//    Route::any('reserve/{fairId}', 'FairController@reserve')->where('fairId', '[0-9]+');
//    Route::any('pavilions/{hotArea?}', ['uses' => 'PavilionController@more', 'middleware' => 'formatUrlParam:hotArea_pavilionSearch']);
//    Route::get('pavilion/{id}', 'PavilionController@detail')->where('id', '[0-9]+');
//});

/**
 * 定制游
 */
Route::group(['namespace' => 'Customization', 'prefix' => 'customization'], function () {
    Route::get('index', 'CustomController@index');
    Route::any('submit', 'CustomController@submit');
});

/**
 * 个人中心
 */
Route::group(['namespace' => 'Member', 'prefix' => 'member'], function () {
    Route::get('index', 'MemberController@index');
    Route::any('submit', 'MemberController@submit');
    Route::post('changeavatar', 'MemberController@changeAvatar');
    // 个人设置
    Route::get('account', 'MemberController@account');
    Route::post('changePassword', 'MemberController@changePassword');
    Route::post('changeEmail', 'MemberController@changeEmail');
    Route::post('changePhone/{step}', 'MemberController@changePhone')->where('id', '[1-2]');
    Route::post('changePassword', 'MemberController@changePassword');
    Route::post('changeInfo', 'MemberController@changeInfo');
    
    // 订单列表
    Route::any('order', 'OrderController@index');
    Route::any('order/hotel', 'OrderController@hotel');
    Route::any('order/flight', 'OrderController@flight');
    Route::any('order/tour', 'OrderController@tour');
    Route::any('order/customization', 'OrderController@customization');
    Route::any('order/search', 'OrderController@search');
    Route::post('order/cancel', 'OrderController@cancel');
    // 订单详情
    Route::get('order/detail/{ordersn}', 'OrderController@detail');
});



Route::group(['prefix' => 'mice'], function () {
    Route::get('index', 'Mice\MiceController@index');
    Route::post('addneeds', 'Mice\NeedsController@addNeeds');
    Route::post('addneedsall', 'Mice\NeedsController@addNeedsAll');
    Route::get('caseslist', 'Mice\CasesController@index');
    Route::get('casesdetail/{id}', 'Mice\CasesController@detail')->where('id', '[0-9]+');
    Route::get('destdetail/{id}', 'Mice\DestController@detail')->where('id', '[0-9]+');
});
Route::group(['prefix' => 'tour'], function () {
    Route::any('lists', 'Tour\TourController@lists');
    Route::get('index', 'Tour\TourController@index');
    Route::get('detail/{id}', 'Tour\TourController@detail')->where('id', '[0-9]+');
    Route::get('getpricebyiddate', 'Tour\TourController@getPriceByIdDate');
    Route::post('booknext', 'Tour\TourController@bookNext');
    Route::post('bookcheck', 'Tour\TourController@bookCheck');
    Route::post('addorder', 'Tour\TourController@addOrder');
    Route::get('pay', 'Tour\TourController@pay');
    Route::post('topay', 'Tour\TourController@toPay');
    Route::any('{payType}/paynotify', 'Tour\TourController@payNotify');
    Route::any('{payType}/payreturn', 'Tour\TourController@payReturn');
    Route::get('paysuccess', 'Tour\TourController@paySuccess');
});

/**
 * 酒店模块
 * 
 * @author xiening 2016-06-30
 * 
 */
Route::group(['namespace' => 'Hotel', 'prefix' => 'hotel'], function () {
	//酒店模块首页
	Route::get('index', 'HotelController@index');
	//酒店模块-酒店搜索列表
	Route::any('list', 'HotelController@lists');
	//酒店模块-酒店详情页

	Route::get('detail', 'HotelController@detail');
	//下单

	Route::any('order', 'HotelController@order');
	//下单处理动作
	Route::any('addorder', 'HotelController@addorder');
	
	//酒店 订单
	Route::get('pay', 'HotelController@pay');
	Route::post('topay', 'HotelController@toPay');
	Route::any('{payType}/paynotify', 'HotelController@payNotify');
	Route::any('{payType}/payreturn', 'HotelController@payReturn');
	Route::get('paysuccess', 'HotelController@paySuccess');
});	
Route::get('area/getarea', 'Common\AreaController@getById');
Route::get('areaSelect/citylists.js', 'Common\AreaController@getCityLists');
