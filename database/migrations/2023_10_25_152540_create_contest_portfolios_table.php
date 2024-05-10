<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_portfolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_user_id');
            $table->unsignedBigInteger('contests_id');
            $table->string('instrument_code',60);
            $table->integer('total_buy');
            $table->integer('total_sale');
            $table->integer('saleable_quantity');
            $table->integer('pending_holding_quantity');
            $table->decimal('total_cost_value',20,4);
            $table->decimal('total_sale_value',20,4);
            $table->decimal('current_cost_value',20,4);
            $table->decimal('current_avg_cost',20,4);
            $table->decimal('market_price',20,4)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('contest_portfolios');
    }
}
