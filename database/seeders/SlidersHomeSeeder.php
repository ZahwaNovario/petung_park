<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersHomeSeeder extends Seeder
{
    public function run()
    {
        // Retrieve IDs from the galleries table
        $galleryIds = DB::table('galleries')->orderBy('id')->pluck('id');
        
        // Check if there are any galleries to seed
        if ($galleryIds->isEmpty()) {
            $this->command->info('No galleries found. Please seed the galleries table first.');
            return;
        }

        // Insert records into the sliders_home table
        DB::table('sliders_home')->insert([
            [
                'name' => 'Slider 1',
                'status' => 1,
                'gallery_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Slider 2',
                'status' => 1,
                'gallery_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Slider 3',
                'status' => 1,
                'gallery_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
