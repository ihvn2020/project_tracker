@extends('template2')
@section('content')
<div class="container">
    
    <div class="row">
        <div class="card col m12" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">View / Update</h3>
                <hr>
                <h4 class="center green-text">{{$facility->health_facility}} ({{$facility->datim_id}}), {{$facility->lga}}, {{$facility->state}}</h4>
                
                    <form method="POST" action="{{ route('tracking.update', $facility->id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="id" value="{{$facility->id}}" >

                        <div class="row">
                            <div class="col s4">
                                <div class="input-field">
                                    <input id="health_facility" type="text" class="validate" name="health_facility" value="{{$facility->health_facility}}" autofocus>
                                    <label for="health_facility">Facility Name</label>
                                </div>
        
                                <div class="input-field">
                                        <input id="datim_id" type="text" class="validate" name="datim_id"  value="{{$facility->datim_id}}">
                                        <label for="datim_id">Datim Number</label>
                                </div>
        
                                <div class="input-field">
                                        <select  onchange="toggleLGA(this);" name="state" id="state">
                                            <option value="{{$facility->state}}" selected>{{$facility->state}}</option>
                                            <option value="Abuja FCT">Abuja FCT</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Nassarawa">Nassarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Zamfara">Zamfara</option>
                                            <option value="Outside Nigeria">Outside Nigeria</option>
                                        </select>
                                        <label for="state">State (For Nigeria)</label>
                                </div>
        
                                <div class="input-field">
                                        <select name="lga" id="lga" class="select-lga">
                                        <option selected value="{{$facility->lga}}">{{$facility->lga}}</option>
                                        </select>
                                        <label for="lga">LGA</label>
                                </div>
        
                                <div class="input-field">
                                        <input id="total_patients" type="number" class="validate" name="total_patients">
                                        <label for="total_patients" value="{{$facility->total_patients}}">Ever Enrolled</label>
                                </div>
        
                                
        
                                <div class="input-field">
                                    <input id="tx_curr" type="number" class="validate" name="tx_curr"value="{{$facility->tx_curr}}" readonly>
                                    <label for="tx_curr">Current TX_CURR</label>
                                </div>
                                
                                <div class="input-field">
                                    <input id="contactperson" type="text" class="validate" name="contactperson"value="{{$facility->contactperson}}">
                                    <label for="contactperson">Contact Person Name</label>
                                </div>
                                
                                <div class="input-field">
                                    <input id="phoneno" type="text" class="validate" name="phoneno"value="{{$facility->phoneno}}">
                                    <label for="phoneno">Phone Number</label>
                                </div>
                                
                                
                                
                                
                                
                            </div>
                            <div class="col s7 offset-m1">
                                @if (auth()->user()->role=="Facility Manager")
                                    <input type="hidden" name="bio_service_update" value="{{$facility->bio_service_update}}">
                                    <input type="hidden" name="cmm_module" value="{{$facility->cmm_module}}">
                                    <input type="hidden" name="cmm_reporting_ndr" value="{{$facility->cmm_reporting_ndr}}">
                                    <input type="hidden" name="bio_data_capture" value="{{$facility->bio_data_capture}}">
                                    <input type="hidden" name="enterprise_nmrs" value="{{$facility->enterprise_nmrs}}">
                                    <input type="hidden" name="lims_emr_module" value="{{$facility->lims_emr_module}}">
                                    <input type="hidden" name="rsldeployed" value="{{$facility->rsldeployed}}">
                                    <input type="hidden" name="rsl_used" value="{{$facility->rsl_used}}">

                                    @php $disabled = "disabled"; @endphp
                                @endif

                                <div class="row">
                                    <div class="col s12  z-depth-1">
                                        <ul class="tabs" style="font-size: 80% !important;">
                                        <li class="tab col s3"><a href="#test1">LIMS/EMR Integration</a></li>
                                        <li class="tab col s2"><a href="#test2">Commodity Module</a></li>
                                        <li class="tab col s2"><a href="#test3">RSL Module</a></li>
                                        <li class="tab col s2"><a href="#test4">PBS Update</a></li>
                                        <li class="tab col s3"><a href="#test5">Enterprise NMRS</a></li>
                                        </ul>
                                    </div>
                                    <div id="test1" class="col s12">
                                        <table class="table table-striped table-inverse table-responsive">
                                            <thead class="thead-inverse">
                                               
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        
                                                        <td>LIMS/EMR Integration Module Deployed</td>
                                                        <td class="input-field">
                                                            <select name="lims_emr_module" id="lims_emr_module" {{$disabled??''}}>
                                                                <option selected value="{{$facility->lims_emr_module}}">{{$facility->lims_emr_module}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date Deployed</td>
                                                        <td class="input-field">
                                                                <input id="limsemr_date_deployed" type="date" class="validate datepicker" name="limsemr_date_deployed"value="{{$facility->limsemr_date_deployed}}">                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total # of Manifests Sent</td>
                                                        <td class="input-field">
                                                            <input id="limsemr_manifests_sent" type="number" class="validate" name="limsemr_manifests_sent"value="{{$facility->limsemr_manifests_sent}}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total # of Samples Sent</td>
                                                        <td class="input-field">
                                                            <input id="limsemr_samples_sent" type="number" class="validate" name="limsemr_samples_sent"value="{{$facility->limsemr_samples_sent}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total # of Manifests Verified at PCR Lab</td>
                                                        <td class="input-field">
                                                            <input id="limsemr_manifests_verified" type="number" class="validate" name="limsemr_manifests_verified"value="{{$facility->limsemr_manifests_verified}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PCR Lab Linked To</td>
                                                        <td class="input-field">
                                                            <select name="pcr_lab_linked" id="pcr_lab_linked" {{$disabled??''}}>
                                                                <option selected value="{{$facility->pcr_lab_linked}}">{{$facility->pcr_lab_linked}}</option>
                                                                <option value="NRL">NRL</option>
                                                                <option value="BMSH">BMSH</option>
                                                            </select>
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>LIMS/EMR Comment</td>
                                                        <td class="input-field">
                                                                <input id="limsemr_comment" type="text" class="validate" name="limsemr_comment"value="{{$facility->limsemr_comment}}">
                                                                
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                        </table>
                                    </div>
                                    <div id="test2" class="col s12">
                                        <table class="table table-striped table-inverse table-responsive">
                                            <thead class="thead-inverse">
                                                <tr>
                                                   
                                                    <th>Services Deployed</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
        
                                                    <tr>
                                                        
                                                        <td>CMM Module Deployed</td>
                                                        <td class="input-field">
                                                            <select name="cmm_module" id="cmm_module" {{$disabled??''}}>
                                                                <option selected value="{{$facility->cmm_module}}">{{$facility->cmm_module}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>CMM Module Reporting on NDR</td>
                                                        <td class="input-field">
                                                            <select name="cmm_reporting_ndr" id="cmm_reporting_ndr" {{$disabled??''}}>
                                                                <option selected value="{{$facility->cmm_reporting_ndr}}">{{$facility->cmm_reporting_ndr}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                        </table>
                                    </div>
                                    <div id="test3" class="col s12">
                                        <table class="table table-striped table-inverse table-responsive">
                                            <thead class="thead-inverse">
                                                <tr>
                                                   
                                                    <th>Services Deployed</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        
                                                        <td>RSL Deployed</td>
                                                        <td class="input-field">
                                                            <select name="rsldeployed" id="rsldeployed" {{$disabled??''}}>
                                                                <option selected value="{{$facility->rsldeployed}}">{{$facility->rsldeployed}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>RSL Being Used</td>
                                                        <td class="input-field">
                                                            <select name="rsl_used" id="rsl_used" {{$disabled??''}}>
                                                                <option selected value="{{$facility->rsl_used}}">{{$facility->rsl_used}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                    <div id="test4" class="col s12">
                                        <table class="table table-striped table-inverse table-responsive">
                                            <thead class="thead-inverse">
                                                <tr>
                                                   
                                                    <th>Services Deployed</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        
                                                        <td>
                                                            Biometric Service Updated?
                                                                            
                                                        </td>
                                                        <td class="input-field">
                                                           
                                                            <select name="bio_service_update" id="bio_service_update" {{$disabled??''}}>
                                                                <option selected value="{{$facility->bio_service_update}}">{{$facility->bio_service_update}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        
                                                        <td>Mobile Biometric Data Capture Deployed</td>
                                                        <td class="input-field">
                                                            <select name="bio_data_capture" id="bio_data_capture" {{$disabled??''}}>
                                                                <option selected value="{{$facility->bio_data_capture}}">{{$facility->bio_data_capture}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total Fingerprint Captured</td>
                                                        <td class="input-field">
                                                            <input id="total_bio_captured" type="number" class="validate" name="total_bio_captured"value="{{$facility->total_bio_captured}}">
                                                            <label for="total_bio_captured">Total Biometric Captured</label>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Total Valid Fingerprints</td>
                                                        <td class="input-field">
                                                            <input id="total_valid_bio" type="number" class="validate" name="total_valid_bio"value="{{$facility->total_valid_bio}}">
                                                            <label for="total_valid_bio">Total Valid Biometric Captured</label>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                        </table>
                                    </div>
                                    <div id="test5" class="col s12">
                                        <table class="table table-striped table-inverse table-responsive">
                                            <thead class="thead-inverse">
                                                <tr>
                                                   
                                                    <th>Services Deployed</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        
                                                        <td>Enterprise NMRS Deployed</td>
                                                        <td class="input-field">
                                                            <select name="enterprise_nmrs" id="enterprise_nmrs" {{$disabled??''}}>
                                                                <option selected value="{{$facility->enterprise_nmrs}}">{{$facility->enterprise_nmrs}}</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Central Database Upload Date</td>
                                                        <td class="input-field">
                                                            <input id="central_database_upload" type="date" class="validate datepicker" name="central_database_upload"value="{{$facility->central_database_upload}}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>


                                
                                
                            </div>
                            <div class="input-field col m8 offset-m2">
                                <input id="comments" type="text" class="validate" name="comments">
                                <label for="comments">General Comment/ Issue</label>
                            </div>
    
                            <div class="input-field  col m8 offset-m2">
                                <input id="remarks" type="text" class="validate" name="remarks">
                                <label for="remarks">Remarks</label>
                            </div>
    
    
                            <div class="input-field text-right right" style="margin-bottom:20px;">
                                
                                    <button type="submit" class="btn">
                                        Update Facility Record
                                    </button>                               
                            
                            </div>
                        </div>
                        

                        
                    </form>
                    

            
        </div>
    </div>
</div>
<script src="{{asset('/js/lga.js')}}"></script>
@endsection
