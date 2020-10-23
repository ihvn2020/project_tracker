<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sresults', function (Blueprint $table) {
            $table->id();
            $table->string('obs');
            $table->string('value');
            $table->timestamps();
            $table->unsignedBigInteger('result_id');
        });

        
        Schema::table('sresults', function (Blueprint $table) {
            
            $table->foreign('result_id')->references('id')->on('specimen_results')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sresults');
        Schema::table('sresults', function(Blueprint $table) {
            $table->dropColumn('result_id');
         });
    }
}
