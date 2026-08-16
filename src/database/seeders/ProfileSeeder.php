<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('email', 'seller@example.com')->firstOrFail();

        Profile::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'post_code' => '123-4567',
                'address' => '東京都渋谷区1-1-1',
                'building' => 'テストマンション101',
                'image' => null,
            ]
        );

        $buyer = User::where('email', 'buyer@example.com')->firstOrFail();

        Profile::updateOrCreate(
            ['user_id' => $buyer->id],
            [
                'post_code' => '123-4567',
                'address' => '東京都新宿区2-2-2',
                'building' => 'デモマンション202',
                'image' => null,
            ]
        );
    }
}