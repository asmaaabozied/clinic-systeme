<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medical_consultation_service_items', function (Blueprint $table) {
            $table->boolean('is_paid')->default(true)->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('medical_consultation_service_items', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
    }
};
