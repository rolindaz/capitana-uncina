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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->string('pattern_name', 255);
            $table->string('pattern_url', 2048);
            $table->foreignId('category_id')->constrained('categories');
            $table->string('image_path', 255);
            $table->date('started');
            $table->date('completed');
            $table->integer('execution_time');
            $table->string('size', 10);
            $table->boolean('correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
