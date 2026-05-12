<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{

    public function run(): void
    {
        $user = User::first();

        Profile::create([
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストマンション101',
            'image' => null,
        ]);
    }
}
