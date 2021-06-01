<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;

class AboutUsController extends ApiController
{
    /**
     * @function 获取联系我们信息 get about us information
     * @param Request $request
     * @return mixed
     */
    public function getAboutUsInfo(Request $request)
    {
        try {

            $data = [
                'banner_info' => [
                    'is_active' => true,
                    'banner_img' => 'xxxxx.jpg',
                    'url' => 'yyyyyyyyyy.html',
                    'title' => 'title message',
                    'description' => 'description'
                ],
                'about_title' => [
                    'is_active' => true,
                    'title' => ' About Loctek',
                    'description' => 'xxxxxxxxxxxxxx'
                ],
                'block_des' => [
                    'is_active' => true,
                    'list' => [
                        [
                            'style' => 1,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'style' => 1,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'style' => 1,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'style' => 1,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'style' => 2,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'style' => 2,
                            'img' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                    ]
                ],
                'services' => [
                    'is_active' => true,
                    'list' => [
                        [
                            'icon' => 'xxxxx.jpg',
                            'title' => 'QUALITY',
                            'description' => 'xxxxxxxxxxxxxx'
                        ],
                        [
                            'icon' => 'xxxxx1.jpg',
                            'title' => 'QUALITY2',
                            'description' => 'xxxxxxxxxxxxxx2'
                        ]
                    ]
                ]
            ];

            return $this->success('获取成功', $data);
        } catch (Exception $e) {
            return $this->fail('程序异常，获取失败。', 500);
        }
    }
}
