<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadController
{
    protected $maxSize =10;

    //文件上传
    public function upload(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        //返回信息json
        $data = ['code' => 1, 'msg' => '上传失败', 'data' => ''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()) {
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext), $allowed_extensions)) {
                $data['msg'] = "请上传" . implode(",", $allowed_extensions) . "格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getSize() > $maxSize * 1024 * 1024) {
                $data['msg'] = "图片大小限制" . $maxSize . "M";
                return response()->json($data);
            }
        } else {
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $newFile = date('Y-m-d') . "_" . time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
        $disk = Storage::disk('uploads');
        $res = $disk->put($newFile, file_get_contents($file->getRealPath()));
        if ($res) {
            $data = [
                'code' => 0,
                'msg' => '上传成功',
                'data' => $newFile,
                'url' => '/uploads/' . $newFile,
            ];
        } else {
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }

    public function uploadBlogImage(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        //返回信息json
        $data = ['location' => ''];
        $file = $request->file('edit');

        //检查文件是否上传完成
        if ($file->isValid()) {
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext), $allowed_extensions)) {
                $data['msg'] = "请上传" . implode(",", $allowed_extensions) . "格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getSize() > $maxSize * 1024 * 1024) {
                $data['msg'] = "图片大小限制" . $maxSize . "M";
                return response()->json($data);
            }
        } else {
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $newFile = date('Y-m-d') . "_" . time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
        $disk = Storage::disk('uploads');
        $res = $disk->put($newFile, file_get_contents($file->getRealPath()));
        if ($res) {
            $data = [
                'location' => '/uploads/' . $newFile
            ];
        } else {
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }

    public function uploadMedia(Request $request)
    {
        //上传文件最大大小,单位M：资源库最大20M
        $maxSize = 20;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif", "pdf", "video", "mov", "mp4"];
        //返回信息json
        $data = ['code' => 1, 'msg' => '上传失败', 'data' => ''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()) {
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext), $allowed_extensions)) {
                $data['msg'] = "请上传符合" . implode(",", $allowed_extensions) . "格式的文件";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getSize() > $maxSize * 1024 * 1024) {
                $data['msg'] = "文件大小限制" . $maxSize . "M";
                return response()->json($data);
            }
        } else {
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $newFile = date('Y-m-d') . "_" . time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
        $disk = Storage::disk('medium');
        $res = $disk->put($newFile, file_get_contents($file->getRealPath()));
        if ($res) {
            $data = [
                'code' => 0,
                'msg' => '上传成功',
                'data' => $newFile,
                'file_type' => strtolower($ext),
                'url' => '/medium/' . $newFile,
            ];
        } else {
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }

    //多图上传(暂时未使用，备用)
    public function uploadProductImages(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        //返回信息json
        $data = ['code' => 1, 'msg' => '上传失败', 'data' => ''];

        $imagePath = '';
        foreach ($request->file('images') as $image) {
            if ($image->isValid()) {
                //检测图片类型
                $ext = $image->getClientOriginalExtension();
                if (!in_array(strtolower($ext), $allowed_extensions)) {
                    $data['msg'] = "请上传" . implode(",", $allowed_extensions) . "格式的图片";
                    return response()->json($data);
                }
                //检测图片大小
                if ($image->getSize() > $maxSize * 1024 * 1024) {
                    $data['msg'] = "图片大小限制" . $maxSize . "M";
                    return response()->json($data);
                }
            } else {
                $data['msg'] = $image->getErrorMessage();
                return response()->json($data);
            }
            $newFile = date('Y-m-d') . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $disk = Storage::disk('uploads');
            $res = $disk->put($newFile, file_get_contents($image->getRealPath()));
            if ($imagePath == '') {
                $imagePath = '/uploads/' . $newFile;
            } else {
                $imagePath = $imagePath . ';/uploads/' . $newFile;
            }
        }
        if ($res) {
            $data = [
                'code' => 0,
                'msg' => '上传成功',
                'data' => $imagePath,
                'url' => $imagePath,
            ];
        } else {
            $data['data'] = $request->file('images')->getErrorMessage();
        }
        return response()->json($data);
    }
}
