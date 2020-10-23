@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m10 offset-m1" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Add New Sample</h3>

                
                    <form method="POST" action="{{ route('samples.store') }}">
                        @csrf

                        <div class="row">
                            <div class="input-field col s6">
                                <input id="birthdate" type="date" class="datepicker" name="birthdate">
                                <label for="birthdate">Date of Birth</label>
                            </div>
                            
                            <div class="input-field col s6">
                                    <select name="gender" id="gender">
                                        <option value="M" selected="selected">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <label for="gender">Select Gender</label>
                            </div>
                        </div>
                        <h6>Location the Sample Was Taken From:</h6>
                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="hosp_id" type="text" class="validate" name="hosp_id">
                                <label for="hosp_id">Facility ID</label>
                            </div>
                            <div class="input-field col s6 ">
                                <input id="other_id" type="text" class="validate" name="other_id">
                                <label for="other_id">Other ID <small>e.g. Patient Hosp. No. etc</small></label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="input-field col s4">
                                <input id="specimen_id" type="text" class="validate" name="specimen_id">
                                <label for="specimen_id">Sample ID</label>
                            </div>
                            
                            <div class="input-field col m4">
                            <select name="specimen_type" id="specimen_type">
                                <option value="Whole Blood">Whole Blood</option>
                                <option value="DBS">DBS</option>
                                <option value="Sputum" selected>Sputum</option>
                                <option value="Serum">Serum</option>
                                <option value="Plasma">Plasma</option>
                                <option value="Cerebrospinal">Cerebrospinal</option>
                                <option value="fluid">fluid</option>
                                <option value="Ascitic fluid">Ascitic fluid</option>
                                <option value="Others">Others</option>
                            </select>
                                <label for="specimen_type">Specimen Source</label>

                            </div>
                            <div class="input-field col m4">
                                <input id="sample_collection_date" type="text" class="datepicker" name="sample_collection_date">
                                <label for="sample_collection_date">Sample Collection Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m4">
                                <input id="nrl_arrival_date" type="text" class="datepicker" name="nrl_arrival_date">
                                <label for="nrl_arrival_date">Date Sample Arrived NRL</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="dna_extracted" type="checkbox" name="dna_extracted">
                                <label for="dna_extracted">Sample DNA Extracted?</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="dna_extraction_date" type="text" class="datepicker" name="dna_extraction_date">
                                <label for="dna_extraction_date">DNA Extraction Date</label>
                            </div>
                        </div>
                        
                       
                        
                        <div class="row">
                            <div class="input-field col s6">
                                <select name="collection_site_id" id="collection_site_id">
                                <option value="{{auth()->user()->site_name}}" selected>{{auth()->user()->site_name}}</option>
                                   @if (isset($sites))
                                        @foreach ($sites as $p)                                         
                                            <option value="{{$p->id}}">{{$p->site_name.' - '.$p->id}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="collection_site_id">NRL Collection Site</label>
                            </div>     
                    
                            <div class="input-field col s6 ">
                                <input id="remark" type="text" class="validate" name="remark">
                                <label for="remark">Remarks</label>
                            </div>
                            
                        </div>

                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn">
                                    Add Sample
                                </button>                               
                        
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
