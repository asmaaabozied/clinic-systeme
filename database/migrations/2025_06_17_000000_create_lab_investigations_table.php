<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_investigations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('test_name');
            $table->date('test_date');
            $table->string('lab')->nullable();
            $table->dateTime('sample_collected_at')->nullable();
            $table->date('expected_date')->nullable();
            $table->string('status')->default('processing');
            $table->text('result')->nullable();
            $table->boolean('abnormal')->default(false);
            $table->timestamps();
            // Foreign keys are intentionally omitted to keep compatibility
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_investigations');
    }
};
