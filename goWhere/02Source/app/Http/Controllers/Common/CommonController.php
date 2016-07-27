<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function error($msg='', $redirect='')
    {
        return view('errors/error', [
            'msg' => $msg,
            'url' => $redirect,
        ]);
    }
}
