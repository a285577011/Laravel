<?php

namespace App\Helpers;

use Event;
use App\Events\EmailNeedToBeSent;
use App\Repository\DatabaseTokenRepository as DbRepository;
use DB;

/**
 * Description of Email
 *
 * @author wangw
 */
class Email
{

    /**
     * 发送注册确认邮件
     * @param obj $member 用户实例
     * @param boolean $now 是否立刻发送
     * @return
     */
    public static function sendRegisterConfirmMail($member, $now = false)
    {
        $config = config('member.registerConfirmMail');
        $to = $member->email; //收件人
        $view = 'emails.register-confirm'; //模版
        $subject = trans($config['subject']); //主题
        $expire = $config['expire']; //token有效期
        $type = config('member.emailTokenType.register'); //token类型
        $tokenResp = static::getTokenRepository($expire);
        $token = $tokenResp->create($member, $type); //生成token
        $data = [
            'name' => $member->username,
            'url' => url('auth/confirm', ['email'=>$member->email,'token' => $token])
        ];
        if ($now) {
            return static::sendNow($to, $view, $subject, $data);
        }
        return static::sendQueue($to, $view, $subject, $data);
    }

    /**
     * 发送修改邮箱确认邮件
     * @param obj $member 用户实例
     * @param boolean $now 是否立刻发送
     * @return
     */
    public static function sendEmailChangeConfirmMail($member, $now = false)
    {
        $config = config('member.changeEmailConfirmMail');
        $to = $member->email; //收件人
        $view = 'emails.change-email'; //模版
        $subject = trans($config['subject']); //主题
        $expire = $config['expire']; //token有效期
        $type = config('member.emailTokenType.modify'); //token类型
        $tokenResp = static::getTokenRepository($expire);
        $token = $tokenResp->create($member, $type); //生成token
        $data = [
            'name' => $member->username,
            'url' => url('auth/confirm/mail', ['email'=>$member->email,'token' => $token])
        ];
        if ($now) {
            return static::sendNow($to, $view, $subject, $data);
        }
        return static::sendQueue($to, $view, $subject, $data);
    }

    /**
     * 发送密码重置邮件
     * @param obj $member 用户实例
     * @param boolean $now 是否立刻发送
     * @return
     */
    public static function sendResetPasswordMail($member, $now = false)
    {
        $config = config('auth.password');
        $to = $member->email; //收件人
        $view = $config['email']; //模版
        $subject = trans($config['subject']); //主题
        $expire = $config['expire']; //token有效期
        $type = config('member.emailTokenType.retrieve'); //token类型
        $tokenResp = static::getTokenRepository($expire);
        $token = $tokenResp->create($member, $type); //生成token
        $data = [
            'url' => url('auth/password/resetForm/'.$token),
        ];
        if ($now) {
            return static::sendNow($to, $view, $subject, $data);
        }
        return static::sendQueue($to, $view, $subject, $data);
    }

    /**
     * 获取一个DatabaseTokenRepository实例
     * @param int $expire token过期时间(分钟)
     * @return DbRepository
     */
    public static function getTokenRepository($expire)
    {
        $repository = new DbRepository(DB::connection(), config('auth.password.table'), config('app.key'), $expire);
        return $repository;
    }

    /**
     * 立即发送
     */
    protected static function sendNow($to, $view, $subject, $content, $sender = null)
    {
        $event = (object) ['to' => $to, 'view' => $view, 'subject' => $subject, 'content' => $content, 'sender' => $sender];
        Mail::send($event->view, $event->content, function ($message) use($event) {
            if ($event->sender) {
                $message->from($event->sender['address'], $event->sender['name']);
            }
            $message->to($event->to);
            $message->subject($event->subject);
        });
    }

    /**
     * 触发事件队列
     * @return
     */
    protected static function sendQueue($to, $view, $subject, $content, $sender = null)
    {
        $event = new EmailNeedToBeSent($to, $view, $subject, $content, $sender);
        return Event::fire($event);
    }

}
