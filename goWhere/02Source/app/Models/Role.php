<?php namespace App\Models;

use App\Extensions\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];
    
    protected $cachedPermissions = null;

    /**
     * 添加一个后台角色
     * @param object $request
     * @return mixed
     */
    public static function addRole($data)
    {
        $new = self::create([
            'name' => $data['name'],
            'display_name' => $data['display_name'],
            'description' => isset($data['description']) ? $data['description'] : '',
        ]);
        return $new->id ? $new : false;
    }

    /**
     * 获取当前角色拥有的权限id数组
     * @return array
     */
    public function getRolePemissonIds()
    {
        $permissions = $this->cachedPermissions();
        return $permissions->pluck('id')->all();
    }

    /**
     * 编辑角色
     * @param obj $role
     * @param array $data
     */
    public static function editRole($role, $data)
    {
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        return $role->save();
    }

    /**
     * 获取角色列表
     * @param int $page
     * @param int $pageNum
     * @return array
     */
    public static function getList($page, $pageNum)
    {
        $roles = Role::skip($pageNum * ($page - 1))->take($pageNum)->get();
        return $roles;
    }

}