<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BulkOrderRequest;
use App\Http\Resources\BulkOrderResource;
use App\Model\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function store(BulkOrderRequest $request, BulkOrder $bulkOrder)
    {
        $bulkOrder->fill($request->all());
        $bulkOrder->save();

        return new BulkOrderResource($bulkOrder);
    }
}
