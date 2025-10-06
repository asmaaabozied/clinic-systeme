<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->string('consultation_type')->default('instant'); // instant, scheduled
            $table->text('reason')->nullable();
            $table->datetime('scheduled_at')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('ended_at')->nullable();
            $table->integer('duration')->default(0); // in minutes
            $table->string('status')->default('scheduled'); // scheduled, active, completed, cancelled, no_show
            $table->string('zoom_meeting_id')->nullable();
            $table->string('zoom_start_url')->nullable();
            $table->string('zoom_join_url')->nullable();
            $table->string('zoom_password')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('recording_id')->nullable();
            $table->text('notes')->nullable();
            $table->text('prescription')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('recommendations')->nullable();
            $table->boolean('is_recorded')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->decimal('amount', 10, 2)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_consultations');
    }
};
