<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dermatology_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->text('treatment_recommendations')->nullable();
            $table->text('alternative_options')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->string('recovery_time')->nullable();
            $table->timestamps();

//            $table->foreign('consultation_id')->references('id')->on('dermatology_consultations')->onDelete('cascade');
//            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('dermatology_recommendations');
    }
};
