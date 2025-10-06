<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_invoice_id');
            $table->unsignedBigInteger('charge_id');
            $table->decimal('standard_charge', 10, 2);
            $table->decimal('applied_charge', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('amount', 10, 2);
            $table->timestamps();

//            $table->foreign('patient_invoice_id')->references('id')->on('patient_invoices')->onDelete('cascade');
//            $table->foreign('charge_id')->references('id')->on('charges')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_invoice_items');
    }
};
