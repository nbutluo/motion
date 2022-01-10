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

    public function edit(Product $product)
    {
        return view('admin.new_arrival.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'new_arrival_order' => 'nullable|unique:catalog_product,new_arrival_order,' .  $product->id,
        ], [
            'new_arrival_order.unique' => '与现有产品顺序冲突，请重新选择',
        ]);

        $data = $request->only(['is_new_arrival', 'new_arrival_order']);

        // 如果取消商品作为新品，新品展示顺序设置为 null
        if ($request->is_new_arrival == 0) {
            $data['new_arrival_order'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.new_arrival.index')->with('success', '更新成功');
    }
}
