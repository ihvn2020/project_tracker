<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecimenResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        
    public function up()
    {
        Schema::create('specimen_results', function (Blueprint $table) {
            $table->id();
            $table->string('sample_id');
            $table->string('specimen_result')->nullable();
            $table->date('result_date')->nullable();
            $table->string('processing_site_id')->nullable();
            $table->string('result_signatures')->nullable();
            $table->string('fasta_file_path')->nullable();
            $table->string('fasta_file_text')->nullable();
            $table->string('abi_file_path')->nullable();
            $table->string('entered_by')->nullable();
            $table->date('date_entered')->nullable();
            $table->string('updated_by')->nullable();
            $table->date('date_updated')->nullable();
            $table->string('voided')->nullable();
            $table->date('date_voided')->nullable();
            $table->string('voided_by')->nullable();
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
        Schema::dropIfExists('specimen_results');
    }
}
