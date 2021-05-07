<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product\Category;
use App\Model\Product\Product;
use Illuminate\Http\Request;
use App\Model\Question;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faq.index');
    }

    public function data(Request $request)
    {
        $faq = Question::paginate($request->get('limit',30));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $faq->total(),
            'data' => $faq->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        return view('admin.faq.create',compact('category','products'));
    }

    public function getData(Request $request,$type)
    {
        if ($type == 1) {
            $datas = Category::select(['id','name'])->where('level',1)->where('is_active',1)->get();
        } elseif ($type == 2) {
            $datas = Product::select(['id','name','sku'])->where('is_active',1)->get();
        }
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $datas->total(),
            'data' => $datas->items()
        ];
        return Response::json($data);
    }

    public function addQuestion(Request $request)
    {
        $data = $request->all();
        try {
            Question::create([
                'user_id' => $data[''],
                'category_id' => $data['category_id'],
                'product_id' => $data['product_id'],
                'short_content' => $data['short_content'],
                'content' => $data['content'],
            ]);
            return Redirect::to(URL::route('admin.faq.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
