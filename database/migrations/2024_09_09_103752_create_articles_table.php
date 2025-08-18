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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longtext('main_content');
            $table->tinyinteger('status')->default(0);
            $table->string('staff_email');  // Make sure staff_email matches the type of `email` in `staffs`
            $table->unsignedBigInteger('agenda_id');  // Ensure the type matches the type of `id` in `agendas`
            $table->timestamps();
            
            // Explicitly index the columns before setting foreign keys
            $table->index('staff_email');
            $table->index('agenda_id');

            // Explicitly name the foreign key constraints to handle them later
            $table->foreign('staff_email', 'articles_staff_email_foreign')
                ->references('email')->on('staffs')->onDelete('cascade');
            $table->foreign('agenda_id', 'articles_agenda_id_foreign')
                ->references('id')->on('agendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Dynamically fetch the foreign key names to safely drop them
            $foreignKeyName1 = DB::select(
                "SELECT CONSTRAINT_NAME
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_NAME = 'articles' 
                 AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                 AND COLUMN_NAME = 'staff_email'"
            );

            // Drop the foreign key constraint if it exists
            if (!empty($foreignKeyName1)) {
                $table->dropForeign($foreignKeyName1[0]->CONSTRAINT_NAME);
            }

            $foreignKeyName2 = DB::select(
                "SELECT CONSTRAINT_NAME
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_NAME = 'articles' 
                 AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                 AND COLUMN_NAME = 'agenda_id'"
            );

            // Drop the foreign key constraint if it exists
            if (!empty($foreignKeyName2)) {
                $table->dropForeign($foreignKeyName2[0]->CONSTRAINT_NAME);
            }

            // Drop the columns
            $table->dropColumn('staff_email');
            $table->dropColumn('agenda_id');
        });

        // Drop the table after removing the columns and foreign keys
        Schema::dropIfExists('articles');
    }
};
