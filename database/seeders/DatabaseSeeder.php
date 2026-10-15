<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan migrate --seed  (safe to re-run: every seeder upserts)
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            PageSeeder::class,
            SettingSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
