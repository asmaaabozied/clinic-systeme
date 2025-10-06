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
        Schema::table('product_services', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('code')->nullable();
            $table->string('quantity2')->nullable();
            $table->string('img')->nullable();
            $table->string('weight')->nullable();
            $table->string('field1')->nullable();
            $table->string('field2')->nullable();
            $table->string('field3')->nullable();
            $table->string('field4')->nullable();
            $table->string('vat')->nullable();
            $table->string('type_sales')->nullable();
            $table->string('type_product')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_not')->nullable();
            $table->string('percentage')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('image2')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_services', function (Blueprint $table) {
            //
        });
    }
};
