<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (Schema::hasColumn('doctors', 'doctor_code')) {
                $table->dropColumn('doctor_code');
            }
        });
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('doctor_code')->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('doctor_code');
        });
    }
};
