@extends('template2')

@section('content')
    <style>
        label{
            font-size: 80% !important;
        }
    </style>
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Facilities</h5>

        <form action="{{ route('filtered_tracking') }}" style="width: 98%;margin:auto" class="center" method="post">
            @csrf
            <input type="hidden" name="trackfilters[]" value="state">

            <input type="hidden" name="trackfilters[]" value="lga">

            <input type="hidden" name="trackfilters[]" value="health_facility">

            <h6 class="text-center center">Filter Specific Variables</h6>
            <h6 style="clear: both;"><a href="/broadsheet" class="text-green center btn btn-inline">OR Click here to view entire record on a broadsheet</a></h6>

            <div class="col m3">
                <div class="input-field">
                    <select name="state" id="state" materialize="material_select">
                        <option value="All" selected>All</option>
                                                            
                        <option value="FCT">FCT</option>
                        <option value="Nasarawa">Nasarawa</option>
                        <option value="Rivers">Rivers</option>
                        <option value="Katsina">Katsina</option>
                        
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
                            <label for="total_patients">Ever Enrolled</label>
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
                    <th>State</th>
                    <th>LGA</th>
                    <th>Health Facility</th>
                    <th>Datim ID</th>
                    <th>Ever Enrolled</th>
                    <th>TX_CURR</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facilities as $facility)                 
                
                <tr>
                    
                    <td>{{$facility->state}}</td>
                    <td>{{$facility->lga}}</td>
                    <td>{{$facility->health_facility}}</td>
                    <td>{{$facility->datim_id}}</td>
                    <td>{{$facility->total_patients}}</td>
                    <td>{{$facility->tx_curr}}</td>                   
                    
                    <td>                    
                    <a href="/tfacility/{{$facility->id}}" class="btn btn-small blue darken-2">View/Update</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><th>State</th>
                    <th>LGA</th>
                    <th>Health Facility</th>
                    <th>Datim ID</th>
                    <th>Ever Enrolled</th>
                    <th>TX_CURR</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        
        @else
            <blockquote>No Facilities found in the database.</blockquote>
        @endif

    </div>
@endsection