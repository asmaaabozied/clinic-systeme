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
    Schema::table('patients', function (Blueprint $table) {
        $table->string('first_name')->after('id');
        $table->string('last_name')->after('first_name');
        $table->string('email')->nullable()->after('last_name');
        $table->string('phone')->nullable()->after('email');
        $table->enum('gender', ['male', 'female'])->nullable()->after('phone');
        $table->date('birth_date')->nullable()->after('gender');
        $table->text('address')->nullable()->after('birth_date');
        $table->string('blood_type')->nullable()->after('address');
        $table->text('note')->nullable()->after('blood_type');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
            'first_name',
            'last_name',
            'email',
            'phone',
            'gender',
            'birth_date',
            'address',
            'blood_type',
            'note',
        ]);
        });
    }
};
