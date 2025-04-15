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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Patient ID
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            
            // Doctor ID - this should reference the `users` table, not `doctors`
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            
            // Appointment date
            $table->datetime('appointment_date');
            
            // Appointment status
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            
            // Timestamps
            $table->timestamps();
        });
    }
    

};
