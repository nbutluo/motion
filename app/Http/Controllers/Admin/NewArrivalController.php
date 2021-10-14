<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product\Product;

class NewArrivalController extends Controller
{
    public function index()
    {
        return view('admin.new_arrival.index');
    }

    public function newArrival()
    {
        $new_arrivals = Product::where('is_new_arrival', true)->get();

        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'count' => count($new_arrivals),
            'data' => $new_arrivals,
        ]);
    }
}
