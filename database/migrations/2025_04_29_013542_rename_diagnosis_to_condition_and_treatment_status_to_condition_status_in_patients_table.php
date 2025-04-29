<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'diagnosis') && !Schema::hasColumn('patients', 'condition')) {
                $table->renameColumn('diagnosis', 'condition');
            }

            if (Schema::hasColumn('patients', 'treatment_status') && !Schema::hasColumn('patients', 'condition_status')) {
                $table->renameColumn('treatment_status', 'condition_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'condition')) {
                $table->renameColumn('condition', 'diagnosis');
            }

            if (Schema::hasColumn('patients', 'condition_status')) {
                $table->renameColumn('condition_status', 'treatment_status');
            }
        });
    }
};
