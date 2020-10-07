<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_type')->nullable();
            $table->string('site_lga')->nullable();
            $table->string('site_ward')->nullable();
            $table->string('site_state')->nullable();
            $table->string('site_code')->nullable();
            $table->string('site_address')->nullable();
            $table->string('site_longitude')->nullable();
            $table->string('site_latitude')->nullable();
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
        Schema::dropIfExists('sites');
    }
}
