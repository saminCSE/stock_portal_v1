<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('contest_type_id')->nullable();
            $table->foreign('contest_type_id')->references('id')->on('contest_types')->onDelete('cascade')->onUpdate('cascade');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->double('amount')->nullable();
            $table->string('duration')->nullable();
            $table->date('contest_start_date')->nullable();
            $table->date('contest_end_date')->nullable();
            $table->date('registration_start_date')->nullable();
            $table->date('registration_end_date')->nullable();
            $table->integer('number_of_participation')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('who_can_register')->nullable();
            $table->string('contest_status')->nullable();
            $table->boolean('is_active')->default(0)->comment('1=active , 0= inactive');
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
        Schema::dropIfExists('contests');
    }
}
