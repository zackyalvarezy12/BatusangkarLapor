<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Fix pengaduan_histories table
            DB::statement('ALTER TABLE pengaduan_histories DROP FOREIGN KEY pengaduan_histories_user_id_foreign');
            DB::statement('ALTER TABLE pengaduan_histories ADD CONSTRAINT pengaduan_histories_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');

            // Fix pengumumans table
            DB::statement('ALTER TABLE pengumumans DROP FOREIGN KEY pengumumans_user_id_foreign');
            DB::statement('ALTER TABLE pengumumans ADD CONSTRAINT pengumumans_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Revert pengaduan_histories
            DB::statement('ALTER TABLE pengaduan_histories DROP FOREIGN KEY pengaduan_histories_user_id_foreign');
            DB::statement('ALTER TABLE pengaduan_histories ADD CONSTRAINT pengaduan_histories_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)');

            // Revert pengumumans
            DB::statement('ALTER TABLE pengumumans DROP FOREIGN KEY pengumumans_user_id_foreign');
            DB::statement('ALTER TABLE pengumumans ADD CONSTRAINT pengumumans_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)');
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
};
