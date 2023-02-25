<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

        return $this->postProductRules();
    }

    public function postProductRules()
    {
        return [
            'sku' => 'required',
            'barcode' => 'required',
            'product_name' => 'required',
            'unit' => 'required',
            'fraction' => 'required',
            'status' => 'required',
            'unitprice' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'tax' => 'required',
            'description' => 'string'
        ];
    }
}
