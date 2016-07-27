<?php
namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Advertisement;
use App\Models\Link;
use App\Models\Recommend;
use App\Helpers\Upload;
use App\Helpers\Common;
use Event;
use App\Events\UploadsChanged;
use App\Models\Currency;
use App\Models\AdminUser;
use App\Models\Area;
use App\Helpers\TransChinese;

class ManageController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.system.index');
    }

    /**
     * 个人设置
     */
    public function profile(Requests\Admin\System\ProfileRequest $request)
    {
        $user = \Auth::user();
        if ($request->isMethod('POST')) {
            $result = AdminUser::profile($user, $request->all());
            if (! $result) {
                return $this->error($msg);
            }
            return $this->success(trans('admin.operate_done'));
        }
        $userRoles = $user->roles()->get();
        return view('admin.system.profile', [
            'info' => $user,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * 广告管理
     *
     * @param \App\Http\Requests\Admin\System\AdManagementRequest $request            
     */
    public function adManagement(Requests\Admin\System\AdManagementRequest $request)
    {
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $attachment = $uploader->saveImage($request->file('attachment'));
            $new = Advertisement::addAd($request->all(), $attachment);
            if (! $new) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        $type = $request->input('type');
        $module = $request->input('module');
        $title = $request->input('title');
        $list = Advertisement::getList(($page - 1) * $pageNum, $pageNum, $module, $type, $title);
        $count = Advertisement::count();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::adManagement')
        ]);
        return view('admin.system.admanagement', [
            'moduleConf' => config('common.adModule'),
            'typeConf' => config('common.adType'),
            'positionConf' => config('common.adPosition'),
            'list' => $list,
            'paginator' => $paginator,
            'title' => $title,
            'module' => $module,
            'type' => $type
        ]);
    }

    /**
     * 广告编辑
     *
     * @param \App\Http\Requests\Admin\System\editAdRequest $request            
     * @return
     *
     */
    public function editAd(Requests\Admin\System\EditAdRequest $request)
    {
        $ad = Advertisement::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $attachment = $uploader->saveImage($request->file('attachment'));
            $ad = Advertisement::editAd($ad, $request->all(), $attachment);
            if (! $ad) {
                return back()->withErrors(trans('admin.operate_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        return view('admin.system.editad', [
            'info' => $ad,
            'moduleConf' => config('common.adModule'),
            'typeConf' => config('common.adType'),
            'positionConf' => config('common.adPosition')
        ]);
    }

    /**
     * 删除一个广告
     *
     * @param \App\Http\Requests\Common\GetIdRequest $request            
     */
    public function removeAd(Requests\Common\GetIdRequest $request)
    {
        $ad = Advertisement::findOrFail($request->input('id'));
        if (! Advertisement::destroy($request->input('id'))) {
            return back()->withErrors(trans('admin.operate_fail'));
        }
        Event::fire(new UploadsChanged($ad->attachment, ''));
        return back()->with('message', trans('admin.operate_done'));
    }

    /**
     * 友情链接列表
     */
    public function linkList(Requests\Admin\System\AddLinkRequest $request)
    {
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $logo = $uploader->saveImage($request->file('logo'));
            $new = Link::addLink($request->all(), $logo);
            if (! $new) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        $list = Link::skip(($page - 1) * $pageNum)->take($pageNum)->get();
        $count = Link::count();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::linkList')
        ]);
        return view('admin.system.linklist', [
            'list' => $list,
            'paginator' => $paginator
        ]);
    }

    /**
     * 修改链接
     */
    public function editLink(Requests\Admin\System\EditLinkRequest $request)
    {
        $link = Link::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $logo = $uploader->saveImage($request->file('logo'));
            $link = Link::editLink($link, $request->all(), $logo);
            if (! $link) {
                return $this->error();
            }
            return $this->success();
        }
        $link->logoUrl = url(Common::getStoragePath($link->logo));
        return $this->ajaxReturn($link);
    }

    /**
     * 删除链接
     */
    public function removeLink(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [
            $request->input('id')
        ];
        $logos = Link::select('id')->whereIn('id', $ids)
            ->get()
            ->pluck('logo', 'id')
            ->all();
        if (! Link::destroy($ids)) {
            return $this->error(trans('admin.operate_fail'));
        } else {
            Event::fire(new UploadsChanged($logos, ''));
            return $this->success();
        }
    }

    /**
     * 推荐列表
     */
    public function recommendList($type = 1)
    {
        $where = [];
        $where['type'] = $type;
        $data = Recommend::where($where)->paginate(\Config::get('admin.commonPageNum'));
        return view('admin.system.recommend', [
            'data' => $data,
            'type' => $type
        ]);
    }

    /**
     * 添加推荐
     *
     * @param Request $request            
     */
    public function addRecommend(Request $request)
    {
        $recommend = new Recommend();
        $lang = \App::getLocale();
        $recommend->type = intval($request->input('type'));
        $recommend->order = intval($request->input('sort'));
        $nameKey = 'name_' . $lang;
        $recommend->$nameKey = $request->input('name');
        $recommend->url = $request->input('url');
        $upload = new Upload();
        $res = $upload->save();
        $image = '';
        if ($res && $res['success']) {
            $image = $res['success'][0]['path'];
        }
        $recommend->image = $image;
        $descKey = 'desc_' . $lang;
        $recommend->$descKey = $request->input('desc');
        if ($lang == 'zh_cn') {
            $recommend->name_zh_tw = TransChinese::transToTw($request->input('name'));
            $recommend->desc_zh_tw = TransChinese::transToTw($request->input('desc'));
        }
        if ($recommend->save()) {
            echo '<script>alert("添加成功");window.location.href = document.referrer;</script>';
            exit();
        }
        echo '<script>alert("添加失败");window.location.href = document.referrer;</script>';
        exit();
    }

    /**
     * 删除推荐
     */
    public function delRecommend(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (Recommend::destroy($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    /**
     * 获取推荐
     */
    public function getRecommendById(Request $request)
    {
        $data = Recommend::getOne(intval($request->input('id')));
        // echo '<pre>';print_r($data->toArray());die;
        if ($request->ajax()) {
            return \Response::json(array(
                'status' => 1,
                'data' => $data
            ));
        }
    }

    /**
     * 修改推荐
     */
    public function updateRecommend(Request $request)
    {
        $lang = \App::getLocale();
        $id = intval($request->input('id'));
        $order = intval($request->input('sort'));
        $name = $request->input('name');
        $url = $request->input('url');
        $upload = new Upload();
        $res = $upload->save();
        $image = '';
        if ($res && $res['success']) {
            $image = $res['success'][0]['path'];
        }
        $update = [
            'order' => $order,
            'name_' . $lang => $name,
            'order' => $order,
            'url' => $url
        ];
        $image && $update['image'] = $image;
        $desc = $request->input('desc');
        $update['desc_' . $lang] = $desc;
        if ($lang == 'zh_cn') {
            $update['name_zh_tw'] = TransChinese::transToTw($request->input('name'));
            $update['desc_zh_tw'] = TransChinese::transToTw($request->input('desc'));
        }
        if (is_int(Recommend::where([
            'id' => $id
        ])->update($update))) {
            echo '<script>alert("修改成功");window.location.href = document.referrer;</script>';
            exit();
        }
        echo '<script>alert("修改失败");window.location.href = document.referrer;</script>';
        exit();
    }

    /**
     * 货币
     *
     * @param Request $request            
     */
    public function currencyLists(Request $request)
    {
        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $code = $request->input('code');
            $value = floatval($request->input('value'));
            if (Currency::add($name, $code, $value)) {
                
                return $this->success('添加成功');
            }
            return $this->error('添加失败');
        } else {
            $data = Currency::paginate(\Config::get('admin.commonPageNum'));
            return view('admin.system.currency', [
                'data' => $data
            ]);
        }
    }

    public function getCurrency(Request $request)
    {
        $id = intval($request->input('id'));
        $data = Currency::getOne($id);
        return \Response::json(array(
            'status' => 1,
            'data' => $data
        ));
    }

    public function updateCurrency(Request $request)
    {
        $name = $request->input('name');
        $code = $request->input('code');
        $value = floatval($request->input('value'));
        $id = intval($request->input('id'));
        if (Currency::updateById($id, $name, $code, $value)) {
            return $this->success('修改成功');
        }
        return $this->error('添加失败');
    }

    public function delCurrency(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (Currency::del($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    /**
     * 地区列表
     */
    public function areaList(Request $request)
    {
        $where = [];
        $name = $request->get('name');
        $area = new Area();
        if ($name)
            $data = $area->where('name_zh_cn', 'like', '%' . $name . '%')->paginate(\Config::get('admin.commonPageNum'));
        else
            $data = $area->paginate(\Config::get('admin.commonPageNum'));
        $all = Area::getAll();
        // echo '<pre>';
        // print_r($all);
        // die;
        $treeList = $all; // array_reverse(self::listToTree($all),1);
                          
        // rsort($treeList);
                          // echo '<pre>';
                          // print_r($treeList);
                          // die();
        return view('admin.system.arealist', [
            'data' => $data,
            'treeList' => $treeList
        ]);
    }

    /**
     * 把返回的数据集转换成Tree
     *
     * @param array $list
     *            要转换的数据集
     * @param string $pid
     *            parent标记字段
     * @return array
     */
    public static function listToTree($list, $pid = 0)
    {
        // 创建Tree
        static $tree = [];
        if (is_array($list)) {
            foreach ($list as $key => $data) {
                if ($data['parent_id'] == $pid) {
                    self::listToTree($list, $data['id']);
                    $tree[] = $data;
                }
            }
        }
        // rsort($tree);
        return $tree;
    }

    public function addArea(Request $request)
    {
        $data = $request->all();
        $pathArr = [];
        $data['path'] = $data['path'] ?: '';
        if (Area::isHasArea($data['name_zh_cn'], $data['name_en_us'])) {
            throw new \Exception('地区已存在');
        }
        // $data['path'] && $pathArr = explode('-', $data['path']);
        // $data['type'] = count($pathArr);
        $data['name_zh_tw']=TransChinese::transToTw( $data['name_zh_cn']);
        $data['name_iata'] = strtoupper($data['name_iata']);
        unset($data['_token']);
        if (Area::add($data)) {
            
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }

    public function getAreaById(Request $request)
    {
        $id = intval($request->input('id'));
        $data = Area::findOrFail($id);
        return \Response::json(array(
            'status' => 1,
            'data' => $data
        ));
    }

    public function updateArea(Request $request)
    {
        $data = $request->all();
        $pathArr = [];
        $data['path'] = $data['path'] ?: '';
        // $data['path'] && $pathArr = explode('-', $data['path']);
        // $data['type'] = count($pathArr);
       // if (Area::isHasArea($data['name_zh_cn'], $data['name_en_us'],)) {
            //throw new \Exception('地区已存在');
       // }
        $data['name_zh_tw']=TransChinese::transToTw( $data['name_zh_cn']);
        $data['name_iata'] = strtoupper($data['name_iata']);
        unset($data['_token']);
        if (Area::updateById($data)) {
            
            return $this->success('修改成功');
        }
        return $this->error('修改失败');
    }

    public function delArea(Request $request)
    {
        $ids = array_filter(array_map('intval', (array) $request->input('id')));
        if (Area::del($ids)) {
            return \Response::json(array(
                'status' => 1,
                'info' => '删除成功'
            ));
        }
        return \Response::json(array(
            'status' => 0,
            'info' => '删除失败'
        ));
    }

    /**
     * FAQ列表
     */
    public function faqList(Requests\Admin\System\AddFaqRequest $request)
    {
        $model = new \App\Models\Faq();
        if ($request->isMethod('POST')) {
            $new = $model::addFaq($request->all());
            if (! $new) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        $searchCdt = $request->all();
        $categoryList = \App\Models\FaqCategory::getAll();
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        list ($list, $count) = $model->getList(($page - 1) * $pageNum, $pageNum, $searchCdt);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::faqList'),
            'query' => $searchCdt
        ]);
        return view('admin.system.faqlist', [
            'list' => $list,
            'paginator' => $paginator,
            'langConf' => config('common.dbLang'),
            'categoryList' => $categoryList,
            'searchCdt' => json_encode($searchCdt)
        ]);
    }

    /**
     * faq详情/修改faq
     */
    public function faq(Requests\Admin\System\EditFaqRequest $request)
    {
        $item = \App\Models\Faq::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            if ($request->input('category_id') != $item->category_id) {
                \App\Models\FaqCategory::findOrFail($request->input('category_id'));
            }
            $item = \App\Models\Faq::editFaq($item, $request->all());
            if (! $item) {
                return $this->error();
            }
            return $this->success();
        }
        $item->content = $item->content ? htmlspecialchars_decode($item->content) : $item->content;
        $item->ctime = \date('Y-m-d H:i:s', $item->ctime);
        return $this->ajaxReturn($item);
    }

    /**
     * 删除faq
     *
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request            
     * @return type
     */
    public function removeFaq(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [
            $request->input('id')
        ];
        if (! \App\Models\Faq::destroy($ids)) {
            return $this->error(trans('admin.operate_fail'));
        } else {
            return $this->success();
        }
    }

    /**
     * faq 分类列表
     *
     * @param Request $request            
     * @return type
     */
    public function faqCategoryList(Requests\Admin\System\AddFaqCategoryRequest $request)
    {
        $model = new \App\Models\FaqCategory();
        if ($request->isMethod('POST')) {
            $new = $model::add($request->all());
            if (! $new) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        $topCategory = $model::getTopCateList();
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        list ($list, $count) = $model->getList(($page - 1) * $pageNum, $pageNum);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::faqCategoryList')
        ]);
        return view('admin.system.faqcatelist', [
            'topCategory' => $topCategory,
            'list' => $list,
            'paginator' => $paginator,
            'langConf' => config('common.dbLang')
        ]);
    }

    /**
     * faq分类详情/修改faq分类
     */
    public function faqcategory(Requests\Admin\System\EditFaqCategoryRequest $request)
    {
        $item = \App\Models\FaqCategory::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $topCategory = $model::getTopCateList();
            if (! in_array($data['parent_id'], $topCategory)) {
                return $this->error('指定的上级分类无效');
            }
            if ($data['parent_id'] == $item->id) {
                return $this->error('不能设置当前分类为自己的上级分类');
            }
            $item = \App\Models\FaqCategory::edit($item, $data);
            if (! $item) {
                return $this->error();
            }
            return $this->success();
        }
        $item->ctime = \date('Y-m-d H:i:s', $item->ctime);
        return $this->ajaxReturn($item);
    }

    /**
     * 删除faq分类
     *
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request            
     * @return type
     */
    public function removeFaqCategory(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [
            $request->input('id')
        ];
        if (\App\Models\faq::whereIn('category_id', $ids)->count()) {
            return $this->error('不能删除含有FAQ的分类');
        }
        if ($parentCheck = \App\Models\faqcategory::whereIn('parent_id', $ids)->lists('parent_id')->all()) {
            return $this->error('请先删除' . implode(',', $parentCheck) . '的子分类');
        }
        if (! \App\Models\faqcategory::destroy($ids)) {
            return $this->error(trans('admin.operate_fail'));
        } else {
            \App\Models\faq::changeCategory($ids, - 1);
            return $this->success();
        }
    }
}
