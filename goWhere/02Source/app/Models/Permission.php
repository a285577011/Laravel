<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    /**
     * 添加一个后台权限
     * @param object $request
     * @return mixed
     */
    public static function addPermission($request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        return $permission->save() ? $permission : false;
    }

    /**
     * 返回权限列表并按组分类
     * @return type
     */
    public static function getGroupedPermissions()
    {
        $list = Permission::all()->groupBy(function ($item, $key) {
            return strstr($item['name'], ':', true);
        });
        return $list->all();
    }

}
