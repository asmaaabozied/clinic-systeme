<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    { 
        Schema::create('charge_type_module', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_type_id')->constrained('charge_types')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['charge_type_id', 'module_id']); // لتجنب التكرار
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charge_type_module');
    }
};
