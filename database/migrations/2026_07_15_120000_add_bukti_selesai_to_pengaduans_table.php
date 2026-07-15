<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('bukti_selesai_path')->nullable()->after('alasan_tolak');
            $table->string('bukti_selesai_nama')->nullable()->after('bukti_selesai_path');
            $table->string('bukti_selesai_tipe')->nullable()->after('bukti_selesai_nama');
            $table->unsignedInteger('bukti_selesai_ukuran')->nullable()->after('bukti_selesai_tipe');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['bukti_selesai_path', 'bukti_selesai_nama', 'bukti_selesai_tipe', 'bukti_selesai_ukuran']);
        });
    }
};
