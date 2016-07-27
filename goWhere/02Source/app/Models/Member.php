<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Event;
use App\Events\UploadsChanged;

class Member extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'phone', 'ctime'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'phone', 'salt'];

    /**
     * 定义与social_connect表的对应关系
     */
    public function socialConnect()
    {
        return $this->hasMany('\App\Models\SocialConnect', 'member_id');
    }

    /**
     * 修改前台用户
     * @param int $member
     * @param array $data
     * @return mixed
     */
    public static function editMember($member, $data, $avatar=false)
    {
        isset($data['username']) ? $member->username = $data['username'] : '';
        isset($data['nickname']) ? $member->nickname = $data['nickname'] : '';
        if(config('app.isBackend')!==true || \Entrust::hasRole('admin')) {
            isset($data['email']) ? $member->email = $data['email'] : '';
            isset($data['phone']) ? $member->phone = $data['phone'] : '';
            if (isset($data['password']) && $data['password']) {
                $member->password = bcrypt($data['password']);
                $member->password_score = \App\Helpers\Password::getPasswordRank($data['password'], true);
                $member->type = 0;
            }
        }
        isset($data['name']) ? $member->name = $data['name'] : '';
        isset($data['mobile_verify']) ? $member->mobile_verify = $data['mobile_verify'] : '';
        isset($data['email_verify']) ? $member->email_verify = $data['email_verify'] : '';
        isset($data['active']) ? $member->active = $data['active'] : '';
        isset($data['gender']) ? $member->gender = $data['gender'] : '';
        $oldAvatar = $member->avatar;
        if ($avatar && $avatar['path']) {
            $member->avatar = $avatar['path'];
        }
        if($member->save()) {
            Event::fire(new UploadsChanged($oldAvatar, $member->avatar));
            return $member;
        }
        return false;
    }

    /**
     * 修改邮箱绑定状态
     * @param obj $member
     * @param type $status
     * @return boolean
     */
    public static function setEmailVerified($member, $status=true)
    {
        $member->email_verify = $status ? 1 : 0;
        if($member->save()) {
            return $member;
        }
        return false;
    }
    public static function getUserNameById($uid){
        
        return self::where(['id'=>$uid])->value('username');
    }

    /**
     * 获取列表
     * @param int $skip
     * @param int $num
     * @param array $searchCdt 搜索条件
     */
    public static function getList($skip, $num, $searchCdt)
    {
        $builder = new static;
        $query = $builder->newQuery();
        if (isset($searchCdt['username']) && $searchCdt['username']!=='') {
            $query->where(function($q) use($searchCdt) {
                $q->where('username', 'like', '%'.$searchCdt['username'].'%')
                    ->orWhere('name', 'like', '%'.$searchCdt['username'].'%')
                    ->orWhere('nickname', 'like', '%'.$searchCdt['username'].'%');
            });
        }
        if (isset($searchCdt['email']) && $searchCdt['email']!=='') {
            $query->where('email', $searchCdt['email']);
        }
        if (isset($searchCdt['phone']) && $searchCdt['phone']!=='') {
            $query->where('phone', $searchCdt['phone']);
        }
        $count = $query->count();
        $list = $query->skip($skip)->take($num)->get();
        return [$list, $count];
    }

}
