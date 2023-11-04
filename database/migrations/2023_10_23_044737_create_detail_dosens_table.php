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
        Schema::create('detail_dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->foreignId('users_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_dosens');
    }
};
