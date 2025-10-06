<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentChargesTable extends Migration
{
    public function up()
    { 
        Schema::create('appointment_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_category_id')->constrained('charge_categories')->onDelete('cascade');
            $table->foreignId('tax_id')->constrained('taxes')->onDelete('cascade');

            $table->string('charge_type');
            $table->string('unit_type')->nullable();
            $table->string('charge_name');

            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('standard_charge', 10, 2);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_charges');
    }
}
