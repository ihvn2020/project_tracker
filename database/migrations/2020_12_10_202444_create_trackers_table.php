<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('health_facility')->nullable();
            $table->string('total_patients')->nullable();
            $table->string('pcr_lab_linked')->nullable();
            $table->string('datim_id')->nullable();
            $table->string('tx_curr')->nullable();
            $table->string('central_database_upload')->nullable();
            $table->string('bio_service_update')->nullable();
            $table->string('cmm_module')->nullable();
            $table->string('cmm_reporting_ndr')->nullable();
            $table->string('bio_data_capture')->nullable();
            $table->string('enterprise_nmrs')->nullable();
            $table->string('total_bio_captured')->nullable();
            $table->string('total_valid_bio')->nullable();
            $table->string('lims_emr_module')->nullable();
            $table->string('limsemr_manifests_sent')->nullable();
            $table->string('rsldeployed')->nullable();
            $table->string('rsl_used')->nullable();
            $table->string('comments')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('date_updated')->nullable();
            $table->string('facilityid')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->string('cmm_module_used')->nullable();
            $table->string('cmm_module_issue')->nullable();
            
            $table->string('limsemr_date_deployed')->nullable();
            $table->string('limsemr_samples_sent')->nullable();
            $table->string('limsemr_manifests_verified')->nullable();
            $table->string('limsemr_comment')->nullable();

            $table->string('rsl_deployed')->nullable();
            $table->string('rsl_used')->nullable();

            $table->string('nmrs_lga_deployed')->nullable();
            $table->string('nmrs_lga_uploading_ndr')->nullable();
            $table->string('mobile_nmrs')->nullable();
            $table->string('current_hts')->nullable();
            
            $table->string('contactperson')->nullable();
            $table->string('phoneno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackers');
    }
}
