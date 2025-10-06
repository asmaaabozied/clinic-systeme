<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('patient_invoices', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('appointment_id');  
            $table->unsignedBigInteger('patient_id');  
            $table->unsignedBigInteger('charge_category_id');
            $table->unsignedBigInteger('charge_id');
 
            $table->decimal('standardCharge', 10, 2);
            $table->decimal('appliedCharge', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2);
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_method');
            $table->decimal('paidAmount', 10, 2)->default(0);
            $table->boolean('live_consultation')->default(false);

            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('charge_category_id')->references('id')->on('charge_categories')->onDelete('restrict');
            $table->foreign('charge_id')->references('id')->on('charges')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_invoices');
    }
}
