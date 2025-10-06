<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_investigation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_investigation_id');
            $table->string('parameter');
            $table->string('result')->nullable();
            $table->string('normal_range')->nullable();
            $table->string('unit')->nullable();
            $table->string('status')->nullable();
            $table->date('date');
            $table->timestamps();
            // Foreign keys omitted for compatibility
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_investigation_results');
    }
};
