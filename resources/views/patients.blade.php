@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Patients</h5>
    <form action="product_search" method="post">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Patients Here</option>
                    @foreach ($all_patients as $pa)                  
                    
                        <option value="{{$pa->id}}">{{$pa->first_name}} - {{$pa->last_name}} - {{$pa->hosp_id}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($patients!=NULL)
          <div>
              <a href="/add_patient" class="btn btn-small btn-floating right pulse btn blue darken-5"><i class="material-icons">add</i></a>
          </div>
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Patient Name</th>
                    <th>Patient ID</th>
                    <th>Datim / Hosp No</th>                   
                    <th>Gender</th>
                    <th>E-mail</th>
                    <th>Phone No.</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $pat)                 
                
                <tr>
                    
                    <td>{{$pat->id}} - {{$pat->first_name. ' ' .$pat->last_name. ' ' .$pat->other_names}}</td>
                    <td>{{$pat->patient_id}} / {{$pat->other_id}}</td>
                    <td>{{$pat->hosp_id}}</td>
                    <td>{{$pat->gender}}</td>
                    <td>{{$pat->email}}</td>
                    <td>{{$pat->phone_no}}</td>
                    <td>{{$pat->remarks}}</td>                   
                    
                    <td>                    
                        <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                    <i class="small material-icons">menu</i>
                                </a>
                                <ul style="top: 0px !important">
                                    
                                    <li>
                                            <form method="POST" action="{{route('patients.destroy',$pat->id)}}">
                                                @csrf
                                                @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this patient?')" class="btn-floating btn-small waves-effect blue waves-light tooltipped" data-position="top" data-tooltip="Delete this Patient"><i class="material-icons">delete</i></button>
                                            </form>
                                    </li>
                          
                                    
                                    <li>
                                            <a href="/patient/{{$pat->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View/Update this Patient info"><i class="material-icons" >remove_red_eye</i></a>          
                                    </li>

                                    <li>
                                            <a href="/add_psample/{{$pat->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Sample"><i class="material-icons" >add_circle_outline</i></a>          
                                    </li>
                                    
                                </ul>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID/Patient Name</th>
                    <th>Patient ID</th>
                    <th>Datim / Hosp No</th>                   
                    <th>Gender</th>
                    <th>E-mail</th>
                    <th>Phone No.</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$patients->links()}}</div>
        @else
            <blockquote>No Patients found in the database.</blockquote>
        @endif

    </div>
@endsection