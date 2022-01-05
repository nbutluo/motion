<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BulkOrderRequest;
use App\Http\Resources\BulkOrderResource;
use App\Model\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function __construct()
    {
        // 一分钟内限制只能请求两次接口
        $this->middleware('throttle:2,1', [
            'only' => ['store']
        ]);
    }

    public function store(BulkOrderRequest $request, BulkOrder $bulkOrder)
    {
        $bulkOrder->fill($request->all());
        $bulkOrder->save();

        return new BulkOrderResource($bulkOrder);
    }
}
