<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checkup_charge_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id')->nullable();
            $table->unsignedBigInteger('charge_id')->nullable();
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
        Schema::dropIfExists('checkup_charge_items');
    }
};
