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
        Schema::create('session_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')
                ->on('master_users')->onDelete('no action')->onUpdate('cascade');
            $table->string('ip_address', 50)->nullable();
            $table->text('user_agent')->nullable();
            $table->integer('last_activity');
            $table->string('status', 5)->nullable();
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
        Schema::dropIfExists('session_users');
    }
};
