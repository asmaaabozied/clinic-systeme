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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->date('date')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('total')->nullable();
            $table->string('vat')->nullable();
            $table->string('type')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
