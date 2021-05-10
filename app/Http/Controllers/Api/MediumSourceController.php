<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\MediumSource;
use Exception;
use Illuminate\Support\Facades\Log;

class MediumSourceController extends ApiController
{

    protected $mediumModel;

    public function __construct(MediumSource $mediumModel)
    {
        //parent::__construct();
        $this->mediumModel = $mediumModel;
    }

    public function img_output($id = 22)
    {
        try {

            $medium = $this->mediumModel->findOrFail($id);
            if (!$medium) throw new Exception('下载失败，信息不存在');
            $file = public_path() . $medium['media_url'];
            $name = basename($file);

            $type = 'image/jpeg';
            header('Content-Type:' . $type);
            header('Content-Length: ' . filesize($file));

            $PSize = filesize($file);
            $picture_data = fread(fopen($file, "r"), $PSize);

            echo $picture_data;

        } catch (\Exception $e) {
            echo 'medium resource is not found';
            exit;
        }
    }

    public function output_html()
    {
        echo '<img src="http://www.motion-laravel.com/loctek/medium/source">';
    }

    public function output_pdf()
    {
        $file = public_path() .'/uploads/检验证书（也可能是图片格式）.pdf';
        // <iframe src={`${pdfUrl}#page=${pageNumber}&toolbar=0`} frameBorder="0" style={{width: '100%', height: '100%'}} /> }

//        echo '<iframe src="http://www.motion-laravel.com/uploads/%E6%A3%80%E9%AA%8C%E8%AF%81%E4%B9%A6%EF%BC%88%E4%B9%9F%E5%8F%AF%E8%83%BD%E6%98%AF%E5%9B%BE%E7%89%87%E6%A0%BC%E5%BC%8F%EF%BC%89.pdf?page=0&toolbar=0" frameBorder="0" style={{width: \'100%\', height: \'100%\'}} /> }';

        echo '<embed src="http://www.motion-laravel.com/uploads/%E6%A3%80%E9%AA%8C%E8%AF%81%E4%B9%A6%EF%BC%88%E4%B9%9F%E5%8F%AF%E8%83%BD%E6%98%AF%E5%9B%BE%E7%89%87%E6%A0%BC%E5%BC%8F%EF%BC%89.pdf" type="application/pdf" width=200 height=300 style="margin-top: 200px;
display: -webkit-box;
overflow-x: scroll;
overflow-y: hidden;
-webkit-overflow-scrolling: touch;" />';
    }
}
