<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_students', function (Blueprint $table) {
            $table->id();
            $table->string('noId', 50);
            $table->string('email')->unique();
            $table->string('name');
            $table->text('photo')->nullable();
            $table->char('gender')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('province_id')->nullable()->references('id')->on('master_provinces')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('city_id')->nullable()->references('id')->on('master_cities')
                ->onDelete('set null')->onUpdate('cascade');
            $table->date('date_birth')->nullable();
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->date('date_birth_father')->nullable();
            $table->date('date_birth_mother')->nullable();
            $table->char('phone', 30)->nullable();
            $table->char('parent_phone', 30)->nullable();
            $table->foreignId('program_id')->nullable()
                ->references('id')->on('master_academic_programs')
                ->onDelete('set null')->onUpdate('cascade');
            $table->char('entry_year', 10)->nullable();
            // $table->foreignId('period_id')->nullable()->references('id')
            //     ->on('master_periods')->onDelete('set null')->onUpdate('cascade');
            ///
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
        Schema::dropIfExists('master_students');
    }
}
