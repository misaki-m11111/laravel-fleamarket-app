<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'in:1,2'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法をしてください',
            'payment_method.in' => '支払い方法を正しく選択してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $profile = auth()->user()->profile;

            if (
                !$profile ||
                !$profile->post_code ||
                !$profile->address
            ) {
                $validator->errors()->add(
                    'address',
                    '配送先を選択してください'
                );
            }
        });
    }
}
