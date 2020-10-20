@extends('nltemplate')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Manifest Reception</h3>

                
                    <form method="POST" action="{{ route('postreception', $shipping->id) }}">
                        @csrf
                        <!--<input name="_method" type="hidden" value="PUT">-->
                        <input type="hidden" name="id" value="{{$shipping->id}}">

                        <div class="row">
                            <div class="input-field col m4">
                                <input type="text" value="{{$shipping->shipping_manifest_id}}" class="validate" name="shipping_manifest_id" id="shipping_manifest_id" readonly required>
                                <label for="shipping_manifest_id">Shipping Manifest ID</label>
                            </div>

                        </div>


                        
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
                        <div class="input-field col m6 s12">
                                <input id="manifest_status" type="text" class="validate" name="manifest_status" value="{{$shipping->manifest_status}}">
                                <label for="manifest_status">Manifest Status</label>
                        </div>

                        <div class="input-field col m6 s12">
                        <textarea id="remarks" class="materialize-textarea" name="remarks">{{$shipping->remarks}}</textarea>                         

                            <label for="manifest_status">Recieving Officer Remarks</label>
                        </div>

                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn">
                                    Save
                                </button>                               
                        
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
