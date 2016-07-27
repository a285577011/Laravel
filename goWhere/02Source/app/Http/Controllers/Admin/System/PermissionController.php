<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Permission;
use App\Models\AdminUser;
use App\Models\Role;

class PermissionController extends AdminController
{

    /**
     * 后台用户列表
     * @return \Illuminate\Http\Response
     */
    public function userList(Request $request)
    {
        $this->validate($request, [
            'page' => 'intval|min:1',
        ]);
        $page = $request->input('page', 1);
        $pageNum = \Config::get('admin.commonPageNum');
        $list = AdminUser::getList($page, $pageNum);
        $count = AdminUser::count();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $list, $count, $pageNum, $page,
            ['path' => route('admin::editUser')]
        );
        return view('admin.system.userlist', [
            'list' => $list,
            'count' => $count,
            'paginator' => $paginator,
        ]);
    }

    /**
     * 添加一个后台用户
     * @param Request $request
     * @return type
     * @throws Exception
     */
    public function addUser(Requests\Admin\System\AddUserRequest $request)
    {
        if ($request->isMethod('POST')) {
            $newUser = AdminUser::addUser($request->all());
            if (!$newUser) {
                return $this->error(trans('admin.add_fail'));
            }
            return $this->success();
        }
        $roles = Role::get();
        return view('admin.system.adduser', [
            'roles' => $roles,
        ]);
    }

    /**
     * 修改一个后台用户
     */
    public function editUser(Requests\Admin\System\EditUserRequest $request)
    {
        $user = AdminUser::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            list($result, $msg) = AdminUser::editUser($user, $request->all());
            if (!$result) {
                return $this->error($msg);
            }
            return $this->success(trans('admin.operate_done'));
        }
        $userRoleIds = $user->roles()->get()->pluck('id')->all();
        $roles = Role::get();
        return view('admin.system.adduser', [
            'info' => $user,
            'roles' => $roles,
            'userRoleIds'=>$userRoleIds,
        ]);
    }

    /**
     * 删除后台用户
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request
     */
    public function removeUser(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [$request->input('id')];
        $result = AdminUser::removeUser($ids);
        if ($result!==true) {
            return $this->error($result == -2 ? '不能删除系统用户': trans('admin.operate_fail'));
        } else {
            return $this->success();
        }
    }

    /**
     * 角色列表
     */
    public function roleList(Request $request)
    {
        $this->validate($request, [
            'page' => 'intval|min:1',
        ]);
        $count = Role::count();
        $page = $request->input('page', 1);
        $pageNum = \Config::get('admin.commonPageNum');
        $list = Role::getList($page, $pageNum);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $list, $count, $pageNum, $page,
            ['path' => route('admin::roleList')]
        );
        return view('admin.system.rolelist', [
            'list' => $list,
            'paginator' => $paginator,
        ]);
    }

    /**
     * 添加后台角色
     * @param Request $request
     * @return object
     * @throws Exception
     */
    public function addRole(Requests\Admin\System\AddRoleRequest $request)
    {
        if ($request->isMethod('POST')) {
            $new = Role::addRole($request->all());
            if (!$new) {
                return $this->error(trans('admin.operate_fail'));
            }
            return $this->success();
        }
    }

    /**
     * 删除角色
     * @param \App\Http\Requests\Common\GetIdArrayRequest $request
     */
    public function removeRole(Requests\Common\GetIdArrayRequest $request)
    {
        $ids = $request->isMethod('POST') ? $request->input('id') : [$request->input('id')];
        // 禁止删除系统角色
        $systemIds = Role::where('system', 1)->lists('id')->all();
        $filterIds = array_diff($ids, $systemIds);
        if (empty($filterIds) || !Role::destroy($filterIds)) {
            return $ids===$filterIds ? $this->error(trans('admin.operate_fail'))
                : $this->error('系统角色禁止删除');
        } else {
            return $this->success();
        }
    }

    /**
     * 修改角色
     */
    public function editRole(Requests\Admin\System\AddRoleRequest $request)
    {
        $role = Role::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            if ($role->system) {
                return $this->error(trans('admin.cannot_modify_system_role'));
            }
            if (!Role::editRole($role, $request->all())) {
                return $this->error(trans('admin.operate_fail'));
            }
            return $this->success();
        }
        return $this->ajaxReturn($role);
    }

    /**
     * 添加一个后台权限
     * @return \Illuminate\Http\Response
     */
    public function addPermissions(Requests\Admin\System\AddPermissionRequest $request)
    {
        if ($request->isMethod('POST')) {
            $new = Permission::addPermission($request);
            if (!$new) {
                throw \Exception(trans('admin.add_fail'));
            }
            return $new;
        }
        return view('admin.system.addpermission');
    }

    /**
     * 分配权限给角色
     * @return type
     * @throws Exception
     */
    public function grantPermission(Requests\Admin\System\GrantPermissionRequest $request)
    {
        $role = Role::findOrFail($request->input('id'));
        if ($request->isMethod('POST')) {
            $grant = $role->savePermissions($request->input('permissions'));
            return $this->success();
        }
        $owned = $role->getRolePemissonIds();
        $list = Permission::getGroupedPermissions();
        return view('admin.system.grantpermission', [
            'role'=> $role,
            'list'=> $list,
            'owned'=> $owned,
        ]);
    }

    /**
     * 角色用户管理
     * @param \App\Http\Requests\Admin\System\RoleUserRequest $request
     * @return type
     */
    public function roleUser(Requests\Admin\System\RoleUserRequest $request)
    {
        $role = Role::findOrFail($request->input('id'));
        if($request->isMethod('POST')) {
            // 直接添加用户到指定角色
            $inputUser = $request->input('user');
            if(is_numeric($inputUser) && intval($inputUser)) {
                $user = AdminUser::findOrFail(intval($inputUser));
            } else {
                $user = AdminUser::where('username', $inputUser)->firstOrFail();
            }
            return $this->addUserToRole($user, $role);
        }elseif($request->input('action')) {
            $user = AdminUser::findOrFail($request->input('user'));
            switch ($request->input('action')) {
                // 添加用户到角色
                case 1:
                    return $this->addUserToRole($user, $role);
                    break;
                // 从角色中删除用户
                case 2:
                    return $this->removeUserFromRole($user, $role);
                    break;
                default:
                    return $this->error();
                    break;
            }
        }
        $page = $request->input('page', 1);
        $pageNum = \Config::get('admin.commonPageNum');
        $list = $role->users()->skip($pageNum*($page-1))->take($pageNum)->get();
        $count = $role->users()->count();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $list, $count, $pageNum, $page,
            ['path' => route('admin::roleUser')]
        );
        return view('admin.system.roleuser', [
            'list' => $list,
            'paginator' => $paginator,
            'info' => $role,
        ]);
    }

    /**
     * 角色用户管理-按条件搜索用户
     * @param \App\Http\Requests\Admin\System\SearchUserRequest $request
     * @return type
     */
    public function searchUser(Requests\Admin\System\SearchUserRequest $request)
    {
        $page = $request->input('page', 1);
        $pageNum = \Config::get('admin.commonPageNum');
        $list = AdminUser::getList($page, $pageNum, $request->all());
        return $this->ajaxReturn($list);
    }

    /**
     * 添加用户到角色
     */
    protected function addUserToRole($user, $role)
    {
        try {
            if($user->hasRole($role->name))
            {
                return $this->error('用户已有该角色');
            }
            $user->attachRole($role);
            return request()->ajax() ? $this->ajaxReturn($user) : $this->success();
        } catch (\Exception $exc) {
            return $this->error(trans('admin.operate_fail'));
        }
    }

    /**
     * 从角色中移除用户
     */
    protected function removeUserFromRole($user, $role)
    {
        try {
            \DB::beginTransaction();
            if($user->system) {
                return $this->error('无法删除系统用户的系统角色');
            }
            if($role->system) {
                \DB::table('roles')->where('id', $role->id)->lockForUpdate()->get();
                if($role->users()->count()<=1) {
                    return $this->error('系统角色必须保留至少一个用户');
                }
            }
            $user->detachRole($role);
            \DB::commit();
            return $this->success(trans('admin.operate_done'));
        } catch (\Exception $exc) {
            \DB::rollBack();
            return $this->error(trans('admin.operate_fail'));
        }
    }

}
