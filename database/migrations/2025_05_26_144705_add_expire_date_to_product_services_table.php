<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpireDateToProductServicesTable extends Migration
{
    public function up()
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->date('expire_date')->nullable();
        });
    } 

    public function down()
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->dropColumn('expire_date');
        });
    }
}
