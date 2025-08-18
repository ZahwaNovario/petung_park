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
        Schema::table('menus', function (Blueprint $table) {
            // Make sure staff_email column exists before removing it
            if (Schema::hasColumn('menus', 'staff_email')) {
                $table->dropForeign(['staff_email']); // Drop foreign key if it exists
                $table->dropColumn('staff_email');    // Drop the staff_email column
            }

            // Add user_id column and foreign key
            $table->unsignedBigInteger('user_id')->after('id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            // Make sure user_id column exists before removing it
            if (Schema::hasColumn('menus', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // Add back the staff_email column and foreign key
            if (!Schema::hasColumn('menus', 'staff_email')) {
                $table->string('staff_email', 255)->after('id'); // Ensure same type as 'email' in staffs
                $table->foreign('staff_email')->references('email')->on('staffs')->onDelete('cascade');
            }
        });
    }
};
