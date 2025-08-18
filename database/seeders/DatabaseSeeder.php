<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Category, Package, User, Travel, Gallery, GalleryShow, Agenda, Article, Menu, Generic, PackageMenu, TravelGallery, ArticleGallery, SliderHome};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        Package::truncate();
        Travel::truncate();
        Gallery::truncate();
        GalleryShow::truncate();
        User::truncate();
        Generic::truncate();
        Agenda::truncate();
        Article::truncate();
        Menu::truncate();
        PackageMenu::truncate();
        TravelGallery::truncate();
        ArticleGallery::truncate();
        SliderHome::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->call(CategorySeeder::class);
        $this->call(TravelSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(GalleriesShowSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GenericSeeder::class);
        $this->call(AgendaSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(PackageMenuSeeder::class);
        $this->call(TravelGallerySeeder::class);
        $this->call(ArticleGallerySeeder::class);
        $this->call(SlidersHomeSeeder::class);
    }
}
