@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Samples</h5>
    <form action="product_search" method="post">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Samples Here</option>
                    @foreach ($all_samples as $sa)                  
                    
                        <option value="{{$sa->id}}">{{$sa->sample_id}} - {{$sa->patient_id}} - {{$sa->shipping_manifest_id}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($samples!=NULL)
          <div>
              <a href="/add_sample" class="btn btn-small btn-floating right pulse btn blue darken-5"><i class="material-icons">add</i></a>
          </div>
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Sample ID</th>
                    <th>Patient ID</th>
                    <th>Specimen ID</th>
                    <th>Speciment Type</th>                   
                    <th>Lab ID</th>
                    <th>Site ID</th>
                    <th>Sample Status</th>
                    <th>Manifest ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($samples as $sat)                 
                
                <tr>
                    <td>({{$sat->id}}) {{$sat->sample_id}}</td>
                    <td>{{$sat->patient_id}}</td>
                    <td>{{$sat->specimen_id}}</td>
                    <td>{{$sat->specimen_type}}</td>
                    <td>{{$sat->laboratory_id}}</td>
                    <td>{{$sat->collection_site_id}}</td>
                    <td>
                    <form action="{{route('changesStatus')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$sat->id}}">
                    <div class="row">
                        <div class="input-field col s12">
                                <select name="sample_status" id="sample_status" onchange="this.form.submit()">
                                    <option value="{{$sat->sample_status}}" selected>{{$sat->sample_status}}</option>
                                    <option value="Collected">Sample Collected</option>
                                    <option value="Not Collected">Sample Not Collected</option>
                                    <option value="On Transit">Sample on Transit</option>
                                    <option value="Delivered to NL">Delivered to NL</option>
                                    <option value="Cancelled/Damaged">Cancelled/Damaged</option>
                                </select>
                                <label for="sample_status">Sample Status</label>
                        </div>
                       
                    </div>
                    </form>
                    </td>     
                    <td>{{$sat->shipping_manifest_id}}</td>             
                    
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
                                            <button onclick="return confirm('Are you sure you want to delete this sample data?')" class="btn-floating btn-small waves-effect blue waves-light tooltipped" data-position="top" data-tooltip="Delete this Sample"><i class="material-icons">delete</i></button>
                                            </form>
                                    </li>
                          
                                    
                                    <li>
                                            <a href="/add_psample/{{$sat->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View/Update this Sample info"><i class="material-icons" >remove_red_eye</i></a>          
                                    </li>

                                    <li>
                                            <a href="{{url('add_psample/'.$sat->id)}}#shipment" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Shipment"><i class="material-icons" >local_shipping</i></a>          
                                    </li>

                                    <li>
                                        <a href="{{url('add_results/'.$sat->id)}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Results"><i class="material-icons" >check</i></a>          
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
                    <th>Patient ID</th>
                    <th>Specimen ID</th>
                    <th>Speciment Type</th>                   
                    <th>Lab ID</th>
                    <th>Site ID</th>
                    <th>Sample Status</th>
                    <th>Manifest ID</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$samples->links()}}</div>
        @else
            <blockquote>No samples found in the database.</blockquote>
        @endif

    </div>
@endsection