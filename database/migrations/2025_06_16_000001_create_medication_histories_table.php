<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_medication_id');
            $table->timestamp('taken_at')->nullable();
            $table->string('status')->default('taken');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_histories');
    }
};
