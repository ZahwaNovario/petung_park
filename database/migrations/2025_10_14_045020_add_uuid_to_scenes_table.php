<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scenes', function (Blueprint $table) {
            // Tambahkan kolom uuid (nullable dulu agar bisa diisi belakangan)
            $table->uuid('uuid')->nullable()->after('id');
        });

        // Isi UUID untuk data lama biar tidak null
        $scenes = \App\Models\Scene::whereNull('uuid')->get();
        foreach ($scenes as $scene) {
            $scene->uuid = (string) Str::uuid();
            $scene->save();
        }

        // Baru ubah jadi unique dan not null
        Schema::table('scenes', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('scenes', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
