<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialConnect extends Model
{

    protected $table = 'social_connect';
    
    public $timestamps = false;

    /**
     * 定义与members表的对应关系
     */
    public function member()
    {
        return $this->belongsTo('\App\Models\Member', 'member_id');
    }

    /**
     * 添加记录
     * @param object $user
     * @param int $type
     * @return boolean|\App\Models\SocialConnect
     */
    public static function addUserToken($user, $type)
    {
        $new = new SocialConnect();
        $new->platform_type = $type;
        $new->openid = $user->getId();
        $new->token = $user->token;
        if($new->save()) {
            return $new;
        }
        return false;
    }

    /**
     * 获取记录
     * @param string $openid
     * @param int $type
     * @return object
     */
    public static function getUserToken($openid, $type)
    {
        return self::where('openid', $openid)->where('platform_type', $type)->first();
    }

}
