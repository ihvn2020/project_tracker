@extends('template2')

@section('content')
    <style>
        label{
            font-size: 80% !important;
        }
    </style>
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">Indicators Tracking Search Result From : {{$from}} To: {{$to}}</h5>
        <h6 style="clear: both;"><button onclick="window.history.back()" class="text-green center btn btn-inline"><- Go Back</button></h6>

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