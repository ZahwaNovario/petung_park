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
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable(false); 
            $table->string('phone_number')->nullable(false); 
            $table->enum('position', ['Admin', 'User', 'Staff'])->nullable(false); 
            $table->enum('gender', ['Perempuan', 'Laki-laki'])->nullable(false);
            $table->tinyInteger('status')->default(0); 
            $table->unsignedBigInteger('gallery_id'); 
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gallery_id']); 
            $table->dropColumn([
                'date_of_birth',
                'phone_number',
                'position',
                'gender',
                'status',
                'gallery_id',
            ]);
        });
    }
};
