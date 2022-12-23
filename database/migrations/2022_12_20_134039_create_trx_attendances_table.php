<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('master_students')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('presence_type')->references('id')->on('master_attendances')->onDelete('no action')->onUpdate('cascade');
            $table->string('column_name')->nullable();
            $table->char('status')->nullable();
            $table->date('date_presence');
            $table->foreignId('program_id')->references('id')->on('master_academic_programs')->onDelete('no action')->onUpdate('cascade');
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
        Schema::dropIfExists('trx_attendances');
    }
}
