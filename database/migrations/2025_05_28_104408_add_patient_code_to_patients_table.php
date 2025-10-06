<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'patient_code')) {
                $table->dropColumn('patient_code');
            }
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->string('patient_code')->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('patient_code');
        });
    }
};
 