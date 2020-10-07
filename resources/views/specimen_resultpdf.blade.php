@extends('pdf_template')
@section('content')

<div class="container">
    

                <h3 class="card-header text-center" style="text-align:center;">{{$site_settings->organization_name}}</h3>
                <hr>
                <h3>Sample Info</h3>
                <div class="card">
                    <table class="striped" width="100%">
                        <tr>
                            <td>Result ID: <br> <p>{{$res->id}}</p></td>
                            <td>Sample ID: <br> <p>{{$res->sample_id}}</p></td>
                            <td>Result Date: <br><p>{{$res->result_date}}</p></td>
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
                            <td>Processed at: <br> <p>{{ \App\sites::where('id',$res->processing_site_id)->first()->site_name}}</p></td>
                            <td colspan="2">Result Signatures: <br> <p>{{$res->result_signatures}}</p></td>
                        </tr>
                    
                    </table>
                </div>
                <h3>Drugs / Resistance</h3>
                @foreach ($dresistance as $dr)
                <div class="card">
                    <table class="striped">
                        
                        <tr>
                            <td>Drug Name: <br> <p>{{$dr->drug_name}}</p></td>
                            <td>Gene Mutation: <br> <p>{{$dr->gene_mutation}}</p></td>
                            <td>Locus: <br><p>{{$dr->locus}}</p></td>
                        </tr>

                        <tr>
                            <td>Number of Isolates: <br> <p>{{$dr->number_of_isolates}}</p></td>
                            <td>Accuracy Value Sensitivity: <br> <p>{{$dr->accuracy_value_sensitivity}}</p></td>
                            <td>Accuracy Value Specificity: <br><p>{{$dr->accuracy_value_specificity}}</p></td>
                        </tr>
                        

                        <tr>
                            <td>Interpretation: <br> <p>{{$dr->interpretation}}</p></td>
                            <td colspan="2">Comments: <br> <p>{{$dr->comments}}</p></td>
                        </tr>
                    
                    </table>
                </div>
                @endforeach


                
                
       
</div>
@endsection
