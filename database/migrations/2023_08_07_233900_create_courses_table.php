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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug');
            $table->string('description', 180);
            $table->string('difficulty_level', 20);
            $table->integer('duration')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('new');
            $table->boolean('free');
            $table->decimal('price');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('language_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
