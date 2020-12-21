<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin.login', ['except' => 'logout']);
    }

    public function index()
    {
        return redirect()->route('user.index');
    }
}
