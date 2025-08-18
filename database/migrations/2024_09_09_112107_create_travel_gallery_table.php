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
        Schema::create('travel_gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('travel_id');
            $table->unsignedBigInteger('gallery_id');
            $table->string('name_collage');
            $table->tinyinteger('status')->default(0);

            // Add timestamps if you need created_at and updated_at columns
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');

            // Set the combination of foreign keys as a composite primary key
            $table->primary(['travel_id', 'gallery_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_gallery', function (Blueprint $table) {
            $table->dropPrimary(['gallery_id','travel_id']);
            $table->dropForeign(['gallery_id']);
            $table->dropColumn(['gallery_id','travel_id']);
        });
        Schema::dropIfExists('travel_gallery');
    }
};
