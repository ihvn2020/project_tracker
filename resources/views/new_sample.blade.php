@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Add Sample Details</h3>

                
                    <form method="POST" action="{{ route('samples.store') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col m4">
                                <select name="patient_id" id="patient_id">
                                    @if (isset($patient_id))                                        
                                        <option value="{{$patient_id}}" selected>{{$patient_name}} ({{$patient_id}})</option>
                                    @else
                                        @foreach ($patients as $p)                                         
                                            <option value="{{$p->patient_id}}" selected="selected">{{$p->first_name.' '.$p->last_name.' - '.$p->patient_id}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="patient_id">Patient ID</label>
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
                            
                            <div class="input-field col s6">
                                <input id="specimen_id" type="text" class="validate" name="specimen_id">
                                <label for="specimen_id">Sample ID</label>
                            </div>
                            <div class="input-field col s6">
                                <select name="collection_site_id" id="collection_site_id">
                                <option value="@auth->user()->facility" selected>@auth->user()->facility</option>
                                   @if (isset($sites))
                                        @foreach ($sites as $p)                                         
                                            <option value="{{$p->id}}" selected="selected">{{$p->site_name.' - '.$p->id}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="collection_site_id">Collection Site</label>
                            </div>                           
                            
                        </div>
                       
                        
                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="remark" type="text" class="validate" name="remark">
                                <label for="remark">Remark</label>
                            </div>
                            <div class="input-field col s6">
                                    <select name="sample_status" id="sample_status">
                                        <option value="Collected" selected="selected">Sample Collected</option>
                                        <option value="Not Collected">Sample Not Collected</option>
                                        <option value="On Transit">Sample on Transit</option>
                                        <option value="Delivered to NL">Delivered to NL</option>
                                        <option value="Cancelled/Damaged">Cancelled/Damaged</option>
                                    </select>
                                    <label for="sample_status">Sample Status</label>
                            </div>
                            
                        </div>
                        
                       <div class="row">
                            <div class="input-field col m6 s12">
                                <select name="collected_by" id="collected_by">                                                                        
                                        <option value="Not Applicable" selected>Not Applicable</option>                                    
                                        @foreach ($users as $user)                                            
                                            <option value='{{$user->id}}'>{{$user->name}}</option>
                                        @endforeach
                                </select>
                                <label>Sample Collected By</label>
                            </div>
                           
                       
                            <div class="input-field col s6 s12">
                                    <input id="shipping_manifest_id" type="text" class="validate" name="shipping_manifest_id" required>
                                    <label for="shipping_manifest_id">Shipping Manifest ID <small>This will be used during shipping</small></label>
                            </div>
                        </div>

                        <div id="shipment">
                            <div class="row">
                                <div class="input-field col m6">
                                    <input id="date_specimen_shipped" type="text" class="datepicker" name="date_specimen_shipped">
                                    <label for="date_specimen_shipped">Date of Speciment Shipment</label>
                                </div>
                                <div class="input-field col m6">
                                    <input id="date_specimen_arrived_sequence_lab" type="text" class="datepicker" name="date_specimen_arrived_sequence_lab">
                                    <label for="date_specimen_arrived_sequence_lab">Date Speciment Arrived Sequence Lab</label>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="input-field col m6">
                                    <input id="receiving_lab_officer" type="text" class="validate" name="receiving_lab_officer">
                                    <label for="receiving_lab_officer">Receiving Lab Officer</label>
                                </div>
                                <div class="input-field col m6">
                                    <input id="receiving_lab_officer_phone" type="text" class="validate" name="receiving_lab_officer_phone">
                                    <label for="receiving_lab_officer_phone">Recieving Lab Officer Phone No</label>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="input-field col m6">
                                    <input id="specimen_temperature_arrival" type="number" class="validate" name="specimen_temperature_arrival">
                                    <label for="specimen_temperature_arrival">Specimen Temperature at Arrival (<sup>o</sup>C)</label>
                                </div>
                                <div class="input-field col m6">
                                    <input id="receiving_lab_officer_remark" type="text" class="validate" name="receiving_lab_officer_remark">
                                    <label for="receiving_lab_officer_remark">Recieving Lab Officer Remark</label>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="input-field col m6">
                                    <input id="quality_check" type="text" class="validate" name="quality_check">
                                    <label for="quality_check">Quality Check</label>
                                </div>
                                <div class="input-field col m6">
                                    <input id="gridbox_number" type="text" class="validate" name="gridbox_number">
                                    <label for="gridbox_number">Gridbox Number</label>
                                </div>                                
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
