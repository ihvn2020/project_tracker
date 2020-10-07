@extends('template')
@section('content')
<div class="container">
    <div class="row right">
        <a href="#samples" class="btn small">Patient Samples</a>
    </div>
    <div class="row">
        <div class="card col m8 offset-m2" style="margin-top:20px;">
            
                <h3 class="card-header text-center" style="text-align:center;">Update Patient Info</h3>

                    <form method="POST" action="{{ route('patients.update', $patient->id)}}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="patient_id" value="{{$patient->patient_id}}">
                        <input type="hidden" name="id" value="{{$patient->id}}">

                        <div class="row">
                            <div class="input-field col m4">
                                <input id="first_name" type="text" class="validate" name="first_name" value="{{$patient->first_name}}" required>
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="last_name" type="text" class="validate" name="last_name" value="{{$patient->last_name}}" required>
                                <label for="last_name">Last Name</label>
                            </div>
                            <div class="input-field col m4">
                                <input id="other_names" type="text" class="validate" name="other_names" value="{{$patient->other_names}}">
                                <label for="other_names">Other Names</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="birthdate" type="date" class="datepicker" name="birthdate" value="{{$patient->birthdate}}">
                                <label for="birthdate">Date of Birth</label>
                            </div>
                            
                            <div class="input-field col s6">
                                    <select name="gender" id="gender">
                                        <option value="{{$patient->gender}}" selected>{{$patient->gender}}</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <label for="gender">Select Gender</label>
                            </div>
                        </div>
                        <h6>Hospital Info</h6>
                        <hr>
                        <div class="row">
                            <div class="input-field col s6 ">
                                <input id="hosp_id" type="text" class="validate" name="hosp_id" value="{{$patient->hosp_id}}">
                                <label for="hosp_id">Hospital ID</label>
                            </div>
                            <div class="input-field col s6 ">
                                <input id="other_id" type="text" class="validate" name="other_id" value="{{$patient->other_id}}">
                                <label for="other_id">Other ID</label>
                            </div>
                        </div>
                        <h6>Contact Info</h6>
                        <hr>
                       <div class="row">
                            <div class="input-field col m6 s12">
                                    <input id="email" type="email" class="validate" name="email" value="{{$patient->email}}">
                                    <label for="email">Email Address</label>
                            </div>

                            <div class="input-field col m6 s12">
                                    <input id="phone_no" type="text" class="validate" name="phone_no" value="{{$patient->phone_no}}">
                                    <label for="phone_no">Phone Number</label>
                            </div>
                       </div>
                        <div class="row">
                            <div class="input-field col s12">
                                    <input id="remarks" type="text" class="validate" name="remarks" value="{{$patient->remarks}}">
                                    <label for="remarks">Remarks/Status</label>
                            </div>
                        </div>
                        


                        <div class="input-field text-right right" style="margin-bottom:20px;">
                            
                                <button type="submit" class="btn">
                                    Update Patient
                                </button>                               
                        
                        </div>
                    </form>
                    
        </div>
    </div>
        @if ($samples!=NULL)
            <div class="row clear" id="samples">
                
                <h5>Samples From This Patient</h5> <hr>
                <table id="products" class="display print_table responsive-table" style="width:100%;;">
                    <thead class="thead-dark">
                        <tr>                    
                            <th>Sample ID</th>
                            <th>Patient ID</th>
                            <th>Specimen ID</th>
                            <th>Speciment Type</th>                   
                            <th>Lab ID</th>
                            <th>Site ID</th>
                            <th>Sample Status</th>
                            <th>Manifest ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($samples as $sat)                 
                        
                        <tr>
                            <td>({{$sat->id}}) {{$sat->sample_id}}</td>
                            <td>{{$sat->patient_id}}</td>
                            <td>{{$sat->specimen_id}}</td>
                            <td>{{$sat->specimen_type}}</td>
                            <td>{{$sat->laboratory_id}}</td>
                            <td>{{$sat->collection_site_id}}</td>
                            <td>
                            <form action="{{route('changesStatus')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$sat->id}}">
                            <div class="row">
                                <div class="input-field col s12">
                                        <select name="sample_status" id="sample_status" onchange="this.form.submit()">
                                            <option value="{{$sat->sample_status}}" selected>{{$sat->sample_status}}</option>
                                            <option value="Collected">Sample Collected</option>
                                            <option value="Not Collected">Sample Not Collected</option>
                                            <option value="On Transit">Sample on Transit</option>
                                            <option value="Delivered to NL">Delivered to NL</option>
                                            <option value="Cancelled/Damaged">Cancelled/Damaged</option>
                                        </select>
                                        <label for="sample_status">Sample Status</label>
                                </div>
                            
                            </div>
                            </form>
                            </td>     
                            <td>{{$sat->shipping_manifest_id}}</td>             
                            
                            <td>                    
                                
                                <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                        <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                            <i class="small material-icons">menu</i>
                                        </a>
                                        <ul style="top: 0px !important">
                                            
                                            <li>
                                                    <form method="POST" action="{{route('samples.destroy',$sat->id)}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    <button onclick="return confirm('Are you sure you want to delete this sample data?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Sample"><i class="material-icons">delete</i></button>
                                                    </form>
                                            </li>
                                
                                            
                                            <li>
                                                    <a href="/add_psample/{{$sat->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View/Update this Sample info"  target="_blank"><i class="material-icons" >remove_red_eye</i></a>          
                                            </li>

                                            <li>
                                                    <a href="{{url('add_psample/'.$sat->id)}}#shipment" class="btn-floating btn-small waves-effect btn green darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Shipment"  target="_blank"><i class="material-icons" >local_shipping</i></a>          
                                            </li>

                                            <li>
                                                <a href="{{url('add_results/'.$sat->id)}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Results"><i class="material-icons" >check</i></a>          
                                            </li>
                                            
                                            
                                        </ul>
                                </div>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sample ID</th>
                            <th>Patient ID</th>
                            <th>Specimen ID</th>
                            <th>Speciment Type</th>                   
                            <th>Lab ID</th>
                            <th>Site ID</th>
                            <th>Sample Status</th>
                            <th>Manifest ID</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
        

    
</div>
@endsection
