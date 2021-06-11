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
        $categories = MediumSourceCategory::all();
        foreach ($categories as $category) {
            $data[$category->id] = $category->toArray();
        }
        return $data;
    }

    public function getCategoryData($category_id)
    {
        $categories = [];
        foreach ($this->getCategory() as $category) {
            if ($category['id'] == $category_id || $category['parent_id'] == $category_id) {
                $categories[] = $category['id'];
            }
        }
        return $categories;
    }

    public function get_video(Request $request)
    {
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',2)
                ->where('is_active',1)
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',2)->where('is_active',1)->get();
        }
        if ($mediumData) {
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
            }
            return $this->success('success', $mediumData);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_brochure(Request $request)
    {
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',3)
                ->where('is_active',1)
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',3)->where('is_active',1)->get();
        }
        if ($mediumData) {
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
            }
            return $this->success('success', $mediumData);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_instruction(Request $request)
    {
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',4)
                ->where('is_active',1)
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',4)->where('is_active',1)->get();
        }
        if ($mediumData) {
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
            }
            return $this->success('success', $mediumData);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function get_qcfile(Request $request)
    {
        if (isset($request->keywords) && $request->keywords != '' && isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else if ((isset($request->keywords) && $request->keywords != '')) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->where('title','like','%'.$request->keywords.'%')
                ->get();
        } elseif (isset($request->category) && $request->category >= 1) {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])
                ->where('media_type',5)
                ->where('is_active',1)
                ->whereIn('category_id',$this->getCategoryData($request->category))
                ->get();
        } else {
            $mediumData = MediumSource::select(['id','title','description','media_type','category_id','lable','media_url','media_links','position'])->where('media_type',5)->where('is_active',1)->get();
        }
        if ($mediumData) {
            foreach ($mediumData as $md) {
                if (isset($md->media_url) && $md->media_url != '') {
                    $md->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_url;
                }
                if (isset($md->media_links) && $md->media_links != '') {
                    $md->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$md->media_links;
                }
            }
            return $this->success('success', $mediumData);
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
