<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactUsController extends ApiController
{

    protected $contactModel;

    public function __construct(Contact $contactModel)
    {
        //parent::__construct();
        $this->contactModel = $contactModel;
    }

    public function baseInfo()
    {
        $base_identify = [

        ];

        $base_remark_option = [
            '1' => [
                'chinese' => '其他',
                'english' => 'Other'
            ],
            '2' => [
                'chinese' => '我想了解产品',
                'english' => 'x'
            ],
            '3' => [
                'chinese' => '成为代理合作伙伴',
                'english' => 'xx'
                ],
            '4' => [
                'chinese' => '项目合作',
                'english' => 'xxx'
            ]
        ];
    }

    public function contact(Request $request)
    {
        $name = $request->input('name');
        if (!$name) return $this->fail('please input name or company name.', 4001);

        $phone = $request->input('phone');
        if (!$phone) return $this->fail('please input telephone.', 4001);

        $email = $request->input('email');
        if (!$email) return $this->fail('please input email.', 4001);

        $params = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
        ];

        if ($continent = $request->input('continent')) {
            $params['continent'] = $continent;
        }
        if ($country = $request->input('country')) {
            $params['country'] = $country;
        }
        if ($city = $request->input('city')) {
            $params['city'] = $city;
        }
        if ($identity = $request->input('identity')) {
            $params['identity'] = $identity;
        }
        if ($remark_option = $request->input('remark_option')) {
            $params['remark_option'] = $remark_option;
        }
        if ($remark = $request->input('remark')) {
            $params['remark'] = $remark;
        }

        try {
            // update info
            $res = $this->contactModel->insertGetId($params);

            return $this->success('submit success.', [$res]);
        } catch (Exception $e) {
            return $this->fail('error, submit failure.', 500);
        }
    }
}
