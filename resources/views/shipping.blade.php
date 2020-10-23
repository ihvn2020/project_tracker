@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            <a href="/samples" class="btn green">Go Back</a>
            
                <h3 class="card-header text-center" style="text-align:center;">Update Shipping Info</h3>

                
                    <form method="POST" action="{{ route('shippings.update', $shipping->id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="id" value="{{$shipping->id}}">

                        <div class="row">
                            <div class="input-field col m4">
                                <input type="text" value="{{$shipping->shipping_manifest_id}}" class="validate" name="shipping_manifest_id" id="shipping_manifest_id" readonly required>
                                <label for="shipping_manifest_id">Shipping Manifest ID</label>
                            </div>

                            <div class="input-field col m4">
                                
                                <select name="shipping_site_id" id="shipping_site_id">
                                    <option value="{{$shipping->shipping_site_id}}">{{$shipping->shipping_site_id}}</option>
                                    @if (isset($sites))
                                         @foreach ($sites as $p)                                         
                                             <option value="{{$p->id}}">{{$p->site_name.' - '.$p->id}}</option>
                                         @endforeach
                                     @endif
                                 </select>
                                 <label for="shipping_site_id">Shipping Site</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="shipping_date" type="date" class="datepicker" name="shipping_date" value="{{$shipping->shipping_date}}">
                                <label for="shipping_date">Shipping Date</label>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="shipping_site_contact_person" type="text" class="validate" name="shipping_site_contact_person" value="{{$shipping->shipping_site_contact_person}}">
                                <label for="shipping_site_contact_person">Shipping Site Contact Person</label>
                            </div>                       
                            
                        </div>

                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="shipping_laboratory_phone" type="text" class="validate" name="shipping_laboratory_phone"  value="{{$shipping->shipping_laboratory_phone}}">
                                <label for="shipping_laboratory_phone">Shipping Lab Phone</label>
                            </div>
                            <div class="input-field col s6 ">
                                <input id="shipping_laboratory_email" type="email" class="validate" name="shipping_laboratory_email" value="{{$shipping->shipping_laboratory_email}}">
                                <label for="shipping_laboratory_email">Shipping Lab E-mail</label>
                            </div>                       
                            
                        </div>

                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="shipping_officer_name" type="text" class="validate" name="shipping_officer_name" value="{{$shipping->shipping_officer_name}}">
                                <label for="shipping_officer_name">Shipping Officer Name</label>
                            </div>
                            <div class="input-field col s6 ">
                                <input id="shipping_officer_phone" type="text" class="validate" name="shipping_officer_phone" value="{{$shipping->shipping_officer_phone}}">
                                <label for="shipping_officer_phone">Shipping Officer Phone</label>
                            </div>                       
                            
                        </div>
                        <h6>Samples Info</h6>
                        <div class="row">
                            <div class="input-field col s4">
                            <input id="number_of_cryovial_tubes" type="number" class="validate" name="number_of_cryovial_tubes" value="{{$shipping->number_of_cryovial_tubes}}">
                                <label for="number_of_cryovial_tubes">Number of Cryovial Tubes</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="tracking_waybill_number" type="text" class="validate" name="tracking_waybill_number" value="{{$shipping->tracking_waybill_number}}">
                                <label for="tracking_waybill_number">Tracking Waybill No</label>
                            </div>
                            <div class="input-field col s4">
                                <select name="processing_site_id" id="processing_site_id">
                                    <option  value="{{$shipping->processing_site_id}}">{{$shipping->processing_site_id}}</option>
                                    @if (isset($sites))
                                         @foreach ($sites as $p)                                         
                                             <option value="{{$p->id}}" selected="selected">{{$p->site_name.' - '.$p->id}}</option>
                                         @endforeach
                                     @endif
                                 </select>
                                 <label for="processing_site_id">Processing Site</label>
                            </div>

                        </div>
                         <!--
                                <h6>Receiving Lab Info</h6>
                            <div class="row">
                                    <div class="input-field col m6 s12">
                                            <input id="receiving_lab_officer_name" type="text" class="validate" name="receiving_lab_officer_name"  value="{{$shipping->receiving_lab_officer_name}}">
                                            <label for="receiving_lab_officer_name">Receiving Lab Officer Name</label>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <input id="receiving_lab_officer_phone" type="text" class="validate" name="receiving_lab_officer_phone" value="{{$shipping->receiving_lab_officer_phone}}">
                                        <label for="receiving_lab_officer_phone">Receiving Lab Officer Phone</label>
                                    </div>

                                    
                            </div>
                        -->
                       <div class="input-field col m6 s12">
                                <select name="manifest_status" id="manifest_status">
                                    <option value="Delivered To Shipping Site">Delivered To Shipping Site</option>
                                    <option value="Not Delivered To Shipping Site">Not Delivered To Shipping Site</option>                                    
                                </select>
                                <label for="manifest_status">Shipping Status</label>
                        </div>

                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn">
                                    Update Shipping
                                </button>                               
                        
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
