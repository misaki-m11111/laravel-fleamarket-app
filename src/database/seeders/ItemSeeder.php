<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'price' => 15000,
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'items/Armani+Mens+Clock.jpg',
            'condition' => 1,
        ]);

        $item->categories()->attach(
            Category::whereIn('name', ['ファッション', 'メンズ'])->pluck('id')
        );

        $item2 = Item::create([
            'user_id' => $user->id,
            'name' => 'HDD',
            'price' => 5000,
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'items/HDD+Hard+Disk.jpg',
            'condition' => 2,
        ]);

        $item2->categories()->attach(
            Category::whereIn('name', ['家電'])->pluck('id')
        );

        $item3 = Item::create([
            'user_id' => $user->id,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand_name' => null,
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'items/iLoveIMG+d.jpg',
            'condition' => 2,
        ]);

        $item3->categories()->attach(
            Category::whereIn('name', ['キッチン'])->pluck('id')
        );

        $item4 = Item::create([
            'user_id' => $user->id,
            'name' => '革靴',
            'price' => 4000,
            'brand_name' => null,
            'description' => 'クラシックなデザインの革靴',
            'image' => 'items/Leather+Shoes+Product+Photo.jpg',
            'condition' => 4,
        ]);

        $item4->categories()->attach(
            Category::whereIn('name', ['ファッション', 'メンズ'])->pluck('id')
        );

        $item5 = Item::create([
            'user_id' => $user->id,
            'name' => 'ノートPC',
            'price' => 45000,
            'brand_name' => null,
            'description' => '高性能なノートパソコン',
            'image' => 'items/Living+Room+Laptop.jpg',
            'condition' => 1,
        ]);

        $item5->categories()->attach(
            Category::whereIn('name', ['家電'])->pluck('id')
        );

        $item6 = Item::create([
            'user_id' => $user->id,
            'name' => 'マイク',
            'price' => 8000,
            'brand_name' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => 'items/Music+Mic+4632231.jpg',
            'condition' => 2,
        ]);

        $item6->categories()->attach(
            Category::whereIn('name', ['家電'])->pluck('id')
        );

        $item7 = Item::create([
            'user_id' => $user->id,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand_name' => null,
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'items/Purse+fashion+pocket.jpg',
            'condition' => 3,
        ]);

        $item7->categories()->attach(
            Category::whereIn('name', ['ファッション', 'レディース'])->pluck('id')
        );

        $item8 = Item::create([
            'user_id' => $user->id,
            'name' => 'タンブラー',
            'price' => 500,
            'brand_name' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => 'items/Tumbler+souvenir.jpg',
            'condition' => 4,
        ]);

        $item8->categories()->attach(
            Category::whereIn('name', ['キッチン'])->pluck('id')
        );

        $item9 = Item::create([
            'user_id' => $user->id,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand_name' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => 'items/Waitress+with+Coffee+Grinder.jpg',
            'condition' => 1,
        ]);

        $item9->categories()->attach(
            Category::whereIn('name', ['家電', 'キッチン'])->pluck('id')
        );

        $item10 = Item::create([
            'user_id' => $user->id,
            'name' => 'メイクセット',
            'price' => 2500,
            'brand_name' => null,
            'description' => '便利なメイクアップセット',
            'image' => 'items/makeup.jpg',
            'condition' => 2,
        ]);

        $item10->categories()->attach(
            Category::whereIn('name', ['レディース', 'コスメ'])->pluck('id')
        );
    }
}