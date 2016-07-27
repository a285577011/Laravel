<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Common as CommonHelper;
use App\Helpers\Upload;
use App\Models\Orders;
use App\Helpers\Password as PasswordHelper;
use App\Models\Member;
use App\Helpers\Email;

class MemberController extends Controller
{

    protected $member;

    public function __construct()
    {
        $this->middleware('auth');
        $this->member = \Auth::user();
    }

    /**
     * 用户中心首页
     */
    public function index()
    {
        $user = $this->member;
        // 我的订单
        $orderNum = config('member.memberOrderNum');
        list($count, $list) = Orders::getUserOrder($user->id, 1, $orderNum);
        list($orderItems, $orderImages) = Orders::getOrderItems($list);
        return view('member.index', [
            'member' => $user,
            'orders' => $list,
            'orderItems' => $orderItems,
            'orderImages' => $orderImages,
        ]);
    }

    /**
     * 修改个人信息
     */
    public function changeInfo(Requests\Member\ChangeInfoRequest $request)
    {
        $uploader = new Upload();
        $avatar = $uploader->saveImage($request->file('avatar'), config('member.avatarSize'));
        if (isset($avatar['error']) && $avatar['error']) {
            return $this->error($avatar['errorMsg']);
        }
        $member = Member::editMember($this->member, [
            'nickname' => $request->input('nickname', ''),
            'name' => $request->input('name', ''),
            'gender' => $request->input('gender', 1),
        ], $avatar);
        if($member) {
            return back();
//            return $this->ajaxReturn([
//                'avatar'=>$member->avatar ? : config('common.memberDefaultAvatar'),
//                'nickname' => $member->nickname,
//                'gender' => $member->gender,
//                'name' => $member->name,
//            ], 0, trans('message.successfully_modified'));
        }
        return $this->error();
    }

    /**
     * 账号设置页
     * @return
     */
    public function account()
    {
        $maskPhone = $this->member->phone ? CommonHelper::maskPhone($this->member->phone) : '';
        $maskEmail = $this->member->email ? CommonHelper::maskEmail($this->member->email) : '';
        $passInfo = PasswordHelper::getPasswordRankByScore($this->member->password_score);
        $changePhoneStep = (!$this->member->mobile_verify || CommonHelper::checkCanDo('changePhone')) ? 2 : 1;
        return view('member.account', [
            'member' => $this->member,
            'genderConf' => config('common.gender'),
            'maskPhone' => $maskPhone,
            'maskEmail' => $maskEmail,
            'passInfo' => $passInfo,
            'changePhoneStep' => $changePhoneStep,
            'userToken' => md5($this->member->id),
        ]);
    }

    /**
     * 修改密码
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:20|password', //password_confirmation
        ]);
        if (!PasswordHelper::checkUserPassword($this->member, $request->input('old_password'))) {
            return $this->error(trans('message.invalid_password'));
        }
        $member = Member::editMember($this->member, ['password' => $request->input('password')]);
        if ($member) {
            $passInfo = PasswordHelper::getPasswordRankByScore($member->password_score);
            $passInfo['status'] = $passInfo['score'] < 10 ? 0 : 1;
            return $this->ajaxReturn(
                    $passInfo, 0, trans('message.password_changed'));
        }
        return $this->error();
    }

    /**
     * 修改邮箱
     * @param Request $request
     * @return
     */
    public function changeEmail(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'email' => 'required|email|max:255|unique:members,email,'.$this->member->id,
        ]);
        if (!PasswordHelper::checkUserPassword($this->member, $request->input('old_password'))) {
            return $this->error(trans('message.invalid_password'));
        }
        $email = $request->input('email');
        if ($email !== $this->member->email) {
            $member = Member::editMember($this->member, [
                    'email' => $request->input('email'),
                    'email_verify' => 0,
            ]);
            if ($member) {
                Email::sendEmailChangeConfirmMail($member);
                return $this->ajaxReturn(
                        [
                            'email' => CommonHelper::maskEmail($member->email),
                            'text' => trans('member.email_await_confirm'),
                            'status' => 0,
                        ], 0, trans('message.email_changed_need_confirm')
                );
            }
            return $this->error();
        }
        return $this->error(trans('message.email_unchanged'));
    }

    /**
     * 修改手机
     * @param Request $request
     * @return type
     */
    public function changePhone(Request $request)
    {
        $step = $request->route('step');
        if ($step == 1) {
            return $this->changePhoneStep1($request);
        }
        return $this->changePhoneStep2($request);
    }

    /**
     * 修改手机 Step1 验证旧手机
     * @param obj $request
     * @return
     */
    protected function changePhoneStep1($request)
    {
        $this->validate($request, [
            'smsCaptcha' => 'required|smsCaptcha'
        ]);
        CommonHelper::setCanDoSession('changePhone');
        return $this->success(null);
    }

    /**
     * 修改手机 Step2 验证并修改新手机
     * @param obj $request
     * @return
     */
    protected function changePhoneStep2($request)
    {
        $this->validate($request, [
            'phone' => 'required|cnphone|unique:members',
            'smsCaptcha' => 'required|smsCaptcha:' . $request->input('phone')
        ]);
        if ($this->member->mobile_verify && !CommonHelper::checkCanDo('changePhone')) {
            return $this->error(trans('message.timeout_need_reverify'), url('member/account'));
        }
        $phone = $request->input('phone');
        if($phone==$this->member->phone) {
            return $this->error(trans('message.phone_unchanged'));
        }
        $member = Member::editMember($this->member, [
                'phone' => $phone,
                'phone_verify' => 1,
        ]);
        if ($member) {
            CommonHelper::removeCanDoSession('changePhone');
            return $this->ajaxReturn(
                [
                    'phone' => CommonHelper::maskPhone($member->phone),
                    'status' => 1
                ], 0, trans('message.phone_changed')
            );
        }
        return $this->error();
    }

}
