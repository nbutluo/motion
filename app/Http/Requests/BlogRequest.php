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
            'meta_description' => 'max:200'
        ];
    }

    public function messages()
    {
        return [
            'meta_description.max' => 'meta_description字数不能超过200',
        ];
    }
}
