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
        Schema::create('colorway_yarn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colorway_id')
            ->nullable()
            ->constrained();
            $table->foreignId('yarn_id')
            ->constrained();
            $table->foreignId('production_status_id')
            ->nullable()
            ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colorway_yarn');
    }
};
