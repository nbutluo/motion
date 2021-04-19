<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\WebsiteSeo;

class WebsiteController extends Controller
{
    public function getSeo()
    {
        return WebsiteSeo::pluck('seo_content','seo_meta');
    }
}
