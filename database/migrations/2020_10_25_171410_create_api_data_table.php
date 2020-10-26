<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity');
            $table->string('activityType');
            $table->string('country');
            $table->string('fuelType');
            $table->string('mode');
            $table->string('carbonFootprint');
            $table->string('appTkn');
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
        Schema::dropIfExists('api_data');
    }
}
