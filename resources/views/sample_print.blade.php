@extends('print_template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <div class="center">
            <img src="/uploads/{{$site_settings->logo}}" alt="No Image Uploaded!" height="80" width="auto">
        </div>
    <h5 class="card-header text-center" style="text-align:center;">{{$site_settings->organization_name}}</h5>
    <hr>
    <h5 class="text-center" style="text-align: center;">Manifest ID: <b>{{$samples[0]->shipping_manifest_id}}</b></h5>
    <h6 class="text-center" style="text-align: center;">Processing Site: @php $siteinfo = \App\sites::where('id',$processing_site)->first(); @endphp <b>{{$siteinfo->site_name ?? ''}}</b> State: {{$siteinfo->site_state ?? ''}}  LGA: {{$siteinfo->site_lga ?? ''}} </h6>
    
        @if ($samples!=NULL)
          
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>     
                    <th>S/N</th>               
                    <th>Sample ID</th>
                    <th>Specimen ID</th>
                    <th>Speciment Type</th>
                    <th>Date of Collection</th>  
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($samples as $key => $sat)                 
                
                <tr>
                    <td>{{$key+1}}</td>
                    <td>({{$sat->id}}) {{$sat->sample_id}}</td>
                    <td>{{$sat->specimen_id}}</td>
                    <td>{{$sat->specimen_type}}</td>
                    <td>{{$sat->sample_collection_date}}</td>
                    <th>{{$sat->remark}}</th>
                    
                </tr>
                @endforeach
            </tbody>
           
        </table>
        @php $shipinfo = \App\shipping::where('shipping_manifest_id',$samples[0]->shipping_manifest_id)->first(); @endphp

        Date of Shipment to Sequencing Lab: <b>{{$shipinfo->shipping_date}}</b><br>
        Name of Shipping Officer: <b>{{$shipinfo->shipping_officer_name}}</b><br>
        Shipping Officer Phone Number: <b>{{$shipinfo->shipping_officer_phone}}</b><br>
        <hr><br><br>

        Signature: _______________________
        @else
            <blockquote>No samples found in the database.</blockquote>
        @endif

    </div>
@endsection