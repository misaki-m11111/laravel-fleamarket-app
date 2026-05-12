<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriesTableSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
