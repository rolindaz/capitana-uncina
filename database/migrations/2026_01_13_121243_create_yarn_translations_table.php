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
        Schema::create('yarn_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yarn_id')->constrained();
            $table->string('locale', 5);
            $table->string('color_type', 255)->nullable();
            $table->string('slug', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarn_translations');
    }
};
