<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->references('id')->on('master_teachers')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('course_id')->references('id')->on('master_courses')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('class_id')->references('id')->on('master_classes')->onDelete('no action')->onUpdate('cascade');
            $table->string('day', 20);
            $table->string('time', 20);
            $table->foreignId('id_period')->nullable()->references('id')
                ->on('master_periods')->onDelete('no action')->onUpdate('cascade');
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
        Schema::dropIfExists('trx_schedules');
    }
}
