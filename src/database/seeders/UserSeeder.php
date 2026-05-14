<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password1234'),
            'email_verified_at' => Carbon::now(),
        ]);
        User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password1234'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
