<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCaseTypeColumnInAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
          
            $table->dropColumn('case_type');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('case')->nullable()->after('appointment_date'); 
        });
    }
 
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('case');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('case_type', ['normal', 'emergency'])->default('normal');
        });
    }
}
