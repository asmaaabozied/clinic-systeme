<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('doctor_id');
            $table->string('title');
            $table->enum('stage', ['pre-op', 'procedure', 'follow-up', 'completed'])->default('pre-op');
            $table->json('procedures')->nullable();
            $table->decimal('estimated_cost', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('estimated_completion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_treatment_plans');
    }
};
