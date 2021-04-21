<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\WebsiteSeo;
use App\Http\Controllers\ApiController;
use Exception;

class WebsiteController extends ApiController
{
    public function getSeo()
    {
        try {
            $seo = WebsiteSeo::pluck('seo_content','seo_meta');
            if (!empty($seo->toArray())) {
                return $this->success('successful',$seo);
            } else {
                throw new Exception('empty','4003');
            }
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }
}
