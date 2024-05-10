<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_user_id');
            $table->unsignedBigInteger('contests_id');
            $table->boolean('transaction_type')->default(0)->comment('1=buy,2=sale,3=addition');
            $table->string('remark');
            $table->integer('quantity');
            $table->decimal('price',10,2);
            $table->decimal('commission',10,2);
            $table->decimal('debit',10,2);
            $table->decimal('credit',10,2);
            $table->decimal('balance',10,2);
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
        Schema::dropIfExists('contest_ledgers');
    }
}
