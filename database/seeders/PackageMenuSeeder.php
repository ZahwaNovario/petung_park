<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Package;
use App\Models\Menu;
use App\Models\Category;

class PackageMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageIds = Package::orderBy('id')->pluck('id');

        $menuIds = Menu::orderBy('id')->pluck('id');
        
        // Fetch distinct category IDs directly from the menus using Eloquent
        $menuCategoryIds = Menu::select('category_id')->distinct()->orderBy('category_id')->pluck('category_id');
        
        // Ensure we have at least one package, menu, and menu category to reference
        if ($packageIds->isEmpty() || $menuIds->isEmpty() || $menuCategoryIds->isEmpty()) {
            $this->command->info('No packages, menus, or menu categories found. Please seed the related tables first.');
            return;
        }
        // Insert multiple records into the package_menus table
        DB::table('package_menus')->insert([
            [
                'package_id' => $packageIds[0],
                'menu_id' => $menuIds[4],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[0],
                'menu_id' => $menuIds[7],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[0],
                'menu_id' => $menuIds[8],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[0],
                'menu_id' => $menuIds[9],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            

            [
                'package_id' => $packageIds[1],
                'menu_id' => $menuIds[4],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[1],
                'menu_id' => $menuIds[7],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[1],
                'menu_id' => $menuIds[8],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_id' => $packageIds[1],
                'menu_id' => $menuIds[9],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

