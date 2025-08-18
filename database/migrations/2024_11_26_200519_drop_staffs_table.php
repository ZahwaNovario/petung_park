<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the 'staffs' table
        Schema::dropIfExists('staffs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate the 'staffs' table
        Schema::create('staffs', function (Blueprint $table) {
            $table->string('email');
            $table->string('name');
            $table->string('password');
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->enum('position', ['admin', 'user', 'staff']);
            $table->enum('gender', ['perempuan', 'laki-laki'])->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }
};
