<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForegnToMasterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_users', function (Blueprint $table) {
            $table->foreignId('roles_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_users', function (Blueprint $table) {
            $table->dropForeign('master_users_roles_id_foreign');
            $table->dropColumn('roles_id');
        });
    }
}
