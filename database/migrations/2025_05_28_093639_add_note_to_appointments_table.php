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
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('note')->nullable()->after('known_allergies'); 
            
            });
    }
 
     public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
