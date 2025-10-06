<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('charge_type_id')->constrained('charge_types')->onDelete('cascade');
            $table->foreignId('charge_category_id')->constrained('charge_categories')->onDelete('cascade');
            $table->foreignId('unit_type_id')->constrained('unit_types')->onDelete('cascade');
            $table->string('charge_name');
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->onDelete('cascade');
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('standard_charge', 10, 2);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
