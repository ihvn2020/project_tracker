@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">All Manifests</h5>
    <form action="product_search" method="post">
        <input type="hidden" name="table" value="shipping">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Manifests Here</option>
                    @foreach ($all_shippings as $sa)                  
                    
                        <option value="{{$sa->id}}">{{$sa->shipping_manifest_id}} - {{$sa->shipping_site_id}} - {{$sa->tracking_waybill_number}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($shippings!=NULL)
          <div>
              <a href="/add_sample" class="btn btn-small btn-floating right pulse btn blue darken-5"><i class="material-icons">add</i></a>
          </div>

          <div class="row clear" style="clear: both; text-align: center; padding-top: 10px;">
            <span style="font-size: 0.7em;" class="blue-text"><strong>Key: </strong> C.Pe: Shipping Site Contact Person, L.Ph: Shipping Lab Phone, L.E: Shipping Lab E-mail, S.O.N: Shipping Officer Name, S.O.Ph: Shipping Officer Phone</span>
          </div>

        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    <th>Manifest ID</th>
                    <th>Site ID</th>
                    <th>Shipping Date</th>
                    <th>Shipping Site Contacts</th>                   
                    <th>Tubes</th>
                    <th>Tracking W. No</th>
                    <th>Processing Site</th>
                    <th>Receivers Contacts</th>
                    <th>Status/Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shippings as $sh)                 
                
                <tr>
                    <td>{{$sh->shipping_manifest_id}}</td>
                    <td>{{$sh->shipping_site_id}}</td>
                    <td>{{$sh->shipping_date}}</td>
                    <td style="font-size: 0.8em !important;">
                        <strong>C.Pe:</strong> {{$sh->shipping_site_contact_person}}<br>
                        <strong>L.Ph:</strong> {{$sh->shipping_laboratory_phone}}<br>
                        <strong>L.E:</strong> {{$sh->shipping_laboratory_email}}<br>
                        <strong>S.O.N:</strong> {{$sh->shipping_officer_name}}<br>
                        <strong>S.O.Ph:</strong> {{$sh->shipping_officer_phone}}
                    </td>
                    <td>{{$sh->number_of_cryovial_tubes}}</td>
                    <td>{{$sh->tracking_waybill_number}}</td>
                    <th>{{$sh->processing_site_id}}</th>
                    <td style="font-size: 0.8em !important;">
                        <strong>R.L.O.N:</strong> {{$sh->shipping_site_contact_person}}<br>
                        <strong>R.L.O.Ph:</strong> {{$sh->shipping_laboratory_phone}}
                    </td>
                    <td>
                    <form action="{{route('changesmStatus')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$sh->id}}">
                    <div class="row">
                        <div class="input-field col s12">
                                <select name="manifest_status" id="manifest_status" onchange="this.form.submit()">
                                    <option value="{{$sh->manifest_status}}" selected>{{$sh->manifest_status}}</option>
                                    <option value="Collected">Manifest Collected</option>
                                    <option value="Not Collected">Manifest Not Collected</option>
                                    <option value="On Transit">Manifest on Transit</option>
                                    <option value="Delivered to NL">Delivered to NL</option>
                                    <option value="Cancelled/Damaged">Cancelled/Damaged</option>
                                </select>
                                <label for="manifest_status">Manifest Status</label>
                        </div>
                       
                    </div>
                    </form>
                    <br>
                    {{$sh->remarks}}
                    </td>     
                    
                    <td>                    
                        
                        <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                    <i class="small material-icons">menu</i>
                                </a>
                                <ul style="top: 0px !important">
                                    
                                    <li>
                                            <form method="POST" action="{{route('shippings.destroy',$sh->id)}}">
                                                @csrf
                                                @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this shipping data?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Sample"><i class="material-icons">delete</i></button>
                                            </form>
                                    </li>
                          
                                    
                                    <li>
                                            <a href="/shipping/{{$sh->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View/Update this Shipping info"><i class="material-icons" >edit</i></a>          
                                    </li>

                                      
                                    <li>
                                            <a href="/manifestconfirm/{{$sh->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Manifest Reception and Confirmation"><i class="material-icons" >add</i></a>          
                                    </li>

                                </ul>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>                    
                    <th>Manifest ID</th>
                    <th>Site ID</th>
                    <th>Shipping Date</th>
                    <th>Shipping Site Contacts</th>                   
                    <th>Tubes</th>
                    <th>Tracking W. No</th>
                    <th>Processing Site</th>
                    <th>Receivers Contacts</th>
                    <th>Manifest Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$shippings->links()}}</div>
        @else
            <blockquote>No Shipping info found in the database.</blockquote>
        @endif

    </div>
@endsection