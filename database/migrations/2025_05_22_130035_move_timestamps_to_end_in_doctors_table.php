<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // تعديل ترتيب الأعمدة باستخدام Raw SQL (MySQL only)
        DB::statement("
            ALTER TABLE doctors 
            MODIFY created_at TIMESTAMP NULL DEFAULT NULL AFTER clinic_address,
            MODIFY updated_at TIMESTAMP NULL DEFAULT NULL AFTER created_at
        ");
    }

    public function down(): void
    {
        // رجّعهم زي مكانوا بعد id (اختياري)
        DB::statement("
            ALTER TABLE doctors 
            MODIFY created_at TIMESTAMP NULL DEFAULT NULL AFTER id,
            MODIFY updated_at TIMESTAMP NULL DEFAULT NULL AFTER created_at
        ");
    }
};