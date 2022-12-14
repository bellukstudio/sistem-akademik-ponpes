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
            $table->string('no_induk', 50);
            $table->string('name', 100);
            $table->foreignId('id_room')->references('id')->on('master_rooms')->onDelete('cascade');
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
