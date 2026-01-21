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
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->string('locale', 5);
            $table->string('name', 255);
            $table->longText('notes');
            $table->string('status', 255);
            $table->string('destination_use', 255)->nullable();
            $table->string('slug', 255);
            $table->unique(['project_id', 'locale']);
            $table->unique(['locale', 'name']);
            $table->unique(['locale', 'slug']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_translations');
    }
};
