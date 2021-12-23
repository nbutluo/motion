<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomepageBannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $banner = request()->route('banner');

        switch ($this->method()) {
            case 'PUT':
                return [
                    'media_url_pc' => 'required',
                    'media_url_mobile' => 'required',
                    'banner_alt' => 'required|min:3',
                    'order' => 'required',
                    'description' => 'required|between:3,20'
                ];

            case 'PATCH':
                return [
                    'media_url_pc' => 'required',
                    'media_url_mobile' => 'required',
                    'banner_alt' => 'required|min:3',
                    'description' => 'required|between:3,20',
                    'order' => 'required|unique:homepage_banners,order,' . $banner->id,
                ];
        }
    }

    public function messages()
    {
        return [
            'media_url_pc.required' => 'PC 端banner图片不能为空',
            'media_url_mobile.required' => '手机端banner图片不能为空',
            'banner_alt.required' => '图片Alt属性不能为空',
            'banner_alt.min' => '图片Alt字数不能小于3个',
            'order.required' => '请填写order顺序',
            'order.unique' => '序号与现有的Baner序号有冲突',
            'description.required' => '描述字符未填写',
            'description.between' => '描述字符介于3~20',
        ];
    }
}
