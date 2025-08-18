<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('packages')->insert([
            [
                'name' => 'Paket Hemat 5-6 Orang',
                'price' => 150000,
                'status' => 1,
                'number_love' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'gallery_id' => 24,
            ],
            [
                'name' => 'Paket Super 8-10 Orang',
                'price' => 250000,
                'status' => 1,
                'number_love' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'gallery_id' => 25,
            ],
        ]);
    }
}
