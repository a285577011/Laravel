<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    protected function success($msg='')
    {
        $msg = $msg ? : trans('admin.operate_done');
        if (request()->ajax())
        {
            return response()->json(['error'=>0, 'msg'=>$msg]);
        }
        return back()->with('message', $msg);
    }
    
    protected function error($msg='', $redirect = '')
    {
        $msg = $msg ? : trans('admin.operate_fail');
        if (request()->ajax())
        {
            $jsonData = ['error'=>1, 'msg'=>$msg];
            $redirect ? $jsonData['redirect'] = $redirect : '';
            return response()->json($jsonData);
        }
        if($redirect) {
            return redirect($redirect)->withErrors($msg);
        }
        return back()->withErrors($msg);
    }
}