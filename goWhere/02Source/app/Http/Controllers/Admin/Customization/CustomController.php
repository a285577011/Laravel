<?php

namespace App\Http\Controllers\Admin\Customization;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CustomNeed;
use App\Models\CustomPlanner;
use App\Helpers\Upload;
use App\Models\AdminUser;
use App\Models\CustomCase;
use App\Helpers\Common as CommonHelper;
use App\Helpers\TransChinese;

class CustomController extends Controller
{

    /**
     * 定制游需求列表
     */
    public function needList(Requests\Admin\Custom\NeedListRequest $request)
    {
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        $user = \Auth::user();
//        if ($user->ability('admin', 'custom:handle-need-all')) {
            $planner = $request->input('planner', 0);
//        } else {
//            $planner = $user->getPlannerId();
//        }
        $count = CustomNeed::count();
        $list = CustomNeed::getList($page, $pageNum, $planner);
        return view('admin.customization.needlist', [
            'list' => $list,
            'planners' => CustomPlanner::getPlanners(true),
            'contactConf' => config('customization.contactTime'),
            'statusConf' => config('customization.needStatus'),
            'paginator' => new \Illuminate\Pagination\LengthAwarePaginator(
                $list, $count, $pageNum, $page, ['path' => route('admin::customNeedList')]
            ),
        ]);
    }

    /**
     * 定制游详情
     */
    public function detail(Requests\Common\GetIdRequest $request)
    {
        $need = CustomNeed::findOrFail($request->input('id'));
        if($need->planner_id) {
            CustomNeed::authCheck($need->planner_id, true);
        }
        return view('admin.customization.needdetail', [
            'need' => $need,
            'planners' => CustomPlanner::getPlanners(true),
            'contactConf' => config('customization.contactTime'),
            'statusConf' => config('customization.needStatus'),
            'subjectConf' => config('customization.subject'),
            'hotelConf' => config('customization.hotel'),
            'dinnerConf' => config('customization.dinner'),
            'visaConf' => config('customization.visa'),
            'attendantConf' => config('customization.attendant'),
            'airlineConf' => config('customization.airline'),
            'genderConf' => config('common.gender'),
        ]);
    }

    /**
     * 修改需求处理状态
     */
    public function changeStatus(Requests\Admin\Custom\ChangeStatusRequest $request)
    {
        $need = CustomNeed::findOrFail($request->input('id'));
        $oldStatus = $need->status;
        $need->status = $request->input('status');
        if($need->planner_id) {
            CustomNeed::authCheck($need->planner_id, true);
        }
        if (!$need->save()) {
            return back()->withErrors(trans('admin.operate_fail'));
        }
        \Log::info('User '. \Auth::user()->id . ' changes custom need status from ' . $oldStatus. ' to '.$need->status);
        return back()->with('message', trans('admin.operate_done'));
    }

    /**
     * 添加规划师
     */
    public function addPlanner(Requests\Admin\Custom\AddPlannerRequest $request)
    {
        if ($request->isMethod('POST')) {
            $userId = $request->input('user_id');
            $user = AdminUser::findOrFail($userId);
            if (!$user->ability('admin' , 'custom:handle-need,custom:handle-need-all')) {
                return back()->withErrors(trans('customization.user_no_planner_permission'));
            }
            $uploader = new Upload();
            $avatar = $uploader->saveImage($request->file('avatar'), config('admin.plannerAvatarSize'));
            if (!CustomPlanner::addPlanner($request->all(), $avatar)) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done'));
        }
        return view('admin.customization.editplanner', []);
    }

    /**
     * 规划师列表
     */
    public function plannerList(Request $request)
    {
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        $count = CustomPlanner::count();
        $list = CustomPlanner::skip(($page-1)*$pageNum)->take($pageNum)->orderBy('enable', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.customization.plannerlist', [
            'list' => $list,
            'paginator' => new \Illuminate\Pagination\LengthAwarePaginator(
                $list, $count, $pageNum, $page, ['path' => route('admin::customPlannerList')]
            ),
        ]);
    }

    /**
     * 编辑规划师
     */
    public function editPlanner(Requests\Admin\Custom\EditPlannerRequest $request)
    {
        $planner = CustomPlanner::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $userId = $request->input('user_id');
            $user = AdminUser::findOrFail($userId);
            $inputData = $request->all();
            $msg = '';
            if (!$user->ability('admin' , 'custom:handle-need,custom:handle-need-all')) {
                $inputData['enable'] = 0;
                $msg = '，<b style="color:red;">'.trans('customization.user_no_planner_permission').'，'.trans('customization.set_to_disabled').'</b>';
            }
            $uploader = new Upload();
            $avatar = $uploader->saveImage($request->file('avatar'), config('admin.plannerAvatarSize'));
            if (!CustomPlanner::editPlanner($planner, $inputData, $avatar)) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            return back()->with('message', trans('admin.operate_done').$msg);
        }
        return view('admin.customization.editplanner', [
            'info' => $planner,
        ]);
    }

    /**
     * 删除规划师
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request
     * @return type
     */
    public function removePlanner(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [
            $request->input('id')
        ];
        if (!CustomPlanner::destroy($ids)) {
            return $this->error(trans('admin.operate_fail'));
        } else {
            CustomNeed::changePlanner($ids, 0);
            return $this->success();
        }
    }

    /**
     * 案例列表
     */
    public function caseList(Requests\Admin\Custom\AddCaseRequest $request)
    {
        $model = new \App\Models\CustomCase();
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $image = $uploader->saveImage($request->file('image'), config('admin.customCaseImageSize'));
            $data = $request->all();
            $msg = '';
            $new = $model::add($data, $image);
            if (! $new) {
                return back()->withErrors(trans('admin.add_fail'));
            }
            if(isset($data['createCht']) && $data['createCht']) {
                $data['title'] = TransChinese::transToTw($data['title']);
                $data['content'] = TransChinese::transToTw($data['content']);
                $data['cost'] = TransChinese::transToTw($data['cost']);
                $data['lang'] = 2;
                if($model::add($data, $image)) {
                    $msg = '，自动添加繁体中文版本成功';
                }
            }
            return back()->with('message', trans('admin.operate_done').$msg);
        }
        $searchCdt = $request->all();
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        list ($list, $count) = $model->getList(($page - 1) * $pageNum, $pageNum, $searchCdt);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($list, $count, $pageNum, $page, [
            'path' => route('admin::customCaseList'),
            'query' => $searchCdt
        ]);
        return view('admin.customization.caselist', [
            'list' => $list,
            'paginator' => $paginator,
            'langConf' => config('common.dbLang'),
            'langK2VConf' => array_flip(config('common.dbLang')),
            'searchCdt' => json_encode($searchCdt)
        ]);
    }

    /**
     * 案例详情/修改案例
     */
    public function customCase(Requests\Admin\Custom\EditCaseRequest $request)
    {
        $item = \App\Models\CustomCase::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $uploader = new \App\Helpers\Upload();
            $image = $uploader->saveImage($request->file('image'), config('admin.customCaseImageSize'));
            $item = \App\Models\CustomCase::edit($item, $request->all(), $image);
            if (! $item) {
                return $this->error();
            }
            return $this->success();
        }
        $item->content = $item->content ? htmlspecialchars_decode($item->content) : $item->content;
        $item->imageUrl = asset(CommonHelper::getStoragePath($item->image));
        return $this->ajaxReturn($item);
    }

    /**
     * 删除案例
     *
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request            
     * @return type
     */
    public function removeCase(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [
            $request->input('id')
        ];
        if (! \App\Models\CustomCase::destroy($ids)) {
            return $this->error(trans('admin.operate_fail'));
        } else {
            return $this->success();
        }
    }

}
