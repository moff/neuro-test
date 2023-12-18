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
        // !!! NOTE:
        // I decided that since we have one-to-one relationship between sessions ans scores,
        // it will be easier and faster to have all that data in one table, so it works faster (less requests)

        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); // primary key "id" instead of "sessions_id"

            // I used standard uns int here, maybe smaller is needed, it depends
            $table->unsignedInteger('score');
            $table->unsignedInteger('score_normalized');
            $table->unsignedInteger('start_difficulty');
            $table->unsignedInteger('end_difficulty');

            $table->unsignedBigInteger('course_id'); // much prefer full name for clarity
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->restrictOnDelete(); // setting restriction explicitly

            $table->unsignedBigInteger('user_id'); // much prefer full name for clarity
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete(); // setting restriction explicitly

            // I kept both timestamps, if we need to optimize space used, then we can create only one
            // I'm not sure if I should use Unix timestamp (integer column) instead of the default, it depends
            $table->timestamps();

            // Since we plan to have A LOT of entries in this table AND we plan to order by timestamp,
            // We really need to index timestamp column
            // I chose compound index in this case, because we are going to show latest sessions OF USER
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
