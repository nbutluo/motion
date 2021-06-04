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
            $data = [
                'media_img' => [],
                'mob_img' => []
            ];
            $banner = MediumBanner::select(['page_name','media_url'])->where('is_active',1)->where('page_name','like',$pageName.'%')->get();
            foreach ($banner as $ban) {
                if (isset($ban->media_url) && $ban->media_url != '') {
                    $medias = explode(';',$ban->media_url);
                    $mediaData = [];
                    foreach ($medias as $media) {
                        $mediaData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$media;
                    }
                    if (strpos($ban->page_name,'mobile') !== false) {
                        $data['mob_img'] = $mediaData;
                    } else {
                        $data['media_img'] = $mediaData;
                    }
                }
            }
            return $this->success('success', $data);
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
