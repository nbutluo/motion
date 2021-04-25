<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function success($msg, $data = [])
    {
        return response()->json([
            'status'  => true,
            'code'    => 200,
            'msg'     => $msg,
            'data'    => $data,
        ]);
    }

    public function fail($msg, $code, $data = [])
    {
        return response()->json([
            'status'  => false,
            'code'    => $code,
            'msg'     => $msg,
            'data'    => $data,
        ]);
    }
}
