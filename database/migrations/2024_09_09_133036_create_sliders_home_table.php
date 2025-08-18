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
        Schema::create('sliders_home', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyinteger('status')->default(0);
            $table->unsignedBigInteger('gallery_id');
            $table->timestamps();

            // Defining the foreign key constraint
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders_home', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the column
            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });
        Schema::dropIfExists('sliders_home');
    }
};
