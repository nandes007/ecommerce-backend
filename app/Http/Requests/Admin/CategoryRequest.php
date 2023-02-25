<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'GET') {
            return [];
        }

        return $this->postCategoryRules();
    }

    public function postCategoryRules()
    {
        return [
            'name' => 'required'
        ];
    }
}
