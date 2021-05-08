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
        $categories = Category::select(['id','name'])->where('level',1)->where('is_active',1)->get();
        $products = Product::select(['id','name','sku'])->where('is_active',1)->get();
        return view('admin.faq.create',compact('categories','products'));
    }

//    public function getData(Request $request,$type)
//    {
//        if ($type == 1) {
//            $datas = Category::select(['id','name'])->where('level',1)->where('is_active',1)->get();
//        } elseif ($type == 2) {
//            $datas = Product::select(['id','name','sku'])->where('is_active',1)->get();
//        }
//    }

    public function addQuestion(Request $request)
    {
        $data = $request->all();
        try {
            Question::create([
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'product_id' => ($data['category_id'] != 0) ? $data['product_id'] : 0,
                'title' => $data['title'],
                'short_content' => $data['short_content'],
                'content' => $data['content'],
                'is_active' => $data['is_active'],
            ]);
            return Redirect::to(URL::route('admin.faq.info'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('添加失败');
        }
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        if ($question->category_id != 0) {
            $category = Category::findOrFail($question->category_id);
        } else {
            $category = '';
        }
        if ($question->product_id != 0) {
            $product = Product::findOrFail($question->product_id);
        } else {
            $product = '';
        }
        $category = Category::where('is_active',1)->get();
        //分类重新排序
        $categories = [];
        foreach ($category as $cate) {
            if ($cate['level'] == 1) {
                $categories[] = $cate;
                foreach ($category as $cateItem) {
                    if ($cateItem['parent_id'] == $cate['id']) {
                        $categories[] = $cateItem;
                    }
                }
            }
        }
        $products = Product::where('is_active',1)->get();
        return view('admin.faq.edit',compact('question','category','product','categories','products'));
    }

    public function update(Request $request,$id)
    {
        $question = Question::findOrFail($id);
        $data = $request->only(['user_id','category_id','product_id','is_active','title','short_content','content']);
        try {
            $question->update($data);
            return Redirect::to(URL::route('admin.faq.info'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }

}
