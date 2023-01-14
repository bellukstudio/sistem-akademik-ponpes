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
        Schema::table('trx_scores', function (Blueprint $table) {
            $table->foreignId('assessment_id')->references('id')
                ->on('master_assessments')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_scores', function (Blueprint $table) {
            $table->dropForeign('trx_scores_assessment_id_foreign');
            $table->dropColumn('assessment_id');
        });
    }
};
