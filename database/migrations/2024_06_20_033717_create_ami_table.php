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
        Schema::create('ami', function (Blueprint $table) {
            $table->id();
            $table->string('capaian')->nullable();
            $table->string('keterangan_capaian')->nullable();
            $table->text('faktor_penghambat')->nullable();
            $table->text('faktor_pendukung')->nullable();
            $table->text('keterangan_peningkatan')->nullable();
            $table->dateTime('tanggal_audit')->nullable();
            $table->string('user_audit')->nullable();

            $table->unsignedBigInteger('standar_id');
            $table->foreign('standar_id')->references('id')->on('standars')->cascadeOnDelete();

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
        Schema::dropIfExists('ami');
    }
};
