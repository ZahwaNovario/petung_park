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
        Schema::create('package_menus', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('menu_id');

            // Add timestamps if you need created_at and updated_at columns
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

            $table->primary(['package_id', 'menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_menus', function (Blueprint $table) {
            $table->dropPrimary(['menu_id','package_id']);
            $table->dropForeign(['menu_id']);
            $table->dropColumn(['menu_id','package_id']);
        });
        Schema::dropIfExists('package_menus');
    }
};
