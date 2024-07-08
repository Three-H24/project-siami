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
        Schema::create('dokumen_pendukung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->unsignedBigInteger('indikator_id');
            $table->foreign('indikator_id')->references('id')->on('indikator')->cascadeOnDelete();
            $table->unsignedBigInteger('target_waktu_id');
            $table->foreign('target_waktu_id')->references('id')->on('target_waktu')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pendukung');
    }
};
