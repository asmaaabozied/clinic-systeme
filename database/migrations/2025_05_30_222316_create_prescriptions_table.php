<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->text('header_note')->nullable();
            $table->text('finding_description')->nullable();
            $table->string('finding_print')->nullable();
            $table->text('footer_note')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('pathology_id')->nullable()->constrained('pathologies');
            $table->foreignId('radiology_id')->nullable()->constrained('radiologies');
            $table->boolean('is_printed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
