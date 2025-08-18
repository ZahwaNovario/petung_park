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
        Schema::create('article_gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('gallery_id');
            $table->string('name_collage');
            $table->tinyinteger('status')->default(0);
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');

            // Set the combination of foreign keys as a composite primary key
            $table->primary(['article_id', 'gallery_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_gallery', function (Blueprint $table) {
            $table->dropPrimary(['article_id', 'gallery_id']);
            // $table->dropForeign(['article_id']);
            $table->dropForeign(['gallery_id']);
            $table->dropColumn(['article_id', 'gallery_id']);
        });
        Schema::dropIfExists('article_gallery');
    }
};
