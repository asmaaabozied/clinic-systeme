<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('visit_type_id')->nullable();
            $table->string('diagnosis')->nullable();
            $table->date('visit_date');
            $table->time('visit_time');
            $table->string('status')->default('scheduled');
            $table->timestamps();

//            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
//            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
//            $table->foreign('visit_type_id')->references('id')->on('visit_types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
