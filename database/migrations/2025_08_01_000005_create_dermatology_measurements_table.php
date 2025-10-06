<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('dermatology_measurements')) return;
        Schema::create('dermatology_measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->string('name');
            $table->float('value');
            $table->string('unit')->nullable();
            $table->timestamps();

//            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
//            $table->foreign('consultation_id')->references('id')->on('dermatology_consultations')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::dropIfExists('dermatology_measurements');
    }
};
