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
        Schema::create('staffs', function (Blueprint $table) {
            $table->string('email')->primary()->unique();
            $table->string('name');
            $table->string('password');
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->enum('position', ['admin', 'user', 'staff']);
            $table->enum('gender', ['perempuan', 'laki-laki']);
            $table->tinyinteger('status')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the column
            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });
        Schema::dropIfExists('staffs');
    }
};
