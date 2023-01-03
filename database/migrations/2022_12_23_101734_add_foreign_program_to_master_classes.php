<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignProgramToMasterClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_classes', function (Blueprint $table) {
            $table->foreignId('program_id')->references('id')
                ->on('master_academic_programs')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_classes', function (Blueprint $table) {
            $table->dropForeign('master_classes_program_id_foreign');
            $table->dropColumn('program_id');
        });
    }
}
