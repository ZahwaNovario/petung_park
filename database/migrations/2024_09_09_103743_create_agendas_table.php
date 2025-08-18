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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->date('event_start_date');
            $table->date('event_end_date');
            $table->string('event_location');
            $table->tinyinteger('status')->default(0);
            $table->longtext('description')->nullable();
            $table->timestamps();
            
            $table->string('staff_email');
            // Explicitly name the foreign key constraint
            $table->foreign('staff_email', 'agendas_staff_email_foreign')
                ->references('email')->on('staffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Dynamically fetch the foreign key name for 'staff_email' and drop it
            $foreignKeyName = DB::select(
                "SELECT CONSTRAINT_NAME
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_NAME = 'agendas' 
                 AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                 AND COLUMN_NAME = 'staff_email'"
            );

            // Drop the foreign key constraint if it exists
            if (!empty($foreignKeyName)) {
                $table->dropForeign($foreignKeyName[0]->CONSTRAINT_NAME);
            }

            // Drop the column after dropping the foreign key, if the column exists
            if (Schema::hasColumn('agendas', 'staff_email')) {
                $table->dropColumn('staff_email');
            }
        });

        // Drop the 'agendas' table
        Schema::dropIfExists('agendas');
    }
};
