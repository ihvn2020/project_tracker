<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            
            $table->id();
            $table->string('sample_id')->nullable();
            $table->string('patient_id')->nullable();
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->string('shipping_manifest_id')->nullable();
            $table->foreign('shipping_manifest_id')->references('shipping_manifest_id')->on('shippings')->onDelete('cascade');
            $table->string('specimen_type')->nullable();
            $table->string('sample_collection_date')->nullable(); 
            $table->string('laboratory_id')->nullable();
            $table->string('specimen_id')->nullable();
            $table->string('collection_site_id')->nullable(); 
            $table->string('remark')->nullable();
            $table->string('sample_status')->nullable();
            $table->string('collected_by')->nullable();
            $table->string('sample_signature')->nullable();
            $table->string('date_specimen_shipped')->nullable();
            $table->string('date_specimen_arrived_sequence_lab')->nullable();
            $table->string('receiving_lab_officer')->nullable();
            $table->string('receiving_lab_officer_phone')->nullable();
            $table->string('specimen_temperature_arrival')->nullable();
            $table->string('receiving_lab_officer_remark')->nullable();
            $table->string('quality_check')->nullable();
            $table->string('gridbox_number')->nullable();
            $table->string('voided')->nullable();
            $table->string('date_voided')->nullable();
            $table->string('voided_by')->nullable();
            $table->string('date_entered')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('date_updated')->nullable();
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
        Schema::dropIfExists('samples');
    }
}
