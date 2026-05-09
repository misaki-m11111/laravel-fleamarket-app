<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    public function create(array $input): User
    {
        Validator::make(
            $input,
            [

                'name' => ['required', 'max:20'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'min:8'],

            ],

            [

                'name.required' => 'お名前を入力してください',
                'name.max' => 'お名前は20文字以内で入力してください',

                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスはメールアドレス形式で入力してください',

                'password.required' => 'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
                'password.confirmed' => 'パスワードが一致しません',

                'password_confirmation.required' => 'パスワードを入力してください',
                'password_confirmation.min' => 'パスワードは8文字以上で入力してください',

            ]
        )->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
