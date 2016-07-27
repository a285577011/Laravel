<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
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

    /**
     * 成功提示
     * @param string|null $msg null时提示信息为空，空字符串时使用默认提示，否则使用传入的字符
     * @return
     */
    protected function success($msg='')
    {
        $msg = is_null($msg) ? '' : ( $msg !=='' ? $msg : trans('admin.operate_done'));
        if (request()->ajax())
        {
            return response()->json(['error'=>0, 'msg'=>$msg]);
        }
        return back()->with('message', $msg);
    }

    /**
     * 返回ajax信息
     * @param mixed $data 需要返回的数据
     * @param int $error 1 错误，0 成功
     * @param string $msg 返回的提示文字
     * @return
     */
    protected function ajaxReturn($data, $error = 0, $msg = '', $redirect = '')
    {
        $arr = ['data' => $data,
            'error' => $error ? 1 : 0,
            'msg' => $msg ?: ($error ? trans('admin.operate_fail') : trans('admin.operate_done'))
        ];
        if ($redirect) {
            $arr['redirect'] = $redirect;
        }
        return response()->json($arr);
    }
    
    protected function alert($message, $redirect='')
    {
        return view('errors/alert', [
            'alertMsg' => $message,
            'alertRedirect' => $redirect,
        ]);
    }

}