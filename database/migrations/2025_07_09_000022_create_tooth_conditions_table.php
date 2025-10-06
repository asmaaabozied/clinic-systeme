<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tooth_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedTinyInteger('tooth_number');
            $table->enum('condition', ['healthy', 'decay', 'filling', 'crown', 'missing', 'implant', 'root-canal']);
            $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable();
            $table->text('notes')->nullable();
            $table->date('date');
            $table->json('images')->nullable();
            $table->timestamps();
            $table->unique(['patient_id', 'tooth_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tooth_conditions');
    }
};
