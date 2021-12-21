<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'meta_description' => 'max:500',
            'featured_img' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'meta_description.max' => 'meta_description字数不能超过500',
            'featured_img.required' => '缩略图不能为空',
        ];
    }
}
