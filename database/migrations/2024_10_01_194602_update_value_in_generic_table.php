<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */    
    public function up(): void
    {
        Schema::table('generic', function (Blueprint $table) {
            $table->longText('value')->change();
            $table->longText('icon_picture_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Truncate the data in the 'icon_picture_link' column to fit within the 255-character limit
        DB::table('generic')->whereRaw('CHAR_LENGTH(icon_picture_link) > 255')
            ->update(['icon_picture_link' => DB::raw('LEFT(icon_picture_link, 255)')]);

        Schema::table('generic', function (Blueprint $table) {
            $table->longText('value')->change();
            $table->longText('icon_picture_link')->nullable()->change();
        });
    }

};
