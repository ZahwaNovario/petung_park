<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longtext('description');
            $table->double('price', 15, 2);
            $table->tinyinteger('status')->default(0);
            $table->tinyinteger('status_recommended')->default(0);
            $table->integer('number_love')->nullable();
            $table->timestamps();
            
            $table->string('staff_email');

            $table->index('staff_email');

            $table->foreign('staff_email', 'menus_staff_email_foreign')
                ->references('email')->on('staffs')->onDelete('cascade');            
            $table->unsignedBigInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
           
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Dynamically fetch the foreign key name for 'staff_email' and drop it
            if (Schema::hasColumn('menus', 'staff_email')) {
                $foreignKeyName = DB::select(
                    "SELECT CONSTRAINT_NAME
                     FROM information_schema.KEY_COLUMN_USAGE
                     WHERE TABLE_NAME = 'menus' 
                     AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                     AND COLUMN_NAME = 'staff_email'"
                );

                // Drop the foreign key if it exists
                if (!empty($foreignKeyName)) {
                    $table->dropForeign($foreignKeyName[0]->CONSTRAINT_NAME);
                }

                $table->dropColumn('staff_email');
            }

            // Drop the foreign keys for 'gallery_id' and 'category_id'
            $table->dropForeign(['gallery_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['gallery_id', 'category_id']);
        });

        // Drop the table after cleaning up columns and foreign keys
        Schema::dropIfExists('menus');
    }
};
