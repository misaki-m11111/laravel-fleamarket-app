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
            'image' => ['nullable', 'image', 'mimes:jpeg,png'],
            'name' => ['required', 'string', 'max:20'],
            'post_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:100'],
            'building' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'プロフィール画像は画像ファイルを選択してください',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',

            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',

            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号はハイフンあり8文字で入力してください',

            'address.required' => '住所を入力して下さい',
            'address.max' => '住所は100文字以内で入力してください',

            'building.max' => '建物名は100文字以内で入力してください',
        ];
    }
}
