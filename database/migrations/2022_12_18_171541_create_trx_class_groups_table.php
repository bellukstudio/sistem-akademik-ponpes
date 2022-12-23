<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxClassGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_class_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('master_students')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('class_id')->references('id')->on('master_classes')->onDelete('no action')->onUpdate('cascade');
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
        Schema::dropIfExists('trx_class_groups');
    }
}
