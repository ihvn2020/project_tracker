@extends('template2')

@section('content')
    <style>
        label{
            font-size: 80% !important;
        }
    </style>
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">Indicators Tracking and Reporting Accross Facilities</h5>

        <form action="{{ route('filtered_indicators') }}" style="width: 98%;margin:auto" class="center" method="post">
            @csrf
            <h6 class="text-center center">Search Indicator Reports for a Specific Period</h6>
            
            <div class="col m2">
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
            <div class="col m2">
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
            <div class="col m3">
                <div class="input-field">
                    <select name="health_facility" id="health_facility" materialize="material_select">
                        <option value="All" selected>All</option>
                        @foreach ($health_facilities as $health_facility)                                            
                        <option value="{{$health_facility->health_facility}}">{{$health_facility->health_facility}}</option>
                        @endforeach
                    </select>
                    <label for="health_facility">Select Facility</label>
                </div>
            </div>
            <div class="input-field col m2">
                <input id="from" type="date" class="datepicker" name="from" required>
                <label for="from">From</label>
            </div>
            <div class="input-field col m2">
                <input id="to" type="date" class="datepicker" name="to" required>
                <label for="to">To</label>
            </div>
            <div class="input-field col m1">
                <button type="submit" class="btn darken-5"><i class="material-icons right">search</i></button>
            </div>

            
        </form>
        @if ($indicatorreports!=NULL)
          
          
        <table id="products" class="display responsive-table" style="width:100%;clear: both;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>State</th>
                    <th>LGA</th>
                    <th>Health Facility</th>
                   
                   <th>Indicator</th>
                   <th>Value</th>
                   <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorreports as $facility)                 
                
                <tr>
                    
                    <td>{{$facility->state?? ''}}</td>
                    <td>{{$facility->lga?? ''}}</td>
                    <td>{{$facility->health_facility?? ''}}</td>
                    
                    <td>{{ucwords(str_replace(array("_","bio","total patients"),array(" ","Fingerprints","Ever Enrolled"),$facility->indicator))}}</td>
                    <td>{{$facility->value}}</td>
                    <td>
                        @if ($facility->from==$facility->to)
                        {{$facility->to}}
                        @else
                        {{$facility->from}}-{{$facility->to}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>State</th>
                    <th>LGA</th>
                    <th>Health Facility</th>
                   
                   <th>Indicator</th>
                   <th>Value</th>
                   <th>Date</th>
                </tr>
            </tfoot>
        </table>
        
        @else
            <blockquote>No Indicators found in the database.</blockquote>
        @endif

    </div>
@endsection