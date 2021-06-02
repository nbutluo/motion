<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Business_solutions;
use Illuminate\Http\Request;

class BusinessSolutionsController extends ApiController
{
    public function getList(Request $request)
    {
        $type = $request->type;
        try {
            $solutions = Business_solutions::select(['id','title','content','meida_link'])
                ->where('is_active',1)
                ->where('category_type',$request->type)
                ->get();
            return $this->success('success', $solutions);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 403, []);
        }
    }
}
