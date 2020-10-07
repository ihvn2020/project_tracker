@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Create Sample</h3>

                
                    <form method="POST" action="{{ route('patients.store') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col m4">
                                <input id="first_name" type="text" class="validate" name="first_name" required>
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="last_name" type="text" class="validate" name="last_name" required>
                                <label for="last_name">Last Name</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="other_names" type="text" class="validate" name="other_names">
                                <label for="other_names">Other Names</label>
                            </div>
                        </div>
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
                        <h6>Hospital Info</h6>
                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="hosp_id" type="text" class="validate" name="hosp_id">
                                <label for="hosp_id">Hospital ID</label>
                            </div>
                            <div class="input-field col s6 ">
                                <input id="other_id" type="text" class="validate" name="other_id">
                                <label for="other_id">Other ID</label>
                            </div>
                        </div>
                        <h6>Contact Info</h6>
                       <div class="row">
                            <div class="input-field col m6 s12">
                                    <input id="email" type="email" class="validate" name="email">
                                    <label for="email">Email Address</label>
                            </div>

                            <div class="input-field col m6 s12">
                                    <input id="phone_no" type="text" class="validate" name="phone_no">
                                    <label for="phone_no">Phone Number</label>
                            </div>
                       </div>
                        <div class="row">
                            <div class="input-field col s12">
                                    <input id="remarks" type="text" class="validate" name="remarks">
                                    <label for="remarks">Remarks/Status</label>
                            </div>
                        </div>
                        


                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn">
                                    Continue
                                </button>                               
                        
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
