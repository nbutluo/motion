<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\HomepageBanner;
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
            $banner = MediumBanner::select(['page_name', 'media_url', 'banner_alt', 'media_url_mobile', 'banner_alt_mobile'])->where('is_active', 1)->where('page_name', $pageName)->get();
            // dda($banner);
            foreach ($banner as $ban) {
                if (isset($ban->media_url) && $ban->media_url != '') {
                    $medias = explode(';', $ban->media_url);
                    $mediaData = [];
                    foreach ($medias as $media) {
                        $mediaData[] = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $media;
                    }
                    $medias_mobile = explode(';', $ban->media_url_mobile);
                    $mediaData_mobile = [];
                    foreach ($medias_mobile as $media_mobile) {
                        $mediaData_mobile[] = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $media_mobile;
                    }
                    $data['mob_img'] = $mediaData_mobile;
                    $data['mob_img_alt'] = $ban->banner_alt_mobile;
                    $data['media_img'] = $mediaData;
                    $data['media_img_alt'] = $ban->banner_alt;
                }
            }
            dda($data);
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }

    public function getBannerList()
    {
        try {
            $banner = MediumBanner::where('is_active', 1)->get();
            foreach ($banner as $ban) {
                if (isset($ban->media_url) && $ban->media_url != '') {
                    $banners = explode(';', $ban->media_url);
                    $images = [];
                    foreach ($banners as $bann) {
                        $images[] = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $bann;
                    }
                    $ban->media_url = $images;
                }
            }
            return $this->success('success', $banner);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }


    public function getHomepageBanner()
    {
        try {
            $banners = HomepageBanner::where('is_active', true)->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();

            foreach ($banners as $banner) {
                $banner['media_url_pc'] = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $banner['media_url_pc'];
                $banner['media_url_mobile'] = HTTP_TEXT . $_SERVER["HTTP_HOST"] . $banner['media_url_mobile'];
            }

            return $this->success('success', $banners);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404, []);
        }
    }
}
