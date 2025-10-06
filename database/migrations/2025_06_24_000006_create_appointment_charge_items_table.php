<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_charge_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('appointment_id')->nullable();
            $table->unsignedInteger('charge_id')->nullable();
            $table->decimal('standard_charge', 10, 2);
            $table->decimal('applied_charge', 10, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('tax', 5, 2)->default(0);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_charge_items');
    }
};
