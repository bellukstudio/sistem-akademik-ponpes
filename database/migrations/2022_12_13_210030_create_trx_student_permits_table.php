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
            $table->foreignId('id_user')->references('id')->on('master_users')->onDelete('cascade');
            $table->text('description');
            $table->date('permit_date');
            $table->string('permit_type');
            $table->foreignId('id_program')->references('id')->on('master_academic_programs')->onDelete('cascade');
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
