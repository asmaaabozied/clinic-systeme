<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class AddNameArToChartOfAccountTypesTable extends Migration
{
    public function up()
    {
        Schema::table('chart_of_account_types', function (Blueprint $table) {
            $table->string('name_ar')->nullable();
        });
    }

    public function down()
    {
        Schema::table('chart_of_account_types', function (Blueprint $table) {
            $table->dropColumn('name_ar');
        });
    }
}
