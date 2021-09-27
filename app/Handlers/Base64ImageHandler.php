<?php

namespace App\Handlers;

class Base64ImageHandler
{
    public function base64_image_content($base64, $folder = 'uploads')
    {
        $arr = array();

        //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
        $base64Image = str_replace(' ', '+', $base64);
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Image, $result)) {
            //获取后缀
            $extension = $result[2];
            //设置保存路径
            $filePath = "uploads/images/$folder/" . date("Ym/d", time());
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            //设置文件名
            $fileName = uniqid() . rand(0000, 9999);
            //设置图片路径
            $newFile = $filePath . $fileName . ".{$extension}";
            //存放图片
            if (file_put_contents($newFile, base64_decode(str_replace($result[1], '', $base64Image)))) {
                //返回文件路径
                array_push($arr, '/' . $newFile);
            }
        }

        return implode(';', $arr);
    }
}
