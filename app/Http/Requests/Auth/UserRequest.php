<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required',
            'birth_of_date' => 'required',
            'gender' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'postalcode' => 'required'
        ];
    }
}
