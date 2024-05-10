<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_organizers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contest_id')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
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
        Schema::dropIfExists('contest_organizers');
    }
}
