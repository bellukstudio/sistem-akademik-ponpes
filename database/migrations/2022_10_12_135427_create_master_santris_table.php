<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_santri', function (Blueprint $table) {
            $table->id();
            $table->string('no_induk', 50);
            $table->string('email')->unique();
            $table->string('nama');
            $table->text('photo');
            $table->char('jk');
            $table->text('alamat')->nullable();
            $table->integer('id_provinsi')->nullable();
            $table->integer('id_kota')->nullable();
            $table->date('tgl_lahir');
            $table->string('wali_santri', 150)->nullable();
            $table->char('no_tlp', 30)->nullable();
            $table->integer('id_program');
            $table->char('id_tahunAjar', 20);
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
        Schema::dropIfExists('master_santri');
    }
}
