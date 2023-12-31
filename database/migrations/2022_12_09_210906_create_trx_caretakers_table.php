<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxCaretakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_caretakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')
                ->on('master_users')->onDelete('no action')->onUpdate('cascade');
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->foreignId('program_id')->references('id')
                ->on('master_academic_programs')->onDelete('no action')->onUpdate('cascade');
            $table->string('categories', 20);
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
        Schema::dropIfExists('trx_caretakers');
    }
}
