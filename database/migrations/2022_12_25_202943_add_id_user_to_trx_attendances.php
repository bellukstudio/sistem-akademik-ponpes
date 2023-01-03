<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserToTrxAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_attendances', function (Blueprint $table) {
            $table->foreignId('id_operator')->references('id')
                ->on('master_users')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_attendances', function (Blueprint $table) {
            $table->dropForeign('trx_attendances_id_operator_foreign');
            $table->dropColumn('id_operator');
        });
    }
}
