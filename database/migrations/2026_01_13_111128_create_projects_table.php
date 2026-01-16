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
            $table->foreignId('category_id')->constrained('categories');
            $table->string('image_path', 255)->nullable();
            $table->date('started')->nullable();
            $table->date('completed')->nullable();
            $table->integer('execution_time');
            $table->string('pattern_name', 255)->nullable();
            $table->string('pattern_url', 2048)->nullable();
            $table->string('size', 10)->nullable();
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
