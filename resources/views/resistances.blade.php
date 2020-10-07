@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">Drug Resistance Records</h5>
    <form action="product_search" method="post">
        @csrf
        <input type="hidden" name="table" value="drug_resistance">
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Drug Resistance Here</option>
                    @foreach ($all_resistances as $sa)                  
                    
                        <option value="{{$sa->id}}">{{$sa->result_id}} - {{$sa->drug_name}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($resistances!=NULL)
          <div>
              <a href="/add_drugresistance" class="btn btn-small btn-floating right pulse btn blue darken-5"><i class="material-icons">add</i></a>
          </div>
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Sample ID</th>
                    <th>Ressult ID</th>
                    <th>Drug Name</th>
                    <th>Gene Mutation</th>                   
                    <th>Locus</th>
                    <th>Interpretation</th>
                    <th>More Info</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resistances as $sat)                 
                
                <tr>
                    <td>({{$sat->id}}) - {{$sat->sample_id}}</td>
                    <td>{{$sat->result_id}}</td>
                    <td>{{$sat->drug_name}}</td>
                    <td>{{$sat->gene_mutation}}</td>
                    <td>{{$sat->locus}}</td>
                    <td>{{$sat->interpretation}}</td>
                    <td>
                    <b>Interpretation: </b> {{$sat->interpretation}}<br>
                    <b>Number of Isolates: </b> {{$sat->number_of_isolates}}<br>
                    <b>Accuracy Value Sensitivity: </b> {{$sat->accuracy_value_sensitivity}}<br>
                    <b>Accuracy Value Specificity: </b> {{$sat->accuracy_value_specificity}}
                    </td>     
                      
                    <td>                    
                        
                        <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                    <i class="small material-icons">menu</i>
                                </a>
                                <ul style="top: 0px !important">
                                    
                                    <li>
                                            <form method="POST" action="{{route('samples.destroy',$sat->id)}}">
                                                @csrf
                                                @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this drug resistance data?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Sample"><i class="material-icons">delete</i></button>
                                            </form>
                                    </li>
                          
                                    
                                    <li>
                                            <a href="/drug_resistance/{{$sat->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View/Update this Drug Resistance info"><i class="material-icons" >remove_red_eye</i></a>          
                                    </li>

                                </ul>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Sample ID</th>
                    <th>Ressult ID</th>
                    <th>Drug Name</th>
                    <th>Gene Mutation</th>                   
                    <th>Locus</th>
                    <th>Interpretation</th>
                    <th>More Info</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$resistances->links()}}</div>
        @else
            <blockquote>No Drug Resistance Record found in the database.</blockquote>
        @endif

    </div>
@endsection