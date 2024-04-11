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
        Schema::create('monitoring_data', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->integer('duration');
            $table->foreignId('userId')->constrained('users');
            $table->decimal('totalBrightness');
            $table->decimal('totalDistance');
            $table->decimal('totalX');
            $table->decimal('totalY');
            $table->integer('rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_data');
    }
};

