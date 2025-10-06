<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oral_health_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('doctor_id');
            $table->enum('gum_health', ['excellent', 'good', 'fair', 'poor']);
            $table->enum('oral_hygiene', ['excellent', 'good', 'fair', 'poor']);
            $table->json('issues')->nullable();
            $table->json('risk_factors')->nullable();
            $table->json('recommendations')->nullable();
            $table->date('assessment_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oral_health_assessments');
    }
};
