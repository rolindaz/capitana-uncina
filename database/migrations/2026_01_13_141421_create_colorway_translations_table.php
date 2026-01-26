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
        Schema::create('colorway_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colorway_id')->constrained('colorways');
            $table->string('locale', 5);
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('production_status', 255)->nullable();
            $table->timestamps();
            $table->unique(['colorway_id', 'locale']);
            $table->unique(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colorway_translations');
    }
};
