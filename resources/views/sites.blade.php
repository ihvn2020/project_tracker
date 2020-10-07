@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <div class="col s9">
            <h5 class="text-center">Item sites</h5>
        
            @if ($sites!=NULL)
            <div>
                <a href="/add_facility" class="btn btn-small btn-floating right pulse"><i class="material-icons">add</i></a>
            </div>
            <table id="audits" class="display responsive-table" style="width:100%;;">
                <thead class="thead-dark">
                    <tr>
                                           
                        <th>Site Name</th>
                        <th>ID/Code</th>
                        <th>Site Type</th>
                        <th>Site Location</th>
                        <th>Delete</th>
                    
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sites as $si)                 
                    
                    <tr>
                        <td>{{$si->site_name}}</td>
                        <td>{{$si->id}} / {{$si->site_code}}</td>
                        <td>{{$si->site_type}}</td>
                        <td>{{str_replace("Nigeria","",$si->site_address)}}<br>
                            {{$si->site_ward}}, {{$si->site_lga}},<br> {{$si->site_state}}<br>
                            <small><i class="material-icons">location_on</i> {{$si->site_longitude}}, {{$si->site_latitude}}</small>
                        </td>
                        <td>                    
                            
                            <form method="POST" action="{{route('sites.destroy',$si->id)}}">
                                @csrf
                                @method('DELETE')
                            <button onclick="return confirm('Are you sure you want to delete this site?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Item"><i class="material-icons">delete</i></button>
                            </form>
                                       
                            
                        </td>
                        
                    
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>                    
                        <th>Site Name</th>
                        <th>ID/Code</th>
                        <th>Site Type</th>
                        <th>Site Location</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
            </table>
            <div class="col m6 offset-m3">{{$sites->links()}}</div>
            @else
                <blockquote>No Site found in the database.</blockquote>
            @endif
        </div>

        <div class="col s3">
            <h3 class="card-header text-center" style="text-align:center;">Add New Site</h3>

                    
            <form method="POST" action="{{ route('sites.store') }}">
                @csrf

                <div class="input-field">
                        <input id="site_name" type="text" class="validate" name="site_name" required autofocus>
                        <label for="site_name">Site Name</label>
                </div>

                <div class="row">
                    
                    
                    <div class="input-field col m7">
                        <select name="site_type" id="site_type" class="validate">
                            <option value="Shipping Site">Shipping Site</option>
                            <option value="Sample Collection Site">Sample Collection Site</option>
                            <option value="Sample Delivery Site">Sample Delivery Site</option>
                            <option value="Patients Registration Site">Patients Registration  Site</option>
                            <option value="NRL Site">NRL Site</option>
                            <option value="NL Site">NL Site</option>
                            <option value="Others">Others</option>
                        </select>
                        <label for="site_type">Select Site Type</label>
                    </div>

                    <div class="input-field col m5">
                        <input id="site_code" type="text" class="validate" name="site_code">
                        <label for="site_code">Site Code</label>
                    </div>
                </div>

                    <div class="row clear">
                        
                        <div class="input-field col s6">
                        
                            <select
                            onchange="toggleLGA(this);"
                            name="site_state"
                            id="state"
                            class="browser-default validate"
                            >
                            <option value="" selected="selected">- Select State-</option>
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="AkwaIbom">AkwaIbom</option>
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
                            <option value="FCT">FCT</option>
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
                            <option value="Nasarawa">Nasarawa</option>
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
                            <option value="Zamfara">Zamafara</option>
                            </select>
                            <label for="state" class="active">State of Origin</label>
                        </div>
        
                        <div class="input-field col s6">
                        
                            <select
                            name="site_lga"
                            id="lga"
                            class="form-control select-lga browser-default"
                            required
                            >
                            </select>
                            <label for="lga" class="active">LGA of Origin</label>
                        </div>

                        
                    </div>
                    <div class="input-field">
                            <input id="site_ward" type="text" class="validate" name="site_ward">
                            <label for="site_ward">Site Ward</label>
                    </div>
                    
                
                <div class="input-field">
                    <input id="site_address" type="text" class="validate" name="site_address">
                    <label for="site_address" class="active">Site Address</label>
                </div>
                <a onclick="getLocation()" class="btn small" style="padding: 0 0.5rem; font-size: 0.6em;"><i class="material-icons">location_on</i>Use Current Location</a>


                <div class="row">     
                    

                    <div class="input-field col m6">
                        <input id="longitude" type="text" class="validate" name="longitude">
                        <label for="longitude" class="active">Longitude</label>
                    </div>

                    <div class="input-field col m6">
                        <input id="latitude" type="text" class="validate" name="latitude">
                        <label for="latitude" class="active">Latitude</label>
                    </div>
                </div>    


                <div class="input-field text-right right" style="margin-bottom:20px;">
                    
                        <button type="submit" class="btn">
                            Add Site
                        </button>                               
                
                </div>
            </form>
        </div>

    </div>
    <script src="{{asset('/js/lga.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAmxt1urJerv_gHmojS9TV59DZVvbFASE&amp;libraries=places"></script>
         
<script>
  google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
      var input = document.getElementById('site_address');
      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.addListener('place_changed', function () {
      var place = autocomplete.getPlace();
      // place variable will have all the information you are looking for.
      $('#latitude').val(place.geometry['location'].lat());
      $('#longitude').val(place.geometry['location'].lng());
    });
  }
</script>
    
@endsection
