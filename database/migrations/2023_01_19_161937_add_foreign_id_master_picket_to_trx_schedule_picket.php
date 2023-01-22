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
        Schema::table('trx_picket_schedules', function (Blueprint $table) {
            $table->foreignId('id_category')->references('id')
                ->on('master_pickets')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_picket_schedules', function (Blueprint $table) {
            $table->dropForeign('trx_picket_schedules_id_category_foreign');
            $table->dropColumn('id_category');
        });
    }
};
