<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            
            $table->id();
            $table->string('shipping_manifest_id')->unique();
            $table->string('shipping_site_id')->nullable();
            $table->string('shipping_date')->nullable();
            $table->string('shipping_site_contact_person')->nullable();
            $table->string('shipping_laboratory_phone')->nullable();
            $table->string('shipping_laboratory_email')->nullable();
            $table->string('shipping_officer_name')->nullable();
            $table->string('shipping_officer_phone')->nullable();
            $table->string('number_of_cryovial_tubes')->nullable();
            $table->string('tracking_waybill_number')->nullable();
            $table->string('processing_site_id')->nullable();
            $table->string('receiving_lab_officer_name')->nullable();
            $table->string('receiving_lab_officer_phone')->nullable();
            $table->string('manifest_status')->nullable();
            $table->string('entered_by')->nullable();
            $table->string('date_entered')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('date_updated')->nullable();
            $table->string('voided')->nullable();
            $table->string('voided_by')->nullable();
            $table->string('date_voided')->nullable();
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
        Schema::dropIfExists('shippings');
    }
}
