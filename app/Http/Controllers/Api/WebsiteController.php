<?php

namespace App\Http\Controllers\Api;

use App\Model\SystemConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Exception;

class WebsiteController extends ApiController
{
    public function getSeo()
    {
        try {

            $data = app(SystemConfig::class)->getWebsiteSeo();
            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(),$e->getCode());
        }
    }
}
