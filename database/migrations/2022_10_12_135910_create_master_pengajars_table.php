<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPengajarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_pengajar', function (Blueprint $table) {
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
            $table->char('no_tlp', 30)->nullable();
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
        Schema::dropIfExists('master_pengajar');
    }
}
