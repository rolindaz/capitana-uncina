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
        Schema::create('yarns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('brand', 255);
            $table->string('collection', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->integer('ply')->nullable();
            $table->integer('unit_weight')->nullable();
            $table->integer('meterage')->nullable();
            $table->integer('fiber_types_number')->default(1)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->decimal('min_hook_size')->nullable();
            $table->decimal('max_hook_size')->nullable();
            $table->decimal('min_needle_size')->nullable();
            $table->decimal('max_needle_size')->nullable();
            $table->timestamps();
            $table->unique(['id', 'name']);
            $table->unique(['id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarns');
    }
};
