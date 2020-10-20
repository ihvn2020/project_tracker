@extends('nltemplate')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Queued Samples</h5>
    <form action="product_search" method="post">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Samples Here</option>
                    @foreach ($all_samples as $sa)                  
                    
                        <option value="{{$sa->id}}">{{$sa->sample_id}} - {{$sa->shipping_manifest_id}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($samples!=NULL)
          
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Sample ID</th>
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
                      <a href="{{url('add_results/'.$sat->id)}}" class="btn btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Results">Result</a>               
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Sample ID</th>
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