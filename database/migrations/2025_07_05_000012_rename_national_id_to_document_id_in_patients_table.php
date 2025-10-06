<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'national_id') && !Schema::hasColumn('patients', 'document_id')) {
                $table->renameColumn('national_id', 'document_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'document_id') && !Schema::hasColumn('patients', 'national_id')) {
                $table->renameColumn('document_id', 'national_id');
            }
        });
    }
};
