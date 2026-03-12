<?php
// ═══════════════════════════════════════════════════════════
// FILE: database/migrations/xxxx_add_columns_to_kategoris.php
// Jalankan: php artisan migrate
// ═══════════════════════════════════════════════════════════
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            if (!Schema::hasColumn('kategoris', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('kategoris', 'urutan')) {
                $table->integer('urutan')->default(0)->after('deskripsi');
            }
            if (!Schema::hasColumn('kategoris', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('urutan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'urutan', 'is_active']);
        });
    }
};