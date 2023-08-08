<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date')->nullable()->default(today());
            $table->decimal('total_expense', 15, 2)->nullable()->default(0.00);
            $table->decimal('total_budget', 15, 2)->nullable()->default(0.00);
            $table->decimal('total_income', 15, 2)->nullable()->default(0.00);
            $table->decimal('saved_amount', 15, 2)->nullable()->default(0.00);
            $table->decimal('spent_amount', 15, 2)->nullable()->default(0.00);
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
        Schema::dropIfExists('reports');
    }
}
