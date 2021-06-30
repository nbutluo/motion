<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Companyprofile;
use Illuminate\Http\Request;

class CompanyProfileController extends ApiController
{
    public function getProfile()
    {
        try {
            $profiles = Companyprofile::select(['id','title','content','media_link'])->where('is_active',1)->orderBy('position','DESC')->get();
            foreach ($profiles as $profile) {
                $profile->content = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$profile->content);
                if (isset($profile->media_link) && $profile->media_link != '') {
                    $profile->media_link = HTTP_TEXT.$_SERVER["HTTP_HOST"].$profile->media_link;
                }
                if (strpos($profile->media_link,'.jpg') !== false || strpos($profile->media_link,'.png') !== false || strpos($profile->media_link,'.gif') !== false) {
                    $profile->media_type = 1;
                } else {
                    $profile->media_type = 2;
                }
            }
            return $this->success('success', $profiles);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }
    }
}
