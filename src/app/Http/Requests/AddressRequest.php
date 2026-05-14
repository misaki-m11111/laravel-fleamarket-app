<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号はハイフンあり8文字で入力してください',

            'address.required' => '住所を入力してください',
        ];
    }
}
