<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('budget_item_id');

            $table->index(["user_id"], 'fk_user_budget_users_idx');
            $table->index(["budget_item_id"], 'fk_user_budget_budget_items_idx');

            $table->foreign('user_id', 'fk_user_budget_users_idx')
                ->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('budget_item_id', 'fk_user_budget_budget_items_idx')
                ->references('id')->on('budget_items')
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
        Schema::dropIfExists('user_budgets');
    }
}
