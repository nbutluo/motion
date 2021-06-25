<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\AboutLoctek;
use Exception;
use Illuminate\Http\Request;

class AboutUsController extends ApiController
{
    /**
     * @function 获取联系我们信息 get about us information
     * @param Request $request
     * @return mixed
     */
    public function getAboutUsInfo(Request $request)
    {
        try {
            $data = [];
            $locteks = AboutLoctek::select(['type','title','content','media_lable','media_link','media_type','position'])->where('is_active',1)->orderBy('position','DESC')->get();
            $show = []; $page = [];
            foreach ($locteks as $loctek) {
                if ($loctek->type == 1) {
                    $page['title'] = $loctek->title;
                    $page['description'] = $loctek->content;
                } else {
                    $about = [];
                    $about['title'] = $loctek->title;
                    $about['description'] = $loctek->content;
                    $about['media'] = (isset($loctek->media_link) && $loctek->media_link != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$loctek->media_link : '';
                    $about['media_type'] = $loctek->media_type;
                    $about['media_lable'] = $loctek->media_lable;
                    $show[] = $about;
                }
            }
            $data['aboutPage'] = $page;
            $data['list'] = $show;

            return $this->success('获取成功', $data);
        } catch (Exception $e) {
            return $this->fail('程序异常，获取失败。', 500);
        }
    }
}
