@extends('template2')

@section('content')
    <style>
        label{
            font-size: 80% !important;
        }
    </style>
    <div class = "row" style="width:98%; margin:auto;">
    <h5 class="text-center">List of Facilities in {{$state}}</h5>

        <form action="{{ route('filtered_tracking') }}" style="width: 98%;margin:auto" class="center" method="post">
            @csrf
            <input type="hidden" name="trackfilters[]" value="state">

            <input type="hidden" name="trackfilters[]" value="lga">

            <input type="hidden" name="trackfilters[]" value="health_facility">

            <h6 class="text-center center">Filter Specific Project/Activity</h6>
            <h6 style="clear: both;"><a href="/broadsheet" class="text-green center btn btn-inline">OR Click here to view entire record on a broadsheet</a></h6>

            <div class="col m3">
                <div class="input-field">
                    <select name="state" id="state" materialize="material_select">
                      
                                                            
                        <option value="{{$state}}">{{$state}}</option>
                       
                        
                    </select>
                    <label for="state">Select State</label>
                </div>
            </div>
            <div class="col m3">
                <div class="input-field">
                    <select name="lga" id="lga" materialize="material_select">
                        <option value="All" selected>All</option>
                        @foreach ($lgas as $lga)                                            
                        <option value="{{$lga->lga}}">{{$lga->lga}}</option>
                        @endforeach
                    </select>
                    <label for="lga">Select LGA</label>
                </div>
            </div>
            <div class="col m4">
                <div class="input-field">
                    <select name="health_facility" id="health_facility" materialize="material_select">
                        <option value="All" selected>All</option>
                        @foreach ($facilities as $health_facility)                                            
                        <option value="{{$health_facility->health_facility}}">{{$health_facility->health_facility}}</option>
                        @endforeach
                    </select>
                    <label for="health_facility">Select Facility</label>
                </div>
            </div>
            <div class="input-field col m2">
                <button type="submit" class="btn darken-5"><i class="material-icons right">search</i></button>
            </div>

            <table class="table" style="margin-bottom: 50px;">
                
                <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" class="filled-in"  id="total_patients" name="trackfilters[]" value="total_patients">
                            <label for="total_patients"># Patients</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="uploading_on_ndr" name="trackfilters[]" value="uploading_on_ndr">
                            <label for="total_patients"># on NDR</label>
                        </td>
                        
                        <td>
                            <input type="checkbox" class="filled-in"  id="pcr_lab_linked" name="trackfilters[]" value="pcr_lab_linked">
                            <label for="pcr_lab_linked">Linked PCR</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="central_database_upload" name="trackfilters[]" value="central_database_upload">
                            <label for="central_database_upload">Last Central DB</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="bio_service_update" name="trackfilters[]" value="bio_service_update">
                            <label for="bio_service_update">PBS Mod. Updated?</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="cmm_module" name="trackfilters[]" value="cmm_module">
                            <label for="cmm_module">CMM Mod. Deployed?</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="cmm_reporting_ndr" name="trackfilters[]" value="cmm_reporting_ndr">
                            <label for="cmm_reporting_ndr">CMM on NDR</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="bio_data_capture"  name="trackfilters[]" value="bio_data_capture">
                            <label for="bio_data_capture">PBS Mod. Updated</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="enterprise_nmrs"  name="trackfilters[]" value="enterprise_nmrs">
                            <label for="enterprise_nmrs">Ent. NMRS Deployed</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="total_valid_bio"  name="trackfilters[]" value="total_valid_bio">
                            <label for="total_valid_bio">Total Valid PBS</label>
                        </td>
                      
                        <td>
                            <input type="checkbox" class="filled-in"  id="lims_emr_module"  name="trackfilters[]" value="lims_emr_module">
                            <label for="lims_emr_module">LIMS/NMRS Mod. Deployed</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="limsemr_manifests_sent"  name="trackfilters[]" value="limsemr_manifests_sent">
                            <label for="limsemr_manifests_sent"># LIMS Manifest Sent</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="rsldeployed"  name="trackfilters[]" value="rsldeployed">
                            <label for="rsldeployed">RSL Mod. Deployed</label>
                        </td>
                        <td>
                            <input type="checkbox" class="filled-in"  id="rsl_used"  name="trackfilters[]" value="rsl_used">
                            <label for="rsl_used">RSL in Use?</label>
                        </td>
                       
                    </tr>
                   
                </tbody>
            </table>
            <hr>
            <input type="hidden" name="trackfilters[]" value="id">
            
        </form>
        @if ($facilities!=NULL)
          
          
        <table id="products" class="display responsive-table" style="width:100%;clear: both;;">
            <thead class="thead-dark">
                <tr>                    
                    <th style="width: 10% !important;">LGA</th>
                    <th style="width: 15% !important;">Health Facility</th>
                    <th><small class="clear" style="clear: both;  color: green;">Select Duration (e.g. from date - to date) and Choose Indicator</small><hr>
                    </th>
                    <th>Actions </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facilities as $facility)                 
                @if($facility->lga_instance=="Yes")
                <tr>                    
                    
                    <td>{{$facility->lga}}</td>
                    <td style="width: 20% !important;">{{$facility->health_facility}} @if($facility->lga_instance=="Yes") <br><small style="color: orange;">LGA Instance</small>@endif</td>
                    
                    <td>
                       
                            <div class="row">
                                <div class="input-field col m2">
                                    {{$facility->uploading_on_ndr}}
                                    <br><small style="color: green;">Records on NDR</small>
                                </div>
                                <div class="input-field col m2">
                                    {{$facility->nmrs_mobile_in_use}}
                                    <br><small style="color: green;">NMRS Mobile in Use</small>
                                </div>
                                <div class="input-field col m5">
                                    {{$facility->total_patients}}
                                    
                                    <br><small style="color: green;">Ever Enrolled</small>
                                </div>
                                
                    </td>                   
                    
                    <td>                    
                    <a href="/tfacility/{{$facility->id}}" class="btn-floating small btn-mini blue darken-2" style="margin-top: -20px !important;"><i class="large material-icons">edit</i></a>
                    </td>
                </tr>
                @else
                <tr>
                    
                    
                    <td>{{$facility->lga}}</td>
                    <td style="width: 20% !important;">{{$facility->health_facility}} @if($facility->lga_instance=="Yes") <br><small style="color: orange;">LGA Instance</small>@endif</td>
                    
                    <td>
                        <form action="{{route('dailyreports.store')}}" method="post" style="width: 90% !important;">
                            @csrf
                            <input id="state" type="hidden" name="state" value="{{$facility->state}}">
                            <input id="lga" type="hidden" name="lga" value="{{$facility->lga}}">
                            <input id="health_facility" type="hidden" name="health_facility" value="{{$facility->health_facility}}">
                            <input type="hidden" name="id" value="{{$facility->id}}">

                            <div class="row">
                                <div class="input-field col m2">
                                    <input id="from" type="date" class="datepicker" name="from" value="{{date('Y-m-d')}}" required>
                                    <label for="from">From</label>
                                </div>
                                <div class="input-field col m2">
                                    <input id="to" type="date" class="datepicker" value="{{date('Y-m-d')}}" name="to" required>
                                    <label for="to">To</label>
                                </div>
                                <div class="input-field col m5">
                                    <select name="indicator" id="indicator" class="{{$facility->id}}" onclick="getInivalue({{$facility->id}})" materialize="material_select" style="font-size: 80% !important;">
                      
                                                            
                                    <option value="total_bio_captured" data-initial_value="{{$total_bio_captured = $freports->where('health_facility',$facility->health_facility)->where('indicator','total_bio_captured')->first()->value ?? ''}}">Current Total Fingerprints Captured - <small>{{$total_bio_captured ?? ''}}</option>
                                        <option value="total_valid_bio" data-initial_value="{{$total_valid_bio = $freports->where('health_facility',$facility->health_facility)->where('indicator','total_valid_bio')->first()->value ?? ''}}">Current Total Valid Fingerprints Captured - <small>{{$total_valid_bio ?? ''}}</option>
                                        <option value="tx_curr" data-initial_value="{{$tx_curr = $freports->where('health_facility',$facility->health_facility)->where('indicator','tx_curr')->first()->value ?? ''}}">Current TX_Curr - <small>{{$tx_curr ?? ''}}</small></option>
                                        <option value="limsemr_manifests_sent" data-initial_value="{{$limsemr_manifests_sent = $freports->where('health_facility',$facility->health_facility)->where('indicator','limsemr_manifests_sent')->first()->value ?? ''}}">All Manifests Sent - <small>{{$limsemr_manifests_sent ?? ''}}</option>
                                        <option value="tx_new" data-initial_value="{{$tx_new = $freports->where('health_facility',$facility->health_facility)->where('indicator','tx_new')->last()->value ?? ''}}">Current Total TX New - <small>{{$tx_new}}</option>
                                        <option value="total_patients" data-initial_value="{{$total_patients = $freports->where('health_facility',$facility->health_facility)->where('indicator','total_patients')->first()->value ?? ''}}">Current # of Ever Enrolled - <small>{{$total_patients ?? ''}}</option>
                                        <option value="pvls" data-initial_value="{{$pvls = $freports->where('health_facility',$facility->health_facility)->where('indicator','pvls')->first()->value ?? ''}}">Current Total PVLS - <small>{{$pvls ?? ''}}</option>
                                        <option value="viral_load" data-initial_value="{{$viral_load = $freports->where('health_facility',$facility->health_facility)->where('indicator','viral_load')->first()->value ?? ''}}">Current # Total Viral Load Done - <small>{{$viral_load ?? ''}}</option>
                                       
                                        
                                    </select>
                                    <label for="indicator">Select Indicator/Variable</label>
                                </div>
                                <div class="input-field col m2">
                                    <input id="value" type="number" step="0.01" class="validate" name="value" required>
                                    <label for="value">Value</label>
                                </div>

                                <input id="initial_value" type="hidden" name="initial_value">

                                
                                <div class="input-field col m1">
                                    <button type="submit" class="btn blue darken-5">Update</button>
                                </div>
                            </div>
                        </form>    
                    </td>                   
                    
                    <td>                    
                    <a href="/tfacility/{{$facility->id}}" class="btn-floating small btn-mini blue darken-2" style="margin-top: -20px !important;"><i class="large material-icons">edit</i></a>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>                    
                    <th>LGA</th>
                    <th style="width: 20% !important;">Health Facility</th>
                    <th></th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        
        @else
            <blockquote>No Facilities found in the database.</blockquote>
        @endif

    </div>
@endsection