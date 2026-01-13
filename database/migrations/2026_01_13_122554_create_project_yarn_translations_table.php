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
        Schema::create('project_yarn_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_yarn_id')->constrained('project_yarn');
            $table->string('locale', 5);
            $table->string('colorway', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_yarn_translations');
    }
};
