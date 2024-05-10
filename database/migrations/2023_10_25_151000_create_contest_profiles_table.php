<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_user_id');
            $table->unsignedBigInteger('contests_id');
            $table->decimal('deposit_amount',20,6);
            $table->decimal('balance',20,6);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('contest_profiles');
    }
}
