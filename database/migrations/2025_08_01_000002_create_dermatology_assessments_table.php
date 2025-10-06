<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dermatology_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->string('facial_symmetry')->nullable();
            $table->string('skin_quality')->nullable();
            $table->json('measurements')->nullable();
            $table->timestamps();

//            $table->foreign('consultation_id')->references('id')->on('dermatology_consultations')->onDelete('cascade');
//            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('dermatology_assessments');
    }
};
