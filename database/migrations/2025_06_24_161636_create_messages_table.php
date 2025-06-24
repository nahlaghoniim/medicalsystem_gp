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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->string('sender_name');
        $table->string('subject');
        $table->text('body');
        $table->boolean('is_read')->default(false);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('messages');
}

};
