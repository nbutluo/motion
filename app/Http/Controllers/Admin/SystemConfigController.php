<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SystemConfig;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{

    public function getSeoInfo()
    {
        $data = app(SystemConfig::class)->getWebsiteSeo();
        return response()->json($data);
    }

    public function updateSeoConfig(Request $request)
    {
        $data = [];
        if ($keywords = $request->input('keywords')) {
            $data['seo_default_keywords'] = $keywords;
        }
        if ($title = $request->input('title')) {
            $data['seo_default_title'] = $title;
        }
        if ($description = $request->input('description')) {
            $data['seo_default_description'] = $description;
        }

        $res = app(SystemConfig::class)->updateSeo($data);

        if ($res) {
            return response()->json(['msg' => 'success','data' => $res]);
        } else {
            return response()->json(['msg' => 'failure','data' => $res]);
        }
    }
}
