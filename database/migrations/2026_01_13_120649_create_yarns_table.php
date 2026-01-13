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
            $table->string('key', 255);
            $table->string('name', 255);
            $table->string('brand', 255);
            $table->string('weight', 255);
            $table->string('category', 255);
            $table->string('color_type', 255);
            $table->integer('ply');
            $table->integer('unit_weight');
            $table->integer('meterage');
            $table->integer('fiber_types_number')->default(1);
            $table->string('image_path', 255);
            $table->decimal('min_hook_size');
            $table->decimal('max_hook_size');
            $table->decimal('min_needle_size');
            $table->decimal('max_needle_size');
            $table->timestamps();
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
