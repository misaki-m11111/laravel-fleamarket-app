<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => ['required', 'max:255'],
            'image' => ['required', 'mimes:jpeg,png'],
            'categories' => 'required',
            'condition' => 'required',
            'price' => ['required', 'integer', 'min:0'],

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => '商品名を入力してください',

            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',

            'image.required' => '画像を選択してください',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',

            'categories.required' => '商品のカテゴリーを選択してください',

            'condition.required' => '商品の状態を選択してください',

            'price.required' => '販売価格を入力して下さい',
            'price.integer' => '販売価格は半角数字で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }
}
