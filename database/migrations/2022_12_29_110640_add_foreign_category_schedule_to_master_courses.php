<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignCategoryScheduleToMasterCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_courses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()
                ->references('id')->on('master_categorie_schedules')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_courses', function (Blueprint $table) {
            $table->dropForeign('master_courses_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
