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
            $profiles = Companyprofile::select(['id','title','content','media_link'])->where('is_active',1)->get();
            foreach ($profiles as $profile) {
                if (isset($profile->media_link) && $profile->media_link != '') {
                    $profile->media_link = HTTP_TEXT.$_SERVER["HTTP_HOST"].$profile->media_link;
                }
            }
            return $this->success('success', $profiles);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }
    }
}
