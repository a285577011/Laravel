<?php

namespace App\Http\Controllers\Auth;

use App\Models\Member;
use App\Models\SocialConnect;
use Validator;
use Socialite;
use App\Http\Controllers\Controller;
use App\Traits\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\Register;
use App\Helpers\Email;

class AuthController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    // 认证成功的跳转路径
    protected $redirectPath = '/';
    // 认证失败的跳转路径
    protected $loginPath = '/auth/login';
    // 登录表单的用户名字段
    protected $username = 'identity';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout','confirm','confirmEmail', 'redirectToProvider', 'handleProviderCallback']]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
                'username' => ['required', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:members'],
                'email' => 'required|email|max:255|unique:members',
                'phone' => 'required|string|cnphone|unique:members',
                'password' => 'required|confirmed|min:6|max:20|password',
                'captcha' => 'required|captcha',
                'smsCaptcha' => 'required|smsCaptcha',
        ]);
    }

    /**
     * 通过手机注册
     */
    public function registerByPhone(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'username' => ['required', 'min:4', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:members'],
                'phone' => 'required|string|cnphone|unique:members',
                'password' => 'required|confirmed|min:6|max:20|password',
                'smsCaptcha' => 'required|smsCaptcha:' . $request->input('phone'),
            ]);
            $result = $this->create($request->all());
            if ($result) {
                Auth::login($result);
                return view('auth.registered');
            }
            return $this->error();
        }
        return view('auth.register-phone');
    }

    /**
     * 通过邮箱注册
     */
    public function registerByEmail(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'username' => ['required', 'min:4', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:members'],
                'email' => 'required|email|max:255|unique:members',
                'password' => ['required', 'confirmed', 'min:6', 'max:20', 'password'],
                'captcha' => 'required|captcha',
            ]);
            $result = $this->create($request->all());
            if ($result) {
                Auth::login($result);
                Email::sendRegisterConfirmMail($result);
                return $this->ajaxReturn(['url' => Register::getLoginAddr($request->input('email'))], 0);
            }
            return $this->error();
        }
        return view('auth.register-email');
    }

    /**
     * 邮箱确认（注册）
     * @param Request $request
     * @return
     */
    public function confirm(Requests\Auth\EmailConfirmRequest $request)
    {
        $expire = config('member.registerConfirmMail.expire');
        $token = Email::getTokenRepository($expire);
        $member = Member::where('email', $request->input('email'))->first();
        if (!$member || ! $token->exists($member, $request->input('token'), config('member.emailTokenType.register'))) {
            return $this->error(trans('message.confirm_url_invalid'), '/errors/error');
        }
        Member::setEmailVerified($member);
        return view('auth.registered');
    }

    /**
     * 邮箱确认（修改邮箱）
     * @param Request $request
     * @return
     */
    public function confirmEmail(Requests\Auth\EmailConfirmRequest $request)
    {
        $expire = config('member.changeEmailConfirmMail.expire');
        $token = Email::getTokenRepository($expire);
        $member = Member::where('email', $request->input('email'))->first();
        if (!$member || ! $token->exists($member, $request->input('token'), config('member.emailTokenType.modify'))) {
            return $this->error(trans('message.confirm_url_invalid'), '/errors/error');
        }
        Member::setEmailVerified($member);
        return view('common.success', [
            'msg' => trans('message.email_confirmed'),
            'url' => url('/',null, false),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $member = new Member();
        $member->username = $data['username'];
        $member->email = isset($data['email']) && $data['email'] ? $data['email'] : null;
        $member->phone = isset($data['phone']) && $data['phone'] ? $data['phone'] : null;
        $member->password = bcrypt($data['password']);
        $member->ctime = \time();
        $member->atime = \time();
        $member->password_score = \App\Helpers\Password::getPasswordRank($data['password'], true);
        return $member->save() ? $member : false;
    }

    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * OAuth授权回调
     * @param string $driver
     */
    public function handleProviderCallback($driver)
    {
        $user = Socialite::driver($driver)->user();
        $driverType = config('member.oauthType.'.$driver, null);
        if(!$driverType) {
            abort(500);
        }
        $openid = $user->getId();
        $connection = SocialConnect::getUserToken($openid, $driverType);
        if(!$connection) {
            $connection = SocialConnect::addUserToken($user, $driverType);
        }
        // 保存信息
        session([
            'oauthLogin' => [
                'token' => $user->token,
                'openid' => $openid,
                'expire' => $user->accessTokenResponseBody['expires_in'] + time(),
                'screen_name' => $user->getNickname(),
                'type' => $driverType,
            ]
        ]);
        if(!$connection->member_id) {
            // 要求注册或绑定
            return $this->bindOrRegister($connection);
        } else {
            // 登录绑定的用户
            $member = $connection->member()->first();
            return $this->oauthLogin($member);
        }
        
    }

    /**
     * 将当前用户与第三方账号绑定，或提示创建新账户
     */
    protected function bindOrRegister($connection)
    {
        if(Auth::check()) {
            $currenUser = \Auth::user();
            $connection->member_id = $currenUser->id;
            if($connection->save()) {
                return view('common.success', [
                    'msg' => trans('message.oauth_account_binded'),
                    'url' => url('/',null, false),
                ]);
            }
            return $this->error(trans('message.oauth_account_bind_fail'), 'errors/error');
        } else {
            return view('auth.ouath-login');
        }
    }

    /**
     * 绑定账户
     * @param Requests $request
     * @return type
     */
    protected function bindAccount()
    {
        $oauthSession = session()->get('oauthLogin', null);
        if(isset($oauthSession['token']) && $oauthSession['token']) {
            $connection = SocialConnect::getUserToken($oauthSession['openid'], $oauthSession['type']);
            if(!$connection) {
                return $this->error(trans('message.oauth_account_bind_fail'), 'errors/error');
            }
            if($connection->member_id) {
                return $this->error(trans('message.oauth_account_already_binded'), 'errors/error');
            }
            $connection->member_id = \Auth::user()->id;
            if($connection->save()) {
                return $this->success(trans('message.oauth_account_binded'));
            }
        }
        return $this->error(trans('message.oauth_account_bind_fail'), 'errors/error');
    }

    /**
     * 登录oauth绑定的用户
     * @param obj $member
     * @return type
     */
    protected function oauthLogin($member) {
        if(Auth::check()) {
            $currenUser = \Auth::user();
            if($currenUser->id != $member->id) {
                // 注销当前用户
                Auth::logout();
                // 用绑定的身份重新登录
                Auth::login($member);
            }
            return request()->ajax() ? $this->success() : redirect()->intended($this->redirectPath());
        }
        Auth::login($member);
        return request()->ajax() ? $this->success() : redirect()->intended($this->redirectPath());
    }

    /**
     * 登录操作
     * @param \App\Http\Controllers\Auth\Request $request
     * @return type
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
            'remember' => 'boolean',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->input('remember',0))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return $request->ajax() ? $this->error($this->getFailedLoginMessage()) : redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
        
        if($request->input('bind', null)) {
            return $this->bindAccount();
        }

        return $request->ajax() ? $this->success() : redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return \Illuminate\Support\Facades\Lang::has('common.login_failed')
                ? \Illuminate\Support\Facades\Lang::get('common.login_failed')
                : 'These credentials do not match our records.';
    }

    /**
     * 登录字段
     * @return type
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * 判断用户使用何种方式登录：邮箱/手机/用户名
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        $loginUserName = $this->loginUsername();
        $newLoginUserName = '';
        $credentials = $request->only($loginUserName, 'password');
        if (strpos($credentials[$loginUserName], '@') !== false) {
            $newLoginUserName = 'email';
        } elseif (preg_match('/^[0-9]+$/', $credentials[$loginUserName])) {
            $newLoginUserName = 'phone';
        } else {
            $newLoginUserName = 'username';
        }
        if ($newLoginUserName !== $loginUserName) {
            $credentials[$newLoginUserName] = $credentials[$loginUserName];
            unset($credentials[$loginUserName]);
        }
        return $credentials;
    }

    /**
     * 注册操作
     */
    public function postRegister(Request $request)
    {
        abort(403);
    }

}
