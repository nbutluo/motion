<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use App\Model\Product\Product;
use App\Model\Question;
use App\Model\Sitemap;
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
                $quest->url_key = $this->getFaqUrlKey($quest->id);
                $quest->content = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$quest->content);
                if ($quest->product_id == $product->id) {
                    $questions[] = $quest;
                } elseif($quest->category_id == $categoryId) {
                    $category_question[] = $quest;
                } elseif($quest->category_id == 0 && $quest->product_id == 0) {
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
            return $this->fail($exception->getMessage(), 404, []);
        }

    }

    public function getFaqUrlKey($id)
    {
        $siteMap = Sitemap::select(['url'])->where('origin','/loctek/faq/info/'.$id)->first();
        if ($siteMap) {
            return $siteMap->url;
        } else {
            return '';
        }
    }

    public function getInfo($title)
    {
        try {
            $question = Question::where('title',$title)->first();
            if ($question) {
                $question->content = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$question->content);
                return $this->success('success', $question);
            } else {
                throw new \Exception('FAQ title is wrong!');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }

    public function getSearch()
    {
        try {
            $question = Question::select(['id','title','short_content','content'])->where('is_active',1)->limit(8)->get();
            foreach ($question as $ques) {
//                $ques->url_key = $this->getFaqUrlKey($ques->id);
                $ques->content = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$ques->content);
            }
            return $this->success('success', $question);
        } catch (\Exception $exception) {
            return $this->fail('failure', 404, []);
        }
    }
}
