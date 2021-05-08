<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use App\Model\Product\Product;
use App\Model\Question;
use Illuminate\Http\Request;

class FaqController extends ApiController
{
    public function getList($productId)
    {
        $question = Question::where('is_active',1)->get();
        $product = Product::select(['id','name','category_id'])->find($productId);
        $categories = Category::all();

        try {
            $categoryId = 0;
            foreach ($categories as $category) {
                if ($category['id'] == $product->category_id) {
                    $categoryId = $category['parent_id'];
                    break;
                }
            }

            $questions = []; $category_question = []; $all_question = [];
            foreach ($question as $quest) {
                if ($quest['product_id'] == $product->id) {
                    $questions[] = $quest;
                } elseif($quest['category_id'] == $categoryId) {
                    $category_question[] = $quest;
                } elseif($quest['category_id'] == 0 && $quest['product_id'] == 0) {
                    $all_question[] = $quest;
                }
            }
            foreach ($category_question as $cate_question) {
                $questions[] = $cate_question;
            }
            foreach ($all_question as $a_question) {
                $questions[] = $a_question;
            }
            return $this->success('success', $questions);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }

    }
}
