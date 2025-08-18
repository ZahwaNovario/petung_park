<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleGallerySeeder extends Seeder
{
    public function run()
    {
        // Retrieve IDs from the articles and galleries tables
        $articleIds = DB::table('articles')->orderBy('id')->pluck('id');
        $galleryIds = DB::table('galleries')->orderBy('id')->pluck('id');

        // Check if there are any articles and galleries to seed
        if ($articleIds->isEmpty() || $galleryIds->isEmpty()) {
            $this->command->info('No articles or galleries found. Please seed the articles and galleries tables first.');
            return;
        }

        // Insert records into the article_gallery table
        DB::table('article_gallery')->insert([
            [
                'article_id' => $articleIds[0],
                'gallery_id' => $galleryIds[25],
                'name_collage' => 'Kolase Soft Opening Petung Park',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[1],
                'gallery_id' => $galleryIds[8],
                'name_collage' => 'Kolase Baby Pool',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[2],
                'gallery_id' => $galleryIds[26],
                'name_collage' => 'Kolase Sambang Desa Menteri',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[2],
                'gallery_id' => $galleryIds[33],
                'name_collage' => 'Kolase Sambang Desa Menteri',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[3],
                'gallery_id' => $galleryIds[27],
                'name_collage' => 'Kolase Budaya Lokal',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[4],
                'gallery_id' => $galleryIds[28],
                'name_collage' => 'Kolase Pelatihan Prima',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'article_id' => $articleIds[4],
                'gallery_id' => $galleryIds[34],
                'name_collage' => 'Kolase Sambang Desa Menteri',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'article_id' => $articleIds[5],
            //     'gallery_id' => $galleryIds[28],
            //     'name_collage' => 'Kolase Pelatihan Ekowisata',
            //     'status' => 1,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
