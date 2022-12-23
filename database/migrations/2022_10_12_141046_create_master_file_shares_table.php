<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterFileSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_file_share', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->text('link');
            $table->char('tipe');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('id_user')->nullable()
                ->references('id')->on('master_users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_file_share');
    }
}
