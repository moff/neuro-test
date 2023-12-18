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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id(); // primary key "id" instead of "exercise_id"
            $table->string('name');
            $table->unsignedInteger('points'); // I used standard uns int here, maybe smaller is needed

            $table->unsignedBigInteger('course_id'); // much prefer full name for clarity
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->restrictOnDelete(); // setting restriction explicitly

            $table->unsignedBigInteger('category_id'); // much prefer full name for clarity
            $table->foreign('category_id')
                ->references('id')
                ->on('domain_categories')
                ->restrictOnDelete(); // setting restriction explicitly

            // !!! NOTE: I don't set indexes on FK columns, because in MySQL it's automatically done
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
