<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyreports', function (Blueprint $table) {
            $table->id();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('indicator')->nullable();
            $table->string('value')->nullable();
            $table->string('initial_value')->nullable();
            $table->string('health_facility')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('entered_by')->nullable();
            $table->string('user_id')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('dailyreports');
    }
}
