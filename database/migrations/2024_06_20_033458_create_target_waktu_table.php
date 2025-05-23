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
        Schema::create('target_waktu', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_target');
            $table->string('keterangan_target')->nullable();
            $table->unsignedBigInteger('indikator_id');
            $table->foreign('indikator_id')->references('id')->on('indikator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_waktu');
    }
};
