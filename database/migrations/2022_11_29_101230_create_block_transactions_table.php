<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("instrument_id");
            $table->integer("quantity");
            $table->decimal("value",10,5);
            $table->integer("trades");
            $table->decimal("max_price",10,5);
            $table->decimal("min_price",10,5);
            $table->date('transaction_date');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
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
        Schema::dropIfExists('block_transactions');
    }
}
