<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('open_date');
            $table->time('open_time');
            $table->date('close_date');
            $table->time('close_time');
            $table->tinyInteger('status')->default('1')->comment('1= open , 0 = close');
            $table->string('comments');
            $table->bigInteger('created_by');
            $table->bigInteger('update_by');
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
        Schema::dropIfExists('market_schedules');
    }
}
