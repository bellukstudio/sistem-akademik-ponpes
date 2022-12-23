<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTokenFcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_token_fcm', function (Blueprint $table) {
            $table->id();
            $table->text('token');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('id_user')->nullable()->references('id')->on('master_users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_token_fcm');
    }
}
