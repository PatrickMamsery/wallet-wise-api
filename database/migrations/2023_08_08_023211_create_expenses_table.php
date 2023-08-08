<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 13, 2);
            $table->unsignedInteger('budget_item_id');

            $table->index(['budget_item_id'], "fk_expenses_budget_items_idx");

            $table->foreign('budget_item_id', 'fk_expenses_budget_items_idx')
                ->references('id')->on('budget_items')
                ->onUpdate('restrict')
                ->onDelete('restrict');

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
        Schema::dropIfExists('expenses');
    }
}
