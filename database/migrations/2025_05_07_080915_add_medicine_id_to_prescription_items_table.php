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
    Schema::table('prescription_items', function (Blueprint $table) {
        $table->unsignedBigInteger('medicine_id')->nullable()->after('prescription_id');

        // If you want to enforce FK constraint:
        $table->foreign('medicine_id')->references('id')->on('medications')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            //
        });
    }
};
