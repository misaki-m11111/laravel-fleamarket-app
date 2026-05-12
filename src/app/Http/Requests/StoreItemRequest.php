<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],
            'condition' => ['required', 'in:1,2,3,4'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:1', 'max:9999999'],
            'brand_name' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '画像を選択してください',
            'image.image' => '商品画像は画像ファイルを選択してください',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',
            'image.max' => '画像は2MB以内でアップロードしてください',

            'categories.required' => '商品のカテゴリーを選択してください',
            'categories.array' => '商品のカテゴリーを正しく選択してください',
            'categories.min' => '商品のカテゴリーを1つ以上選択してください',
            'categories.*.exists' => '選択されたカテゴリーが正しくありません',

            'condition.required' => '商品の状態を選択してください',
            'condition.in' => '商品の状態を正しく選択してください',

            'name.required' => '商品名を入力してください',
            'name.max' => '商品名は50文字以内で入力してください',

            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',

            'price.required' => '販売価格を入力して下さい',
            'price.integer' => '販売価格は半角数字で入力してください',
            'price.min' => '販売価格は1円以上で入力してください',
            'price.max' => '販売価格は9999999円以内で入力してください',

            'brand_name.max' => 'ブランド名は50文字以内で入力してください',

        ];
    }
}
