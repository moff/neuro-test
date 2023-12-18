<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercise_session', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('exercise_id');

            $table->index('session_id');
            $table->index('exercise_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_session');
    }
};
