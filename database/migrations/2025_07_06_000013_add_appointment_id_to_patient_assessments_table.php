<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable()->after('patient_id');
      });
    }

    public function down(): void
    {
        Schema::table('patient_assessments', function (Blueprint $table) {
           $table->dropColumn('appointment_id');
        });
    }
};
