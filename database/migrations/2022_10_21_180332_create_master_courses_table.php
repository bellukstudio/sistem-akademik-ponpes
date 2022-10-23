<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('program_id')->nullable()->references('id')->on('master_academic_programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_courses');
    }
}
