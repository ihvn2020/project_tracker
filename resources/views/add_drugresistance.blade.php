@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Add New Drug Resistance</h3>

                
                    <form method="POST" action="{{ route('resistances.store') }}" enctype="multipart/form-data">
                        
                            @csrf
                            <div class="row">
                                <div class="input-field col m6">
                                    <select name="sample_id" id="sample_id">
                                        @if (isset($specimen_results))
                                            @foreach ($specimen_results as $s)                                         
                                                <option value="{{$s->sample_id}}">{{$s->sample_id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="sample_id">Sample ID</label>
                                </div>

                                <div class="input-field col m6">
                                    <select name="result_id" id="result_id">
                                        @if (isset($specimen_results))
                                            @foreach ($specimen_results as $s)                                         
                                                <option value="{{$s->id}}">{{$s->id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="result_id">Result ID</label>
                                </div>

                                
                            </div>

                            <div class="dres" style="border: 1px dashed grey; margin-bottom: 10px; padding: 10px;">
                                
                                <div class="row">
                                        <div class="input-field col m4">
                                            <input id="drug_name" list="drug_names" class="browser-default" name="drug_name[]">
                                            <datalist id="drug_names">
                                                <option value="Isoniazid">
                                                <option value="Rifampicin">
                                                <option value="Rifampicin">
                                                <option value="Ethambutol">
                                            </datalist>
                                            <label for="drug_name" class="active">Drug Name</label>
                                        </div>
                                        <div class="input-field col m4">
                                            <input id="gene_mutation" type="text" class="text" name="gene_mutation[]">
                                            <label for="gene_mutation">Gene Mutation</label>
                                        </div>
                                        <div class="input-field col m4">
                                            <input id="locus" type="text" class="text" name="locus">
                                            <label for="locus">Locus</label>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col m4">
                                        <input id="number_of_isolates" type="number" step="0.01" class="validate" name="number_of_isolates[]">
                                        <label for="number_of_isolates">No of Isolates</label>
                                    </div>
                                    <div class="input-field col m4">
                                        <input id="accuracy_value_sensitivity" type="number" step="0.01" class="validate" name="accuracy_value_sensitivity[]">
                                        <label for="accuracy_value_sensitivity">Accuracy of Value Sensitivity</label>
                                    </div>
                                    <div class="input-field col m4">
                                        <input id="accuracy_value_specificity" type="number" step="0.01" class="validate" name="accuracy_value_specificity[]">
                                        <label for="accuracy_value_specificity">Accuracy Value Specificity</label>
                                    </div>
                                </div>
                            
                                
                                <div class="row">
                                    <div class="input-field col s6">
                                            <textarea id="interpretation" class="materialize-textarea" name="interpretation[]"></textarea>                         
                                            <label for="interpretation" >Interpretation</label>
                                    </div>
                                    <div class="input-field col s6">
                                            <textarea id="comments" class="materialize-textarea" name="comments[]"></textarea>                         
                                            <label for="comments" >Comments</label>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="addres">
                            </div>
                                <div class="row">
                                    <div class="input-field text-right col m5" style="margin-bottom:20px;">
                                    
                                            <a href="#" class="btn blue darken-5" id="addanother">
                                                Add Another
                                                <i class="material-icons">add</i>
                                            </a>                               
                                    
                                    </div>
                                    
                                    <div class="input-field text-right right col m5 offset-2" style="margin-bottom:20px;">
                                    
                                            <button type="submit" class="btn green darken-5">
                                                Save Drug Resistance
                                                <i class="material-icons">save</i>
                                            </button>                               
                                    
                                    </div>
                                    
                                </div>
                                
                    
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
