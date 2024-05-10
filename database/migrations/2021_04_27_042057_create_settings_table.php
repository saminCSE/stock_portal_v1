<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name',150)->nullable();
            $table->string('address',400)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('email',100)->nullable();
            $table->string('mail_to',500)->nullable();
            $table->string('logo',150)->nullable();
            $table->string('favicon',150)->nullable();
            $table->string('fb_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('service_day')->nullable();
            $table->string('service_time')->nullable();
            $table->string('is_visitor_count')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
