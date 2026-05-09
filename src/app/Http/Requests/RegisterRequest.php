<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメールアドレス形式で入力して下さい',

            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力して下さい',
            'password.confirmed' => 'パスワードが一致しません',

            'password_confirmation.required' => 'パスワードを入力してください',
            'password_confirmation.min' => 'パスワードは8文字以上で入力してください',
        ];
    }
}
