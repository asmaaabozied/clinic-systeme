<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dermatology_image_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->timestamps();

        });
    }
    public function down()
    {
        Schema::dropIfExists('dermatology_image_analyses');
    }
};
