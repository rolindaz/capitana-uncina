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
        Schema::create('yarn_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yarn_standard_id')
            ->constrained('yarn_standards');
            $table->string('base_key', 255);
            $table->string('key', 255);
            $table->string('name', 255);
            $table->integer('ply')
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarn_types');
    }
};
