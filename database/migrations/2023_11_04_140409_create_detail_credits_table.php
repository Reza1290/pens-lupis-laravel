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
        Schema::create('detail_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credits_id')->constrained('credits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_credits');
    }
};
