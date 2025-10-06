<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->string('code')->nullable()->after('charge_name');
        });
    }

    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
