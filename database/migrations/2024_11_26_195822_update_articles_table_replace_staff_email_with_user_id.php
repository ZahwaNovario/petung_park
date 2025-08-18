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
        Schema::table('articles', function (Blueprint $table) {
            // Drop the existing foreign key and column if they exist
            if (Schema::hasColumn('articles', 'staff_email')) {
                $table->dropForeign(['staff_email']);
                $table->dropColumn('staff_email');
            }
    
            // Add the new user_id column and foreign key
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
        Schema::table('articles', function (Blueprint $table) {
            // Drop the new foreign key and column if they exist
            if (Schema::hasColumn('articles', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
    
            // Add back the staff_email column and foreign key
            if (!Schema::hasColumn('articles', 'staff_email')) {
                $table->string('staff_email')->after('id');
                $table->foreign('staff_email')->references('email')->on('staffs')->onDelete('cascade');
            }
        });
    }
    
};
