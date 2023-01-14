<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->references('id')
                ->on('master_students')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('class_id')->nullable()->references('id')
                ->on('master_classes')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('course_id')->nullable()->references('id')->on('master_courses')
                ->onDelete('set null')->onUpdate('cascade');
            $table->char('score', 50)->nullable();
            $table->foreignId('user_id')->nullable()->references('id')
                ->on('master_users')->onDelete('set null')->onUpdate('cascade');
            $table->date('date_assesment');
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
        Schema::dropIfExists('trx_scores');
    }
};
