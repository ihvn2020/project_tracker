@extends('template')
@section('content')
<div class="container">
    <div class="row right">
        <a href="#results" class="btn small">Patient Samples</a>
    </div>
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Update Sample</h3>
                

                
                    <form method="POST" action="{{ route('samples.update', $sample->id)}}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="sample_id" value="{{$sample->sample_id}}">
                        <input type="hidden" name="id" value="{{$sample->id}}">
                        <input type="hidden" name="pid" value="{{$sample->patients->patient_id}}">

                        <div class="row">
                            <div class="input-field col m3">
                                <select name="patient_id" id="patient_id">
                                                                          
                                        <option value="{{$sample->patient_id}}" selected>{{$sample->patients->patient_name}} ({{$sample->patient_id}})</option>                        
                                </select>
                                <label for="patient_id">Patient ID</label>
                            </div>
                            <div class="input-field col s3">
                            <input id="birthdate" type="date" class="datepicker" name="birthdate" value="{{$sample->patients->birthdate}}">
                                <label for="birthdate">Date of Birth</label>
                            </div>
                            <div class="input-field col s1">
                                <h5>OR</h5>
                            </div>
                            <div class="input-field col s2">
                                <input id="age" type="number" class="validate" name="age" value="{{$sample->patients->age}}">
                                <label for="age">Age</label>
                            </div>
                            
                            <div class="input-field col s3">
                                    <select name="gender" id="gender">
                                        <option  value="{{$sample->patients->gender}}" selected>{{$sample->patients->gender}}</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <label for="gender">Select Gender</label>
                            </div>
                        </div>
                        <h6>Location the Sample Was Taken From:</h6>
                        <div class="row">
                            <div class="input-field col s4 ">
                                <input id="hosp_id" type="text" class="validate" name="hosp_id"  value="{{$sample->patients->hosp_id}}">
                                <label for="hosp_id">Location Name/Facility ID<small> e.g. state, facility name</label>
                            </div>
                            <div class="input-field col s4 ">
                                <input id="other_id" type="text" class="validate" name="other_id" value="{{$sample->patients->other_id}}">
                                <label for="other_id">Any Other ID <small>e.g. Patient Hosp. No. etc</small></label>
                            </div>
                            <div class="input-field col s4">
                                <input id="specimen_id" type="text" class="validate" name="specimen_id" value="{{$sample->specimen_id}}">
                                <label for="specimen_id">Sample ID</label>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="input-field col s3">
                                    <select name="collection_site_id" id="collection_site_id">
                                        <option value="{{$sample->collection_site_id}}" selected="selected">{{$sample->collection_site_id}}</option>

                                       @if (isset($sites))
                                            @foreach ($sites as $p)                                         
                                                <option value="{{$p->id}}">{{$p->site_name.' - '.$p->id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="collection_site_id">Collection Site</label>
                            </div> 
                            
                            <div class="input-field col m3">
                                <input id="specimen_type" type="text" class="validate" name="specimen_type" value="{{$sample->specimen_type}}">
                                <label for="specimen_type">Specimen Source</label>
                            </div>
                            <div class="input-field col m3">
                                <input id="sample_collection_date" type="text" class="datepicker" name="sample_collection_date"  value="{{$sample->sample_collection_date}}">
                                <label for="sample_collection_date">Sample Collection Date</label>
                            </div>

                            <div class="input-field col m3">
                                <select name="result_type" id="result_type">
                                    <option value="MDR">MDR</option>
                                    <option value="PreXDR">PreXDR</option>
                                    <option value="XDR" selected>XDR</option>
                                   
                                </select>
                                    <label for="result_type">Result Type</label>
    
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="input-field col m4">
                                <input id="nrl_arrival_date" type="text" class="datepicker" name="nrl_arrival_date" value="{{$sample->nrl_arrival_date}}">
                                <label for="nrl_arrival_date">Date Sample Arrived NRL</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="dna_extracted" type="checkbox" name="dna_extracted" @if($sample->dna_extracted) checked @endif>
                                <label for="dna_extracted">Sample DNA Extracted?</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="dna_extraction_date" type="text" class="datepicker" name="dna_extraction_date" value="{{$sample->dna_extraction_date}}">
                                <label for="dna_extraction_date">DNA Extraction Date</label>
                            </div>
                        </div>
                       
                        
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="remark" type="text" class="validate" name="remark"  value="{{$sample->remark}}">
                                <label for="remark">Remark</label>
                            </div>
                            <div class="input-field col s4">
                                    <select name="sample_status" id="sample_status">
                                        <option value="{{$sample->sample_status}}" selected>{{$sample->sample_status}}</option>
                                        <option value="Collected" selected="selected">Sample Collected</option>
                                        <option value="Not Collected">Sample Not Collected</option>
                                        <option value="On Transit">Sample on Transit</option>
                                        <option value="Delivered to NL">Delivered to NL</option>
                                        <option value="Cancelled/Damaged">Cancelled/Damaged</option>
                                    </select>
                                    <label for="sample_status">Sample Status</label>
                            </div>
                            <div class="input-field col s2">
                                <select name="collected_by" id="collected_by">                                                                        
                                        <option value="{{$sample->collected_by}}">{{$sample->collected_by}}</option>                                    
                                        @foreach ($users as $user)                                            
                                            <option value='{{$user->id}}'>{{$user->name}}</option>
                                        @endforeach
                                </select>
                                <label>Recorded By</label>
                            </div>  
                        </div>
                        
                       
                        <div class="input-field text-right right" style="margin-bottom:20px;">                            
                                <button type="submit" class="btn">
                                    Update Sample
                                </button>                               
                        
                        </div>
                    </form>              
            
        </div>
    </div>
    @if (isset($specimens))        
        <div class="row" id="results">
            <h4 class="center">Speciment Results For this Sample</h4><hr>
            <table id="products" class="display print_table responsive-table" style="width:100%;;">
                <thead class="thead-dark">
                    <tr>
                        <th>ID - Sample ID</th>
                        <th>Sample Result</th>   
                        <th>Date</th>                
                        <th>P Site ID</th>
                        <th>Signatures</th>
                        <th>Fasta File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specimens as $srt)                 
                    
                    <tr>
                        <td>{{$srt->id}} - {{$srt->sample_id}}</td>
                        <td>
                            @if ($srt->sresults!=NULL)
                        <table class="table striped">
                            
                            <tbody id="item_list">
                            @foreach($srt->sresults as $key => $is)
                           
                            <tr scope='row' class='row{{$key}}'>
                                <td><b>{{$is->obs}}:</b></td>
                                <td>{{$is->value}}</td>
                            </tr>
                            
                            @endforeach                              
                                
                            </tbody>
                        </table>
                        @endif
                        </td>
                        <td>{{$srt->result_date}}</td>
                        <td>{{$srt->processing_site_id}}</td>
                        <td>{{$srt->result_signatures}}</td>
                        <td>
                            @if ($srt->fasta_file_path!="")
                                <a href="#fileModal" id="viewfile{{$srt->id}}" onclick="viewFile({{$srt->id}})" class="btn-floating btn-small waves-effect waves-light btn modal-trigger tooltipped" data-position="top" data-tooltip="View / Edit Item" data-src="/uploads/{{$srt->id}}/{{$srt->fasta_file_path}}.txt" data-filename="Fasta File for Specimen Result on Sample ID: {{$srt->sample_id}}"><i class="material-icons">remove_red_eye</i></a>
                            @endif
                        </td>                   
                        
                        <td>                    
                            <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                    <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                        <i class="small material-icons">menu</i>
                                    </a>
                                    <ul style="top: 0px !important">
                                        
                                        <li>
                                                <form method="POST" action="{{route('specimens.destroy',$srt->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                <button onclick="return confirm('Are you sure you want to delete this specimen result?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Specimen"><i class="material-icons">delete</i></button>
                                                </form>
                                        </li>
                                        
                                        <li>
                                            <a href="{{url('add_results/'.$srt->id)}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Results"><i class="material-icons" >check</i></a>          
                                        </li>
                                        
                                        <li>
                                                <a href="/new_drugresistance/{{$srt->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Drug Resistance"><i class="material-icons" >add</i></a>          
                                        </li>
    
                                        <li>
                                                <a href="/specimen_result/{{$srt->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View Result"><i class="material-icons" >remove_red_eye</i></a>          
                                        </li>
                                        
                                    </ul>
                            </div>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>             
                        <th>ID - Sample ID</th>
                        <th>Sample Result</th>    
                        <th>Date</th>               
                        <th>P Site ID</th>
                        <th>Signatures</th>
                        <th>Fasta File</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
<!-- Modal Structure -->
<div id="fileModal" class="modal bottom-sheet">
    <div class="modal-content">
    <h4 id="filename"></h4>
    <p><iframe src="" id="fileframe" frameborder="0" style="width:100%;min-height:640px;"></iframe></p>
    </div>
    <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
@endsection
