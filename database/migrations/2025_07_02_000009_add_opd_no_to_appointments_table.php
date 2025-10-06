<?php

use App\Models\Appointment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('opd_no')->nullable()->after('id');
        });

        Appointment::query()->each(function ($appointment) {
            $appointment->opd_no = 'OPD-' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT);
            $appointment->save();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('opd_no');
        });
    }
};
