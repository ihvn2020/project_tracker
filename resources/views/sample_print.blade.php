@extends('print_template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <div class="center">
            <img src="/uploads/{{$site_settings->logo}}" alt="No Image Uploaded!" height="80" width="auto">
        </div>
    <h5 class="card-header text-center" style="text-align:center;">{{$site_settings->organization_name}}</h5>
    <hr>
    <h5 class="text-center" style="text-align: center;">Manifest ID: {{$samples[0]->shipping_manifest_id}}</h5>
    
        @if ($samples!=NULL)
          
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Sample ID</th>
                    <th>Specimen ID</th>
                    <th>Speciment Type</th>                   
                    <th>Lab ID</th>
                    <th>Site ID</th>                    
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
                    
                </tr>
            </tfoot>
        </table>
        @else
            <blockquote>No samples found in the database.</blockquote>
        @endif

    </div>
@endsection