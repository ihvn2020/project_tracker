@extends('print_template')
@section('content')

<div class="container">
    
                    <div class="center">
                        <img src="/uploads/{{$site_settings->logo}}" alt="No Image Uploaded!" height="80" width="auto">
                    </div>
                <h5 class="card-header text-center" style="text-align:center;">{{$site_settings->organization_name}}</h5>
                <h5>Sample Info</h5>
                <div class="card">
                    <table class="striped">
                        <tr>
                            <td>Result ID: <br> <h6>{{$res->id}}</h6></td>
                            <td>Sample ID: <br> <h6>{{$res->sample_id}}</h6></td>
                            <td>Result Date: <br><h6>{{$res->result_date}}</h6></td>
                        </tr>

                        <tr>
                            <td colspan="3"><strong>Specimen Result:</strong> <br> 
                                @if ($res->sresults!=NULL)
                                    <table class="table bordered" style="width: 50%; margin: auto;">
                                        
                                        <tbody id="item_list">
                                        @foreach($res->sresults as $key => $is)
                                    
                                        <tr scope='row' class='row{{$key}}'>
                                            <td><b>{{$is->obs}}:</b></td>
                                            <td>{{$is->value}}</td>
                                        </tr>
                                        
                                        @endforeach                              
                                            
                                        </tbody>
                                    </table>
                                @endif
                            </td>
                            
                        </tr>

                        <tr>
                            <td>Processed at: <br> <h6>{{ \App\sites::where('id',$res->processing_site_id)->first()->site_name}}</h6></td>
                            <td colspan="2">Result Signatures: <br> <h6>{{$res->result_signatures}}</h6></td>
                        </tr>
                    
                    </table>
                </div>
                <h5>Drugs / Resistance</h5>
                @foreach ($dresistance as $dr)
                <div class="card">
                    <table class="striped">
                        
                        <tr>
                            <td>Drug Name: <br> <h6>{{$dr->drug_name}}</h6></td>
                            <td>Gene Mutation: <br> <h6>{{$dr->gene_mutation}}</h6></td>
                            <td>Locus: <br><h6>{{$dr->locus}}</h6></td>
                        </tr>

                        <tr>
                            <td>Number of Isolates: <br> <h6>{{$dr->number_of_isolates}}</h6></td>
                            <td>Accuracy Value Sensitivity: <br> <h6>{{$dr->accuracy_value_sensitivity}}</h6></td>
                            <td>Accuracy Value Specificity: <br><h6>{{$dr->accuracy_value_specificity}}</h6></td>
                        </tr>
                        

                        <tr>
                            <td>Interpretation: <br> <h6>{{$dr->interpretation}}</h6></td>
                            <td colspan="2">Comments: <br> <h6>{{$dr->comments}}</h6></td>
                        </tr>
                    
                    </table>
                </div>
                @endforeach


                
                
       
</div>
@endsection
