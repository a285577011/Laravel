<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Extensions\Entrust\EntrustUserTrait;
use Illuminate\Support\Facades\Cache;
use Config;

class AdminUser extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable,
        CanResetPassword,
        EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';
    public $timestamps = false;
    
    protected $cachedRoles = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'ctime'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'phone'];

    /**
     * 定义关系
     */
    public function planner()
    {
        return $this->hasOne('\App\Models\CustomPlanner', 'user_id');
    }

    /**
     * 添加一个后台用户
     * @param array $data
     * @return mixed
     */
    public static function addUser($data)
    {
        try {
            \DB::beginTransaction();
            $newUser = self::create([
                    'username' => $data['username'],
                    'email' => isset($data['email']) && $data['email'] ? $data['email'] : null,
                    'phone' => isset($data['phone']) && $data['phone'] ? $data['phone'] : null,
                    'name' => isset($data['name']) && $data['name'] ? $data['name'] : null,
                    'password' => bcrypt($data['password']),
                    'ctime' => \time()
            ]);
            if ($newUser->id) {
                $newUser->attachRoles($data['userRole']);
                \DB::commit();
                return $newUser;
            } else {
                \DB::rollBack();
                return false;
            }
        } catch (\Exception $exc) {
            \DB::rollBack();
            return false;
        }
    }

    /**
     * 编辑一个后台用户
     * @param object $user
     * @param array $data
     */
    public static function editUser($user, $data)
    {
        try {
            \DB::beginTransaction();
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->password = $data['password'] ? bcrypt($data['password']) : $user->password;
            // 检查用户组人数
            if ($user->system) {
                $oldSysRoles = $user->roles()->where('system', 1)->get()->pluck('id')->all();
                $removedSysRoles = array_diff($oldSysRoles, $data['userRole']);
                if($removedSysRoles) {
                    throw new \Exception('不能移除系统用户的系统角色');
                }
            }
            if ($user->save()) {
                $user->saveRoles($data['userRole']);
                \DB::commit();
                return [true, trans('admin.operate_done')];
            } else {
                \DB::rollBack();
                return [false, trans('admin.operate_fail')];
            }
        } catch (\Exception $exc) {
            \DB::rollBack();
            return [false, $exc->getMessage()];
        }
    }

    /**
     * 获取plannerId
     * @return integer|false
     */
    public function getPlannerId()
    {
        $planner = $this->planner()->first();
        return $planner ? $planner->id : false;
    }

    /**
     * 获取列表
     * @param int $page
     * @param int $pageNum
     * @param array $condition
     * @return array
     */
    public static function getList($page, $pageNum, $condition=[])
    {
        $query = AdminUser::skip($pageNum * ($page - 1))->take($pageNum);
        if (isset($condition['id']) && $condition['id']) {
            $query = $query->where('id', $condition['id']);
        }
        if (isset($condition['username']) && $condition['username']) {
            $query = $query->where('username', 'like', '%'.$condition['username'].'%');
        }
        if (isset($condition['name']) && $condition['name']) {
            $query = $query->where('name', 'like', '%'.$condition['name'].'%');
        }
        return $query->get();
    }

    /**
     * 保存角色信息
     * @param array $inputRoles
     */
    public function saveRoles($inputRoles)
    {
        if (!empty($inputRoles)) {
            $this->roles()->sync($inputRoles);
        } else {
            $this->roles()->detach();
        }
    }

    /**
     * 删除后台用户
     */
    public static function removeUser($ids)
    {
        try {
            // 检查系统用户
            $users = AdminUser::whereIn('id', $ids)->where('system', 1)->get()->toArray();
            if($users)
            {
                return -2;
            }
            return AdminUser::destroy($ids) ? true : -1;
        }  catch (\Exception $e) {
            return -1;
        }
    }

    public static function profile($user, $data)
    {
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = $data['password'] ? bcrypt($data['password']) : $user->password;
        return $user->save();
    }

}
