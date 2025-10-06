<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // هنضيف الأعمدة بعد الـ id مباشرة
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->after('id');

            $table->foreignId('specialization_id')
                ->nullable()
                ->constrained('doctor_specializations')
                ->onDelete('set null')
                ->after('user_id');

            $table->text('bio')->nullable()->after('specialization_id');
            $table->integer('experience_years')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('experience_years');
            $table->string('clinic_address')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['specialization_id']);
            $table->dropColumn('specialization_id');

            $table->dropColumn(['bio', 'experience_years', 'phone', 'clinic_address']);
        });
    }
};
