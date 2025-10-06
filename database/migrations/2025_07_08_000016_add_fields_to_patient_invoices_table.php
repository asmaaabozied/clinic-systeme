<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patient_invoices', function (Blueprint $table) {
            $table->string('invoice_no')->nullable()->unique();
            $table->boolean('is_paid')->default(false);
        });
    }

    public function down()
    {
        Schema::table('patient_invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_no', 'is_paid']);
        });
    }
};
