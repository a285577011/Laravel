<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Recommend;

class IndexController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        $recList = Recommend::getRecommond(1, config('common.indexRecommendTourNum'));
        $caseList = Recommend::getRecommond(2, config('common.indexSucCaseNum'));
        return view('index.index', [
            'caseTypeConf' => config('mice.need_type'),
            'peopleNumConf' => config('mice.people_num'),
            'budgetConf' => config('mice.budget'),
            'hotelStarConf' => config('hotel.starOption'),
            'flightClassConf' => config('flight.fareClass'),
            'hotelPriceConf' => config('hotel.priceOption'),
            'recList' => $recList,
            'caseList' => $caseList,
        ]);
    }

    /**
     * 关于我们
     */
    public function aboutUs()
    {
        return view('index.about-us');
    }

    /**
     * 大事记
     */
    public function events()
    {
        return view('index.events');
    }

    /**
     * 管理团队
     */
    public function team()
    {
        return view('index.team');
    }

    /**
     * 常见问题
     */
    public function faq()
    {
        $category = \Route::current()->parameter('category', 1);
        $numArr = [
            1 => 9,
            2 => 4,
            3 => 10,
            4 => 10,
            5 => 10,
            6 => 10,
            7 => 3,
            8 => 7,
        ];
        return view('index.faq', [
            'category' => $category,
            'num' => $numArr[$category],
        ]);
    }

    /**
     * 常见问题
     */
    public function faqDb(Request $request)
    {
        $category = \Route::current()->parameter('category', 1);
        $model = new \App\Models\Faq();
        $categories = \App\Models\FaqCategory::getAll();
        $page = $request->input('page', 1);
        $pageNum = 10;
        list($list, $count) = $model->getList(($page-1)*$pageNum, $pageNum, ['category'=>$category]);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::faqList', ['category', $category]),
        ]);
        return view('index.faq', [
            'categories' => $categories,
            'list' => $list,
            'num' => $count,
            'paginator' => $paginator,
        ]);
    }

    /**
     * 积分规则
     */
    public function credit()
    {
        return view('index.credit');
    }

    /**
     * 联系我们
     */
    public function contactUs()
    {
        return view('index.contact-us');
    }

    /**
     * 合作伙伴
     */
    public function partners()
    {
        return view('index.partners');
    }

}
