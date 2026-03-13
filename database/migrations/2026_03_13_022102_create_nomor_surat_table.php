<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomor_surats', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // 'admin' atau 'petugas'
            $table->integer('nomor')->default(0);
            $table->integer('bulan');
            $table->integer('tahun');
            $table->timestamps();
            $table->unique(['jenis', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surats');
    }
};