<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('dermatology_consultations')) return;
        Schema::create('dermatology_consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->text('chief_complaint')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('physical_exam')->nullable();
            $table->json('procedures_discussed')->nullable();
            $table->timestamps();

//            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('dermatology_consultations');
    }
};
