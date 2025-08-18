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
        Schema::table('agendas', function (Blueprint $table) {
            // Drop the foreign key and column for staff_email
            $table->dropForeign(['staff_email']); // Drop the foreign key constraint
            $table->dropColumn('staff_email');   // Remove the column

            // Add the user_id column and foreign key
            $table->unsignedBigInteger('user_id')->after('id')->nullable(); // Replace 'id' with the correct column order if needed
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
        Schema::table('agendas', function (Blueprint $table) {
            // Drop the foreign key and column for user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Add the staff_email column and foreign key
            // $table->string('staff_email')->after('id'); // Replace 'id' with the correct column order if needed
            // $table->foreign('staff_email')->references('email')->on('staffs')->onDelete('cascade');
        });
    }
};

