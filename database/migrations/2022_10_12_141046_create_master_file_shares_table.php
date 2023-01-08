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
        Schema::create('master_file_shares', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->text('link');
            $table->text('id_file')->nullable();
            $table->char('type');
            $table->timestamps();
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
        Schema::dropIfExists('master_file_shares');
    }
}
