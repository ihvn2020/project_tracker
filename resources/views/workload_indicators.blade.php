@extends('template')
@section('content')
      <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center center">Generate Workload and Turnaround Time Indicators</h5>
    <form action="workload_indicators" method="post" style="width:50%; margin:auto; text-align: center;">
        @csrf
        <div class="row">
            <small class="clear" style="clear: both;  color: green;">Select Duration e.g. from date - to date</small><hr>
            <div class="input-field col m4">
                <input id="from" type="date" class="datepicker" name="from">
                <label for="from">From</label>
            </div>
            <div class="input-field col m4">
                <input id="to" type="date" class="datepicker" name="to">
                <label for="to">To</label>
            </div>
            <div class="input-field col m1">
                <button type="submit" class="btn blue darken-5">Generate</button>
            </div>
        </div>
    </form>
        @if (isset($from))
        <div class="input-field col m12 center">
            <a href="/workload" class="btn btn-small btn-floating pulse green center tooltipped" data-position="top" data-tooltip="Print this page"  onclick='printtag("printable");'><i class="material-icons center">printer</i></a>
        </div>
        <div class = "row" style="width:98%; margin:auto;" id="printable" data-logo="{{$site_settings->logo}}">
            <h5 class="center" style="color: green;">{{$site_settings->organization_name}}</h5>
            <h5 class=" center">Workload Indicators</h5><hr>
            <table class="display striped bordered responsive-table" style="width:70%; margin: auto;">
                <thead class="thead-dark">
                    <tr>        
                    <th colspan="2">Workload and Turnaround Time Indicators from:  {{$from}} - to: {{$to}}</th>            
                        
                    </tr>
                </thead>
                <tbody>
        
                    <tr>        
                        <th colspan="2">No of Isolates Received at the NRL: <b>{{$number_of_isolates}}</b></th>
                    </tr>
                    <tr>        
                        <th colspan="2">Disagregation by Isolates</th>
                    </tr>
                    <tr>
                        <td>Liquid: <b>{{$liquid_isolates}}</b></td>
                        <td>Solid: <b>{{$solid_isolates}}</b></td>                    
                    </tr>

                    <tr>        
                        <th colspan="2">Disagregation by Age</th>
                    </tr>
                    <tr>
                        <td>Less than/equals to 15 years: <b>{{$young}}</b></td>
                        <td>Greater than 15 years: <b>{{$adult}}</b></td>                    
                    </tr>
                    
                    <tr>        
                        <th colspan="2">Disagregation by Gender</th>
                    </tr>
                    <tr>
                        <td>Males: <b>{{$males}}</b></td>
                        <td>Females: <b>{{$females}}</b></td>                    
                    </tr>

                    <tr>        
                        <th colspan="2">Disagregation by Result Type</th>
                    </tr>
                    <tr>
                        <td>MDR: <b>{{$mdr}}</b></td>
                        <td>preXDR: <b>{{$prexdr}}</b>  | XDR: <b>{{$xdr}}</b></td>   
                                        
                    </tr>

                    <tr>        
                        <th colspan="2">Disagregation by DNA Extractions</th>
                    </tr>
                    <tr>
                        <td>Number of DNAs Extracted from isolates: <b>{{$dnas}}</b></td>
                        <td>Number of DNAs sent from NRL to SL: <b>{{$dnashipped}}</b></td>                  
                    </tr>
                    @if ($dnas>0)
                        <tr>        
                            <th colspan="2">TURNAROUND TIME</th>
                        </tr>
                        <tr>
                            <td>Proportion (%) of DNAs Extracted within reporting period: <b>{{number_format(($dnas/$number_of_isolates)*100,2)}}%</b></td>
                            <td>Proportion (%) of Sequencing Results Generated within reporting period: <b>{{number_format(($results_generated/$dnas)*100,2)}}%</b></td>                  
                        </tr>
                    @endif
                </tbody>
            
            </table>
        </div>
       
        @else
            <blockquote class="center">The indicators will show here when you choose duration and generate</blockquote>
        @endif

    </div>
@endsection