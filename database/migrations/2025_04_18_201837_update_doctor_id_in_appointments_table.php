<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDoctorIdInAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->bigInteger('doctor_id')->unsigned()->nullable(false)->change(); // Ensure doctor_id is not nullable
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->bigInteger('doctor_id')->nullable()->change(); // Revert nullable status if needed
        });
    }
}
