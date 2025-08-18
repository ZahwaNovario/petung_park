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
        Schema::create('generic', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->tinyinteger('status')->default(0);
            $table->longtext('icon_picture_link');
            $table->timestamps();
            $table->string('staff_email');
            $table->index('staff_email');
            
            // Define the foreign key with a name for later reference
            $table->foreign('staff_email', 'generic_staff_email_foreign')
                ->references('email')->on('staffs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check for the foreign key constraint dynamically and drop it if exists
        Schema::table('generic', function (Blueprint $table) {
            // Check if the 'staff_email' column exists
            if (Schema::hasColumn('generic', 'staff_email')) {
                // Drop the foreign key by the dynamically fetched name
                $foreignKeyName = DB::select(
                    "SELECT CONSTRAINT_NAME
                     FROM information_schema.KEY_COLUMN_USAGE
                     WHERE TABLE_NAME = 'generic' 
                     AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                     AND COLUMN_NAME = 'staff_email'"
                );

                if (!empty($foreignKeyName)) {
                    $table->dropForeign($foreignKeyName[0]->CONSTRAINT_NAME); // Drop foreign key constraint by actual name
                }

                $table->dropColumn('staff_email');
            }
        });
        
        // Drop the entire table
        Schema::dropIfExists('generic');
    }
};
