@extends('template')
@section('content')
<div class="container">
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Create Sample</h3>

                
                    <form method="POST" action="{{ route('patients.store') }}">
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
