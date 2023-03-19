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
//            'sku' => 'required|max:20',
//            'barcode' => 'required|max:20',
//            'product_name' => 'required|max:100',
//            'unit' => 'required|max:10',
//            'fraction' => 'required|numeric',
//            'status' => 'required|max:20',
//            'avgcost' => 'required|numeric',
//            'lastcost' => 'required|numeric',
//            'unitprice' => 'required|numeric',
//            'price_old' => 'required|numeric',
//            'price' => 'required|numeric',
//            'weight' => 'required|numeric',
//            'tax' => 'required',
//            'description' => 'string'
        ];
    }
}
