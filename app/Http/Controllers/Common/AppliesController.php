<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppliesController extends Controller
{

    //TODO 用户注册时更新 users 表中的 apply_staus = 1 , 
    public function create()
    {
        //
    }

    //TODO 上次提交的 申请未审核时禁止提交
    public function store(Request $request)
    {
        //
    }
}
