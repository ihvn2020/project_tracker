<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugResistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('drug_resistances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id')->unique();
            $table->foreign('result_id')->references('id')->on('specimen_results')->onDelete('cascade');            
            $table->string('drug_name')->nullable();
            $table->string('gene_mutation')->nullable();
            $table->string('locus')->nullable();
            $table->text('interpretation')->nullable();
            $table->text('comments')->nullable();
            $table->string('number_of_isolates')->nullable();
            $table->string('accuracy_value_sensitivity')->nullable();
            $table->string('accuracy_value_specificity')->nullable();
            $table->string('sample_id')->nullable();
            $table->string('entered_by')->nullable();
            $table->date('date_entered')->nullable();
            $table->string('updated_by')->nullable();
            $table->date('date_updated')->nullable();
            $table->string('voided')->nullable();
            $table->string('voided_by')->nullable();
            $table->date('date_voided')->nullable();
            $table->string('uuid')->nullable();            
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
        Schema::dropIfExists('drug_resistances');
    }
}
