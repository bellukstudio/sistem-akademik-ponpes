<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxStudentPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_student_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')
                ->on('master_students')->onDelete('no action')->onUpdate('cascade');
            $table->text('description');
            $table->date('permit_date');
            $table->string('permit_type');
            $table->foreignId('id_program')->references('id')
                ->on('master_academic_programs')->onDelete('no action')->onUpdate('cascade');
            $table->boolean('status')->nullable();
            $table->foreignId('id_period')->nullable()->references('id')
                ->on('master_periods')->onDelete('no action')->onUpdate('cascade');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_student_permits');
    }
}
