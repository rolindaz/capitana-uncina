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
        Schema::create('craft_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('craft_id')->constrained('crafts');
            $table->string('locale', 5);
            $table->string('name', 255);
            $table->text('description');
            $table->string('slug', 255);
            $table->timestamps();
            $table->unique(['craft_id', 'locale']);
            $table->unique(['locale', 'name']);
            $table->unique(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craft_translations');
    }
};
