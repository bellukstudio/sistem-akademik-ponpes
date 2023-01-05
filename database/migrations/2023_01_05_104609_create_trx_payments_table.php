<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')
                ->on('master_users')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('id_student')->references('id')
                ->on('master_students')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('id_payment')->references('id')
                ->on('master_payments')->onDelete('no action')->onUpdate('cascade');
            $table->date('date_payment');
            $table->string('total', 50);
            $table->text('photo')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('trx_payments');
    }
}
