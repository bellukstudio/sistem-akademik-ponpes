<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxPicketSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_picket_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('master_students')->onDelete('cascade');
            $table->string('time', 20);
            $table->foreignId('room_id')->references('id')->on('master_rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_picket_schedules');
    }
}
