<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberController extends Controller
{
    protected $user;
    
    public function __construct()
    {
        $this->user = \Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberList(Request $request)
    {
        $this->validate($request, [
            'username' => 'string|max:30',
            'phone' => 'cnphone',
            'email' => 'email|max:255',
        ]);
        $searchCdt = $request->all();
        $page = $request->input('page', 1);
        $pageNum = config('admin.commonPageNum');
        list($list,$count) = Member::getList(($page - 1) * $pageNum, $pageNum, $searchCdt);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $list, $count, $pageNum, $page,
            [
                'path' => route('admin::memberList'),
                'query' => $searchCdt,
            ]
        );
        return view('admin.system.memberlist', [
            'list'=>$list,
            'activeStatusConf'=> config('common.activeStatus'),
            'verifyStatusConf'=> config('common.verifyStatus'),
            'paginator' => $paginator,
            'searchCdt' => json_encode($searchCdt),
        ]);
    }

    /**
     * 用户详情页
     * @param \App\Http\Requests\Admin\System\EditMemberRequest $request
     */
    public function member(Requests\Admin\System\EditMemberRequest $request)
    {
        $info = Member::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            if(!$this->user->ability('admin' , 'member:item-detail-edit')) {
                return back()->withErrors(trans('admin.permission_denied'));
            }
            $info = Member::editMember($info, $request->all());
            if (!$info) {
                return back()->withErrors(trans('admin.operate_fail'));
            }
            \Log::info('User '. \Auth::user()->id . ' edit member ' . $info->id);
            return back()->with('message', trans('admin.operate_done'));
        }
        return view('admin.system.member', [
            'info'=>$info,
            'isAdmin' => \Entrust::hasRole('admin'),
        ]);
    }

}
