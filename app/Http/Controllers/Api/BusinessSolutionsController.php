<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Business_solutions;
use Illuminate\Http\Request;

class BusinessSolutionsController extends ApiController
{
    public function getList(Request $request)
    {
        $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
        $page_size = (isset($request->page_size) && $request->page_size != '') ? $request->page_size : 10;
        try {
            $totalSolutions = Business_solutions::select(['id'])
                ->where('is_active',1)
                ->where('category_type',$request->type)
                ->orderBy('position','DESC')
                ->get();
            $solutions = Business_solutions::select(['id','title','content','media_link','media_alt'])
                ->where('is_active',1)
                ->where('category_type',$request->type)
                ->orderBy('position','DESC')
                ->offset(($page-1)*$request->page_size)
                ->limit($page_size)->get();
            foreach ($solutions as $solution) {
                $solution->content = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$solution->content);
            }
            $data = [];
            $data['totle'] = count($totalSolutions);
            $data['totle_pageNum'] = ceil($data['totle'] / $page_size);
            $data['list'] = $solutions;
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 403, []);
        }
    }
}
