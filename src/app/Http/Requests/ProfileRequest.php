<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'mimes:jpeg,png'],
            'name' => ['required', 'max:20'],
            'post_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',

            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',

            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号はハイフンあり8文字で入力してください',

            'address.required' => '住所を入力して下さい',
        ];
    }
}
