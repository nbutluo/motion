<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
