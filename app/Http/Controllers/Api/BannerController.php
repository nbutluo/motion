<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\MediumBanner;
use Illuminate\Http\Request;

class BannerController extends ApiController
{
    public function getBanner($pageName)
    {
        try {
            $banner = MediumBanner::where('page_name',$pageName)->where('is_active',1)->get();
            foreach ($banner as $ban) {
                $ban->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$ban->media_url;
            }
            return $this->success('success', $banner);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }

    public function getBannerList()
    {
        try {
            $banner = MediumBanner::where('is_active',1)->get();
            foreach ($banner as $ban) {
                $ban->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$ban->media_url;
            }
            return $this->success('success', $banner);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }
}
