<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BulkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BulkOrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.bulk_order.index');
    }

    public function getList(Request $request)
    {
        $bulk_orders = BulkOrder::orderBy('created_at', 'desc')->paginate($request->get('limit', 30));

        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $bulk_orders->total(),
            'data' => $bulk_orders->items()
        ];

        return Response::json($data);
    }

    public function show(BulkOrder $bulkOrder)
    {
        return view('admin.bulk_order.show', compact('bulkOrder'));
    }
}
