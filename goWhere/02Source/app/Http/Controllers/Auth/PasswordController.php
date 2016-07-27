<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Helpers\Common as CommonHelper;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Helpers\Email;
use App\Helpers\Register;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 找回密码首页 Step 1
     */
    public function index(Request $request)
    {
        return view('auth.password', [
            'step' => 1,
        ]);
    }

    /**
     * 找回密码-找回方式 Step 2
     */
    public function postRetrieve(Request $request)
    {
        $identity = $request->input('identity', '');
        $type = strpos($identity, '@') === false ? 2 : 1; // 1 通过邮箱找回, 2 通过手机找回
        $this->validate($request, [
            'identity' => $type === 1 ? 'required|email|max:255' : 'required|cnphone',
            'captcha' => 'required|captcha',
        ]);
        if($type === 1) {
            return $this->retrieveByEmail($identity);
        }
        // 通过手机重置
        $member = Member::where('phone', $identity)->first();
        if(!$member) {
            return redirect('/auth/password/1')->withErrors(['identity'=>trans('message.member_no_exist')]);
        }
        $session = session()->put('orangewayRetrieve', [
            'identity' => $identity,
            'type' => $type,
        ]);
        return view('auth.password-phone', [
            'step' => 2,
            'type' => $type,
            'identity' => $identity
        ]);
    }

    /**
     * 找回密码-找回方式 Step 2
     */
    public function getRetrieve(Request $request)
    {
        $session = $request->session()->get('orangewayRetrieve');
        if (!isset($session['identity']) || !$session['identity']) {
            return redirect('auth/password/1');
        }
        return view('auth.password-phone', [
            'step' => 2,
            'type' => $session['type'],
            'identity' => $session['identity'],
        ]);
    }

    /**
     * 通过邮箱重置 Step 2
     */
    public function retrieveByEmail($email)
    {
        $member = Member::where('email', $email)->first();
        if (!$member) {
            return redirect('auth/password/1')->withErrors(['identity'=>trans('message.member_no_exist')]);
        }
        if ($member && ! $member instanceof CanResetPasswordContract) {
            throw new UnexpectedValueException('User must implement CanResetPassword interface.');
        }
        if (!$member->email_verify) {
            return redirect('auth/password/1')->withErrors(['identity'=>trans('message.member_email_not_verified')]);
        }
        Email::sendResetPasswordMail($member);
        return view('auth.password-email', [
                    'step' => 2,
                    'type' => 1,
                    'identity' => $email,
                    'mailLogin' => Register::getLoginAddr($email),
                ]);
    }

    /**
     * 重置密码-Email Step 3
     */
    public function resetForm(Request $request)
    {
        $token = $request->route('token');
        if(!$token) {
            throw new NotFoundHttpException;
        }
        return view('auth.password-reset', [
            'step' => 3,
            'type' => 1,
            'token' => $token,
        ]);
    }

    /**
     * 重置密码-Email Step 4
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6|max:20|password',
        ]);
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $member = Member::where('email', $credentials['email'])->first();
        if ($member && ! $member instanceof CanResetPasswordContract) {
            throw new UnexpectedValueException('User must implement CanResetPassword interface.');
        }
        if (!$member) {
            return redirect('auth/password/resetForm/'.$credentials['token'])->withErrors(['email'=>trans('message.member_no_exist')]);
        }
        $expire = config('auth.password.expire');
        $tokenRepo = Email::getTokenRepository($expire);
        if (! $tokenRepo->exists($member, $credentials['token'])) {
            return $this->error(trans('message.reset_link_expried'), '/errors/error');
        }
        if(Member::editMember($member, ['password' => $credentials['password']])) {
            $tokenRepo->delete($credentials['token']);
            return view('auth.password-rested', [
                'step' => 4,
            ]);
        }
        return $this->error(trans('message.fail_retry_later'), '/errors/error');
    }

    /**
     * 重置密码-Phone Step 3
     * @param Request $request
     */
    public function resetFormByPhone(Request $request)
    {
        $session = $request->session()->get('orangewayRetrieve');
        $phone = isset($session['identity']) && $session['identity'] ? $session['identity'] : 0;
        if(!$phone)
        {
            return $this->error('message.illegal_operation', '/errors/error');
        }
        $this->validate($request, [
            'smsCaptcha' => 'required|smsCaptcha:' . $phone
        ]);
        CommonHelper::setCanDoSession('retrieveByPhone');
        return view('auth.password-reset', [
            'step' => 3,
            'type' => 2,
        ]);
    }

    /**
     * 重置密码-Phone Step 4
     */
    public function postResetByPhone(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|max:20|password',
        ]);
        $session = $request->session()->get('orangewayRetrieve');
        $identity = isset($session['identity']) ? $session['identity'] : '';
        // 检查权限
        if(empty($identity) || !CommonHelper::checkCanDo('retrieveByPhone')) {
            // 清除权限
            $request->session()->forget('orangewayRetrieve');
            CommonHelper::removeCanDoSession('retrieveByPhone');
            return $this->alert(trans('message.timeout_need_reverify'), '/auth/password/1');
        }
        $password = $request->input('password');
        $result = Member::where('phone', $identity)->update([
            'password' => bcrypt($password),
            'password_score' => \App\Helpers\Password::getPasswordRank($password, true),
            'type' => 0,
        ]);
        if($result) {
            // 清除权限
            $request->session()->forget('orangewayRetrieve');
            CommonHelper::removeCanDoSession('retrieveByPhone');
            return view('auth.password-rested', [
                'step' => 4,
            ]);
        }
        return $this->error(trans('message.fail_retry_later'), '/errors/error');
    }

}
