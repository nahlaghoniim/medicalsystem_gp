<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePillboxSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pillbox_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pillbox_id');
            $table->unsignedBigInteger('medication_id');
            $table->integer('slot_number');
            $table->string('dosage');
            $table->time('time');
            $table->json('days_of_week'); // Example: ["Mon", "Wed", "Fri"]
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('pillbox_id')->references('id')->on('pillboxes')->onDelete('cascade');
            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pillbox_schedules');
    }
}
