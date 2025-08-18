<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class GalleriesShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryIds = DB::table('galleries')->orderBy('id')->pluck('id');

        // Ensure we have at least one gallery to reference
        if ($galleryIds->isEmpty()) {
            $this->command->info('No galleries found. Please seed the galleries table first.');
            return;
        }

        // Insert multiple records into the galleries_show table
        DB::table('galleries_show')->insert([
            
            [
                'name' => 'Hidangan lengkap dan lezat yang cocok untuk dinikmati bersama keluarga atau teman.',
                'status' => 1,
                'gallery_id' => $galleryIds[11],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wisata Hutan Bambu ini seringkali digunakan untuk spot foto-foto yang aesthetic',
                'status' => 1,
                'gallery_id' => $galleryIds[7],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gazebo Kecek Air dapat digunakan sembari menikmati kuliner yang dihidangkan',
                'status' => 1,
                'gallery_id' => $galleryIds[1],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baby Pool dengan kedalaman rendah yang dapat dinikmati dan dirancang khusus untuk anak-anak',
                'status' => 1,
                'gallery_id' => $galleryIds[8],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pemandangan alam seperti pegunungan dan sawah yang akan memanjakan mata',
                'status' => 1,
                'gallery_id' => $galleryIds[21],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
