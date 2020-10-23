@extends('template')

@section('content')
<style>

.card-panel {
  min-height: 450px;
  margin: 0;
}

.highcharts-root {
  font-family: "Roboto" !important;
}

.highcharts-button-symbol {
  display: none;
}

.highcharts-title {
  font-size: 1.5rem !important;
}
</style>
    <main>
        <div class="row">
            <div class="text-center" style="text-align: center; margin-top: 10px;">
                <a href="/add_sample" class="btn btn-small pulse blue darken-2"><i class="material-icons">add</i> Add New Sample</a>
                <a href="/samples" class="btn btn-small pulse blue darken-3"><i class="material-icons">list</i> All Samples</a>

            </div>
            <hr>
            
            <div style="padding: 35px;" align="center" class="card">
                <div class="row">
                    <div class="left card-title">
                    <b>Graphical Report of Patients' Samples</b>
                    </div>
                </div>

                <div class="row">
                    <div id="basic-area" class="card-panel"></div>                
                </div>
            </div>

            <div style="padding: 35px;" align="center" class="row card">
                <div class="col m6">
                    <div class="row">
                        <div class="left card-title">
                        <b>Sample By Location</b>
                        </div>
                    </div>

                    <div class="row">
                                     
                    </div>
                </div>

                <div class="col m6">
                    <div class="row">
                        <div class="left card-title">
                        <b>Latest Activity</b>
                        </div>
                    </div>

                    <div class="row">
                        <div class = "row" style="width:98%; margin:auto;">
                            <h5 class="text-center">Activities / Audit Trails</h5>
                        
                            @if ($audits!=NULL)
                              
                            <table id="audits" class="display responsive-table" style="width:100%; font-size: 0.8em;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Event/Action</th>
                                        <th>Facility/Lab</th>
                                        <th>User</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $au)                 
                                    
                                    <tr>
                                        <td>{{$au->created_at}}</td>
                                        <td>{{$au->action}}</td>
                                        <td></td>
                                        <td>{{$au->doneby}}</td>
                                        
                                      
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>                    
                                        <th>Datetime</th>
                                        <th>Event/Action</th>
                                        <th>Description</th>
                                        <th>User</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="col m6 offset-m3">{{$audits->links()}}</div>
                            @else
                                <blockquote>No Audit trails found in the database.</blockquote>
                            @endif
                    
                        </div>      
                    </div>
                </div>
            </div>
        
        </div>
    </main>   
     
@endsection