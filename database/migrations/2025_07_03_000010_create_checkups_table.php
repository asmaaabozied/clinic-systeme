<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->string('checkup_number')->unique();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('consultant_doctor_id')->nullable();
            $table->unsignedBigInteger('charge_category_id')->nullable();
            $table->foreignId('charge_id')->nullable()->constrained('charges')->nullOnDelete();
            $table->string('symptoms_type')->nullable();
            $table->string('symptoms_title')->nullable();
            $table->text('symptoms_description')->nullable();
            $table->text('known_allergies')->nullable();
            $table->text('previous_medical_issues')->nullable();
            $table->date('checkup_date');
            $table->time('checkup_time')->nullable();
            $table->string('case')->nullable();
            $table->boolean('casualty')->default(false);
            $table->boolean('old_patient')->default(false);
            $table->string('old_patient_id')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('apply_tpa')->default(false);
            $table->boolean('live_consultation')->default(false);
            $table->text('note')->nullable();
            $table->text('symptoms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
