<?php

namespace App\Handlers;

use App\Http\Requests\ProductRequest;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class VideoUploadHandler
{
    public function video_upload($file)
    {
        $accessKey = env('QINIU_ACCESS_KEY');
        $secretKey = env('QINIU_SECRET_KEY');
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 要上传的空间
        $bucket =  env('QINIU_BUCKET', 'loctek-com');
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        $key = date("YmdHis") . '_' . mt_rand(10000, 99999) . '.' . $file->getClientOriginalExtension();

        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key,  $file->getRealPath());

        if ($err !== null) {
            // dd($err);
        } else {
            $video_url = env('QINIU_DOMAIN') . '/' . $key;
        }

        return $video_url;
    }
}
