<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('medicines', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
        });
        Schema::table('medicine_categories', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
        });
        Schema::table('doctors', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
        });  
        Schema::table('doctor_specializations', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('medicine_categories', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('doctor_specializations', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
};
