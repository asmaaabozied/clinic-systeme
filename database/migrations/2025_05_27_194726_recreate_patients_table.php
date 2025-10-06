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
        // Drop the table if it exists before creating it
        Schema::dropIfExists('patients');

        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('alternate_phone')->nullable();
            $table->string('national_id')->nullable();
            $table->string('guardian_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');

            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('address')->nullable();
            $table->string('remarks')->nullable();
            $table->string('photo')->nullable();
            $table->string('allergies')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('patients');
    }
};
