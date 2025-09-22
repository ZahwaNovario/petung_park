<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Retrieve a list of existing gallery IDs
        $galleryIds = DB::table('galleries')->orderBy('id')->pluck('id');

        // Ensure we have at least one gallery to reference
        if ($galleryIds->isEmpty()) {
            $this->command->info('No galleries found. Please seed the galleries table first.');
            return;
        }

        // Insert multiple records into the staffs table
        DB::table('users')->insert([
            [
                'email' => 'pengabdiandesabelik@gmail.com',
                'email_verified_at' => now(),
                'name' => 'Amel',
                'password' => bcrypt('\)>F25\:9Xs/'),
                'date_of_birth' => $faker->date(),
                'phone_number' => $faker->phoneNumber,
                'position' => 'admin',
                'gender' => 'laki-laki',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'gallery_id' => $galleryIds[18],
            ],
        ]);
    }
}
