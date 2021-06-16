<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\MediumSource;
use App\Model\MediumSourceCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediumSourceController extends ApiController
{

    protected $mediumModel;

    public function __construct(MediumSource $mediumModel)
    {
        //parent::__construct();
        $this->mediumModel = $mediumModel;
    }

    public function getCategory()
    {
        $data = [];
        $categories = MediumSourceCategory::select(['id','name','parent_id','media_type'])->where('is_active',1)->get();
        foreach ($categories as $category) {
            $data[$category->id] = $category->toArray();
        }
        return $data;
    }

    //获取各个分类下的二级分类
    public function getSecondCategory($media_type)
    {
        $categoryData = [];
        $categories = $this->getCategory();
        foreach ($categories as $category) {
            if ($category['media_type'] == $media_type && $category['parent_id'] == 0) {
                foreach ($categories as $cate) {
                    if ($cate['parent_id'] == $category['id']) {
                        $categoryData[] = $cate;
                    }
                }
            }
        }
        return $categoryData;
    }

    public function getThirdCategory($media_type,$categoryId=0)
    {

        if ($media_type == 2 || $media_type == 4) {
            $categoryName = 'Standing Desk';
        }elseif ($media_type == 5) {
            $categoryName = 'United States';
        }
        $thirdCategory = [];
        $categories = $this->getCategory();
        if ($categoryId != 0) {
            $thirdCategory[$categoryId] = [];
            foreach ($categories as $category) {
                if ($category['parent_id'] == $categoryId && $category['media_type'] == $media_type) {
                    $thirdCategory[$categoryId][] = $category['id'];
                }
            }
        } else {
            foreach ($categories as $category) {
                if ($category['media_type'] == $media_type) {//默认第二级分类
                    if ($media_type == 3) {
                        foreach ($categories as $cate) {
                            if ($cate['parent_id'] == $category['id']) {
                                foreach ($categories as $ca) {
                                    if ($ca['parent_id'] == $cate['id']) {
                                        $thirdCategory[$cate['id']][] = $ca['id'];
                                    }
                                }
                            }
                        }
                        break;
                    } else {
                        if ($category['name'] == $categoryName) {
                            foreach ($categories as $ca) {//第三级分类
                                if ($ca['parent_id'] == $category['id']) {
                                    $thirdCategory[$category['id']][] = $ca['id'];
                                }
                            }
                        }
                    }
                }
            }
        }
        return $thirdCategory;
    }

    public function get_medium(Request $request)
    {
        try {
            if (!isset($request->medium_type) || !in_array($request->medium_type,[2,3,4,5])) {
                throw new Exception('please enter medium_type!');
            }
            $data = [];
            $thirdCategory = $this->getThirdCategory($request->medium_type,$request->category);
            foreach ($thirdCategory as $thirdKey => $thirdValue)
            {
                $data['search']['category'] = $thirdKey;
                $thirdCategory = $thirdValue;
            }

            $data['category'] = $this->getSecondCategory($request->medium_type);

            $categoriesData = $this->getCategory();//获取所有分类信息

            $data['search']['keywords'] = (isset($request->keywords) && $request->keywords != '') ? $request->keywords : '';
//        $data['search']['category'] = (isset($request->category) && $request->category != '') ? $request->category : '';
            if (isset($request->keywords) && $request->keywords != '') {
                $data['search']['keywords'] = $request->keywords;
                $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                    ->where('media_type',$request->medium_type)
                    ->where('is_active',1)
                    ->where('title','like','%'.$request->keywords.'%')
                    ->whereIn('category_id',$thirdCategory)
                    ->get();
            } else {
                $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                    ->where('media_type',$request->medium_type)
                    ->where('is_active',1)
                    ->whereIn('category_id',$thirdCategory)
                    ->get();
            }
            $firstKey = '';  $secondKey = '';
            if ($request->medium_type == 2) {
                $firstKey = 'Product';  $secondKey = 'Installation';
            } elseif ($request->medium_type == 3) {

            } elseif ($request->medium_type == 4) {
                $firstKey = 'Installation';  $secondKey = 'Product';
            } elseif ($request->medium_type == 5) {
                $firstKey = 'First';  $secondKey = 'Second';
            }
            $result = [];
            $firstResult = []; $SecondResult = [];
            $i = 2;
            foreach ($mediumData as $medium) {
                if (isset($medium->media_url) && $medium->media_url != '') {
                    $medium->media_url = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $medium->media_url;
                }
                if (isset($medium->media_links) && $medium->media_links != '') {
                    $medium->media_links = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $medium->media_links;
                }
                if ($request->medium_type == 3) {
                    $result[0][] = $medium;
                } else {
                    if (strpos($categoriesData[$medium->category_id]['name'],$firstKey) !== false) {
                        $firstResult[] = $medium->toArray();
                    } elseif (strpos($categoriesData[$medium->category_id]['name'],$secondKey) !== false) {
                        $SecondResult[] = $medium->toArray();
                    } else {
                        $result[$i] = $medium;
                        $i++;
                    }
                }
            }
            if (!empty($firstResult) || !empty($SecondResult)) {
                $result[0] = $firstResult;
                $result[1] = $SecondResult;
            }
            $data['list'] = $result;
            return $this->success('success', $data);
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }

    }

    public function get_video(Request $request)
    {
        $data = [];
        $data['category'] = $this->getSecondCategory(2);
        $searchCategory = [];//获取搜索分类下的子分类id集合
        $categoriesData = $this->getCategory();//获取所有分类信息
        if (isset($request->category) && $request->category >= 1) {
            foreach ($categoriesData as $allCategory) {
                if ($allCategory['parent_id'] == $request->category) {
                    $searchCategory[] = $allCategory['id'];
                }
            }
        }
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $data['search']['keywords'] = $request->keywords;
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $data['search']['keywords'] = $request->keywords;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else {
            $data['search']['keywords'] = '';
            $data['search']['category'] = '';
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',2)->where('is_active',1)->get();
        }
        if ($mediumData) {
            $mediumSort = [];
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
                $mediumSort[$md->category_id][] = $md;//分离各个三级分类数据
            }
            $sortData = [];//整理数据
            $i = 2;
            foreach ($mediumSort as $key_sort => $value_sort) {
                $sortDataDetail = [];
                $sortDataDetail['category_id'] = $key_sort;
                $sortDataDetail['category_name'] = $categoriesData[$key_sort]['name'];
                $sortDataDetail['child'] = $value_sort;
                if (strpos($sortDataDetail['category_name'],'Product') !== false) {
                    $sortData[0] = $sortDataDetail;
                } elseif (strpos($sortDataDetail['category_name'],'Installation') !== false) {
                    $sortData[1] = $sortDataDetail;
                } else {
                    $sortData[$i] = $sortDataDetail;
                    $i++;
                }
            }
            ksort($sortData);
            $data['list'] = $sortData;
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_brochure(Request $request)
    {
        $data = [];
        $data['category'] = $this->getSecondCategory(3);
        $searchCategory = [];//获取搜索分类下的子分类id集合
        $categoriesData = $this->getCategory();//获取所有分类信息
        if (isset($request->category) && $request->category >= 1) {
            foreach ($categoriesData as $allCategory) {
                if ($allCategory['parent_id'] == $request->category) {
                    $searchCategory[] = $allCategory['id'];
                }
            }
        }
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $data['search']['keywords'] = $request->keywords;
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $data['search']['keywords'] = $request->keywords;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else {
            $data['search']['keywords'] = '';
            $data['search']['category'] = '';
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',3)->where('is_active',1)->get();
        }
        if ($mediumData) {
            $mediumSort = [];
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
                $mediumSort[$md->category_id][] = $md;//分离各个三级分类数据
            }
            $sortData = [];//整理数据
            foreach ($mediumSort as $key_sort => $value_sort) {
                $sortDataDetail = [];
                $sortDataDetail['category_id'] = $key_sort;
                $sortDataDetail['category_name'] = $categoriesData[$key_sort]['name'];
                $sortDataDetail['child'] = $value_sort;
                $sortData[] = $sortDataDetail;
            }
            $data['list'] = $sortData;
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_instruction(Request $request)
    {
        $data = [];
        $data['category'] = $this->getSecondCategory(4);
        $searchCategory = [];//获取搜索分类下的子分类id集合
        $categoriesData = $this->getCategory();//获取所有分类信息
        if (isset($request->category) && $request->category >= 1) {
            foreach ($categoriesData as $allCategory) {
                if ($allCategory['parent_id'] == $request->category) {
                    $searchCategory[] = $allCategory['id'];
                }
            }
        }
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $data['search']['keywords'] = $request->keywords;
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $data['search']['keywords'] = $request->keywords;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else {
            $data['search']['keywords'] = '';
            $data['search']['category'] = '';
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',4)->where('is_active',1)->get();
        }
        if ($mediumData) {
            $mediumSort = [];
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
                $mediumSort[$md->category_id][] = $md;//分离各个三级分类数据
            }
            $sortData = [];//整理数据
            $i = 2;
            foreach ($mediumSort as $key_sort => $value_sort) {
                $sortDataDetail = [];
                $sortDataDetail['category_id'] = $key_sort;
                $sortDataDetail['category_name'] = $categoriesData[$key_sort]['name'];
                $sortDataDetail['child'] = $value_sort;
                if (strpos($sortDataDetail['category_name'],'Installation') !== false) {
                    $sortData[0] = $sortDataDetail;
                } elseif (strpos($sortDataDetail['category_name'],'Product') !== false) {
                    $sortData[1] = $sortDataDetail;
                } else {
                    $sortData[$i] = $sortDataDetail;
                    $i++;
                }
            }
            ksort($sortData);
            $data['list'] = $sortData;
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_qcfile(Request $request)
    {
        $data = [];
        $data['category'] = $this->getSecondCategory(5);
        $searchCategory = [];//获取搜索分类下的子分类id集合
        $categoriesData = $this->getCategory();//获取所有分类信息
        if (isset($request->category) && $request->category >= 1) {
            foreach ($categoriesData as $allCategory) {
                if ($allCategory['parent_id'] == $request->category) {
                    $searchCategory[] = $allCategory['id'];
                }
            }
        }
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $data['search']['keywords'] = $request->keywords;
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $data['search']['keywords'] = $request->keywords;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $data['search']['category'] = $request->category;
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->whereIn('category_id',$searchCategory)
                ->get();
        } else {
            $data['search']['keywords'] = '';
            $data['search']['category'] = '';
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',5)->where('is_active',1)->get();
        }
        if ($mediumData) {
            $mediumSort = [];
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
                $mediumSort[$md->category_id][] = $md;//分离各个三级分类数据
            }
            $sortData = [];//整理数据
            $i = 2;
            foreach ($mediumSort as $key_sort => $value_sort) {
                $sortDataDetail = [];
                $sortDataDetail['category_id'] = $key_sort;
                $sortDataDetail['category_name'] = $categoriesData[$key_sort]['name'];
                $sortDataDetail['child'] = $value_sort;
                if (strpos($sortDataDetail['category_name'],'First') !== false) {
                    $sortData[0] = $sortDataDetail;
                } elseif (strpos($sortDataDetail['category_name'],'Second') !== false) {
                    $sortData[1] = $sortDataDetail;
                } else {
                    $sortData[$i] = $sortDataDetail;
                    $i++;
                }
            }
            ksort($sortData);
            $data['list'] = $sortData;
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function img_output($id = 22)
    {
        try {

            $medium = $this->mediumModel->findOrFail($id);
            if (!$medium) throw new Exception('下载失败，信息不存在');
            $file = public_path() . $medium['media_url'];
            $name = basename($file);

            $type = 'image/jpeg';
            header('Content-Type:' . $type);
            header('Content-Length: ' . filesize($file));

            $PSize = filesize($file);
            $picture_data = fread(fopen($file, "r"), $PSize);

            echo $picture_data;

        } catch (\Exception $e) {
            echo 'medium resource is not found';
            exit;
        }
    }

    public function output_video()
    {
        try {

            $file = public_path() . '/uploads/video/视频.mov';
            $name = basename($file);

        } catch (\Exception $e) {
            echo 'medium resource is not found: ' . $e->getMessage();
            exit;
        }
    }

    public function output_html()
    {
        echo '<img src="http://www.motion-laravel.com/loctek/medium/source">';
    }

    public function output_pdf()
    {
        $file = public_path() . '/uploads/检验证书（也可能是图片格式）.pdf';
        // <iframe src={`${pdfUrl}#page=${pageNumber}&toolbar=0`} frameBorder="0" style={{width: '100%', height: '100%'}} /> }

//        echo '<iframe src="http://www.motion-laravel.com/uploads/%E6%A3%80%E9%AA%8C%E8%AF%81%E4%B9%A6%EF%BC%88%E4%B9%9F%E5%8F%AF%E8%83%BD%E6%98%AF%E5%9B%BE%E7%89%87%E6%A0%BC%E5%BC%8F%EF%BC%89.pdf?page=0&toolbar=0" frameBorder="0" style={{width: \'100%\', height: \'100%\'}} /> }';

        echo '<embed src="http://www.motion-laravel.com/uploads/%E6%A3%80%E9%AA%8C%E8%AF%81%E4%B9%A6%EF%BC%88%E4%B9%9F%E5%8F%AF%E8%83%BD%E6%98%AF%E5%9B%BE%E7%89%87%E6%A0%BC%E5%BC%8F%EF%BC%89.pdf" type="application/pdf" width=200 height=300 style="margin-top: 200px;
display: -webkit-box;
overflow-x: hidden;
overflow-y: hidden;
-webkit-overflow-scrolling: touch;" />';
    }
}
