@extends('template')
@section('content')
      <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">Create Manifests</h5>
    <form action="product_search" method="post">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search Samples</option>
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
        <div class="col m6 offset-m3">
            <form action="{{ route('add_manifest') }}" method="post">
                @csrf
                <div class="input-field col s6">
                    <input id="specimen_id" type="text" class="validate" name="specimen_id">
                    <label for="specimen_id">Enter Manifest ID</label>
                </div>
                <small>Select / Add Samples From the Table Below</small>
                <div class="row">
                    <table class="table col s12">
                        <thead>
                            <tr class="samplehead">
                                <th>Sample IDs</th>                             
                                <th></th>                                  
                            </tr>
                        </thead>
                        <tbody id="allsamples">
                            
                            
                        </tbody>
                    </table>

                </div>

                <div class="input-field col m6">
                    <button type="submit" class="btn green darken-5">Create Manifest<i class="material-icons right">add</i></button>
                </div>
            </form>
        </div>
        
       
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>        
                    <th>Select</th>            
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Sample ID</th>
                    <th>Speciment Type</th>                   
                    <th>Lab ID</th>
                    <th>Site ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($samples as $sat)                 
                
                <tr>
                    <th>
                    <div class="input-field">                            
                            <div class="form-check">
                            <input class="form-check-input" value="{{$sat->specimen_id}}" type="checkbox" name="addsample" id="addsample" onclick="addtoManifest({{$sat->specimen_id}},{{$sat->id}})">
                            </div>                        
                    </div>
                    </th>
                    <td>{{$sat->sample_id}}</td>
                    <td>{{$sat->patient_id}}</td>
                    <td>{{$sat->specimen_id}}</td>
                    <td>{{$sat->specimen_type}}</td>
                    <td>{{$sat->laboratory_id}}</td>
                    <td>{{$sat->collection_site_id}}</td>
                    
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                <th>Select</th>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Sample ID</th>
                    <th>Speciment Type</th>                   
                    <th>Lab ID</th>
                    <th>Site ID</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$samples->links()}}</div>
        @else
            <blockquote>No samples found in the database.</blockquote>
        @endif

    </div>
@endsection