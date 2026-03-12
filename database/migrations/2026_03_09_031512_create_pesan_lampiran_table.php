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
        Schema::create('pesan_lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesan_id')->constrained('pesan_laporan')->cascadeOnDelete();
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('tipe_file'); // image/pdf/doc dll
            $table->unsignedBigInteger('ukuran')->default(0); // bytes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_lampiran');
    }
};
