<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('report_id');

            $table->index(["user_id"], 'fk_user_report_users_idx');
            $table->index(["report_id"], 'fk_user_report_reports_idx');

            $table->foreign('user_id', 'fk_user_report_users_idx')
                ->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('report_id', 'fk_user_report_reports_idx')
                ->references('id')->on('reports')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reports');
    }
}
