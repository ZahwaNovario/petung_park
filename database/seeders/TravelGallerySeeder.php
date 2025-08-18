<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TravelGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve a list of existing travel IDs
        $travelIds = DB::table('travels')->orderBy('id')->pluck('id');
        
        // Retrieve a list of existing gallery IDs
        $galleryIds = DB::table('galleries')->orderBy('id')->pluck('id');

        // Ensure we have at least one travel and one gallery to reference
        if ($travelIds->isEmpty() || $galleryIds->isEmpty()) {
            $this->command->info('No travels or galleries found. Please seed the related tables first.');
            return;
        }

        // Insert multiple records into the travel_gallery table
        DB::table('travel_gallery')->insert([
            [
                'travel_id' => $travelIds[0],
                'gallery_id' => $galleryIds[6],
                'name_collage' => 'Kolase Hutan Bambu',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[0],
                'gallery_id' => $galleryIds[7],
                'name_collage' => 'Kolase Hutan Bambu',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[2],
                'gallery_id' => $galleryIds[1],
                'name_collage' => 'Kolase Meja Makan',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[3],
                'gallery_id' => $galleryIds[8],
                'name_collage' => 'Kolase Baby Pool',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[5],
                'gallery_id' => $galleryIds[9],
                'name_collage' => 'Kolase Pujasera',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[1],
                'gallery_id' => $galleryIds[19],
                'name_collage' => 'Kolase Kemah',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_id' => $travelIds[4],
                'gallery_id' => $galleryIds[5],
                'name_collage' => 'Kolase Pondok Bambu',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
