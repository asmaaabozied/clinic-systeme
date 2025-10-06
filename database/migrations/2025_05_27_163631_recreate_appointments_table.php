<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Drop the table if it already exists
        Schema::dropIfExists('appointments');
 
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');

            $table->foreignId('consultant_doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('charge_category_id')->nullable()->constrained('charge_categories')->nullOnDelete();
            $table->foreignId('charge_id')->nullable()->constrained('charges')->nullOnDelete();

            $table->string('symptoms_type')->nullable();
            $table->string('symptoms_title')->nullable();
            $table->text('symptoms_description')->nullable();
            $table->text('known_allergies')->nullable();
            $table->text('previous_medical_issues')->nullable();
            $table->date('appointment_date');
            $table->enum('case_type', ['normal', 'emergency'])->default('normal');
            $table->boolean('casualty')->default(false);
            $table->boolean('old_patient')->default(false);
            $table->string('old_patient_id')->nullable();
            $table->string('reference')->nullable();

            $table->boolean('apply_tpa')->default(false);
            $table->boolean('live_consultation')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
