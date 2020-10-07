@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Add New Specimen Result</h3>

                
                    <form method="POST" action="{{ route('specimens.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6">
                                <select name="sample_id" id="sample_id">
                                    @if (isset($samples))
                                         @foreach ($samples as $s)                                         
                                             <option value="{{$s->sample_id}}" selected="selected">{{$s->sample_id.' - '.$s->patient_id.' - '.$s->specimen_id}}</option>
                                         @endforeach
                                     @endif
                                 </select>
                                <label for="sample_id">Sample ID <small>(sample id - patient id -specimen -id)</small></label>
                            </div>

                            <div class="input-field col m4">
                                <select name="processing_site_id" id="processing_site_id">
                                    @if (isset($sites))
                                         @foreach ($sites as $p)                                         
                                             <option value="{{$p->id}}" selected="selected">{{$p->site_name.' - '.$p->id}}</option>
                                         @endforeach
                                     @endif
                                 </select>
                                 <label for="processing_site_id">Processing Site</label>
                            </div>
                          
                            <div class="input-field col m2">
                                <input id="result_date" type="text" class="datepicker" name="result_date">
                                <label for="result_date">Result Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table col s12">
                                <thead>
                                    <tr class="spechead">
                                        <th>Observation</th>
                                        <th>Result/Value</th>  
                                        <th></th>                                  
                                    </tr>
                                </thead>
                                <tbody id="item_list">
                                    
                                    
                                </tbody>
                            </table>
                            <div class="input-field col m6 offset-m3 center">
                                <a class="btn btn-small cyan pulse waves-effect waves-light add_item center" href="#" id="1">
                                    Add Specimen Result(s)
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
    
                        </div>
                      
                        
                        <div class="row">
                            <div class="input-field col s12">
                                    <textarea id="result_signatures" class="materialize-textarea" name="result_signatures"></textarea>                         
                                    <label for="result_signatures" >Result Signatures</label>
                            </div>

                            <div class="file-field input-field col s12">
                                <div class="btn cyan darken-4">
                                    <span>Upload Fasta File</span>
                                    <input type="file" name="fasta">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div> 
                            <div class="file-field input-field col s12">
                                <div class="btn cyan darken-4">
                                    <span>Upload Abi File</span>
                                    <input type="file" name="abi">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div> 
                        </div>
                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn blue darken-5">
                                    Save Result
                                    <i class="material-icons">save</i>
                                </button>                               
                        
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
