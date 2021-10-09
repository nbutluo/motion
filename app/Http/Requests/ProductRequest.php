<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'sku' => 'required|min:3',
            'category_id' => 'required',
            'image' => 'required',
            'video_url' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '产品标题不能为空',
            'name.min' => '产品标题不能小于 3 个 字符',
            'sku.required' => 'SKU 不能为空',
            'sku.min' => 'SKU 不能小于 3 个 字符',
            'category_id.required' => '请选择产品所属分类',
            'image.required' => '产品图片不能为空',
            'video_url.url' => '请输入正确的 以 http:// 开头的 URL，',
        ];
    }
}
