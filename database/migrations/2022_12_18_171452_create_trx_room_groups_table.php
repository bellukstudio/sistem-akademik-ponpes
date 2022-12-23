<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxRoomGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_room_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->references('id')->on('master_rooms')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('student_id')->references('id')->on('master_students')->onDelete('no action')->onUpdate('cascade');
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
        Schema::dropIfExists('trx_room_groups');
    }
}
