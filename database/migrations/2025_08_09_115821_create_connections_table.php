<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scene_from')->constrained('scenes')->cascadeOnDelete();
            $table->foreignId('scene_to')->constrained('scenes')->cascadeOnDelete();
            $table->float('pitch')->nullable();
            $table->float('yaw')->nullable();
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
