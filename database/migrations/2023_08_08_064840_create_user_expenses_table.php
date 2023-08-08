<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('expense_id');

            $table->index(["user_id"], 'fk_user_expenses_users_idx');
            $table->index(["expense_id"], 'fk_user_expenses_expenses_idx');

            $table->foreign('user_id', 'fk_user_expenses_users_idx')
                ->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('expense_id', 'fk_user_expenses_expenses_idx')
                ->references('id')->on('expenses')
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
        Schema::dropIfExists('user_expenses');
    }
}
