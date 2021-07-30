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
                <a href="/tracking" class="btn btn-small pulse blue darken-2"><i class="material-icons">add</i>Generate Report</a>
                <a href="/broadsheet" class="btn btn-small pulse blue darken-3"><i class="material-icons">list</i> All Facilities broadsheet</a>

            </div>
            <hr>
            
            <div style="padding: 35px;" align="center" class="card">
                <div class="row">
                    <div class="left card-title">
                    <b>Graphical Report of Performance Indicators</b>
                    </div>
                </div>

                <div class="row">
                    <div id="basic-area" class="card-panel"></div>                
                </div>

                <div class="row">
                    <div class="col l9">
                        <h6 class="green">Performance Indicators</h6>
                        <hr>
                        <table id="audits" class="display striped responsive-table" style="width:100%; font-size: 0.9em;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Indicator</th>
                                    <th>FCT</th>
                                    <th>Katsina</th>
                                    <th>Nasarawa</th>
                                    <th>Rivers</th>
                                </tr>
                            </thead>
                            <tbody>
                                            
                                
                                <tr>
                                    <td style="font-weight: bold;">EMR Sites</td>
                                    <td>{{$es1 = $all_variables->where('state','FCT')->count()}}</td>
                                    <td>{{$es2 = $all_variables->where('state','Katsina')->count()}}</td>
                                    <td>{{$es3 = $all_variables->where('state','Nasarawa')->count()}}</td>
                                    <td>{{$es4 = $all_variables->where('state','Rivers')->count()}}</td>
                                </tr>
                                @php $emrsites = $es1.",".$es2.",".$es3.",".$es4; @endphp

                                <tr>
                                    <td style="font-weight: bold;">Enterprise NMRS Deployed</td>
                                    <td>{{$enmrs1 = $all_variables->where('state','FCT')->where('enterprise_nmrs','Yes')->count()}}</td>
                                    <td>{{$enmrs2 = $all_variables->where('state','Katsina')->where('enterprise_nmrs','Yes')->count()}}</td>
                                    <td>{{$enmrs3 = $all_variables->where('state','Nasarawa')->where('enterprise_nmrs','Yes')->count()}}</td>
                                    <td>{{$enmrs4 = $all_variables->where('state','Rivers')->where('enterprise_nmrs','Yes')->count()}}</td>
                                </tr>

                                @php $enmrs = $enmrs1.",".$enmrs2.",".$enmrs3.",".$enmrs4; @endphp

                                <tr>
                                    <td style="font-weight: bold;">CMM Module Deployed</td>
                                    <td>{{$cmmm1 = $all_variables->where('state','FCT')->where('cmm_module','Yes')->count()}}</td>
                                    <td>{{$cmmm2 = $all_variables->where('state','Katsina')->where('cmm_module','Yes')->count()}}</td>
                                    <td>{{$cmmm3 = $all_variables->where('state','Nasarawa')->where('cmm_module','Yes')->count()}}</td>
                                    <td>{{$cmmm4 = $all_variables->where('state','Rivers')->where('cmm_module','Yes')->count()}}</td>
                                </tr>

                                @php $cmmm = $cmmm1.",".$cmmm2.",".$cmmm3.",".$cmmm4; @endphp

                                <tr>
                                    <td style="font-weight: bold;">LIMS/EMR Module Deployed</td>
                                    <td>{{$limsm1 = $all_variables->where('state','FCT')->where('lims_emr_module','Yes')->count()}}</td>
                                    <td>{{$limsm2 = $all_variables->where('state','Katsina')->where('lims_emr_module','Yes')->count()}}</td>
                                    <td>{{$limsm3 = $all_variables->where('state','Nasarawa')->where('lims_emr_module','Yes')->count()}}</td>
                                    <td>{{$limsm4 = $all_variables->where('state','Rivers')->where('lims_emr_module','Yes')->count()}}</td>
                                </tr>

                                @php $limsm = $limsm1.",".$limsm2.",".$limsm3.",".$limsm4; @endphp

                                <tr>
                                    <td style="font-weight: bold;">Central Database Uploads</td>
                                    <td>{{$all_variables->where('state','FCT')->where('central_database_upload','!=','')->count()}}</td>
                                    <td>{{$all_variables->where('state','Katsina')->where('central_database_upload','!=','')->count()}}</td>
                                    <td>{{$all_variables->where('state','Nasarawa')->where('central_database_upload','!=','')->count()}}</td>
                                    <td>{{$all_variables->where('state','Rivers')->where('central_database_upload','!=','')->count()}}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Mobile Biometric Deployed</td>
                                    <td>{{$mbd1 = $all_variables->where('state','FCT')->where('bio_service_update','Yes')->count()}}</td>
                                    <td>{{$mbd2 = $all_variables->where('state','Katsina')->where('bio_service_update','Yes')->count()}}</td>
                                    <td>{{$mbd3 = $all_variables->where('state','Nasarawa')->where('bio_service_update','Yes')->count()}}</td>
                                    <td>{{$mbd4 = $all_variables->where('state','Rivers')->where('bio_service_update','Yes')->count()}}</td>
                                </tr>
                                @php $mbd = $mbd1.",".$mbd2.",".$mbd3.",".$mbd4; @endphp

                                <tr>
                                    <td style="font-weight: bold;">Total Biometric Captured</td>
                                    <td>{{$all_variables->where('state','FCT')->where('total_bio_captured','!=','')->sum('total_bio_captured')}}</td>
                                    <td>{{$all_variables->where('state','Katsina')->where('total_bio_captured','!=','')->sum('total_bio_captured')}}</td>
                                    <td>{{$all_variables->where('state','Nasarawa')->where('total_bio_captured','!=','')->sum('total_bio_captured')}}</td>
                                    <td>{{$all_variables->where('state','Rivers')->where('total_bio_captured','!=','')->sum('total_bio_captured')}}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Total Valid Biometric Captured</td>
                                    <td>{{$tvbc1 = $all_variables->where('state','FCT')->where('total_valid_bio','!=','')->sum('total_valid_bio')}}</td>
                                    <td>{{$tvbc2 = $all_variables->where('state','Katsina')->where('total_valid_bio','!=','')->sum('total_valid_bio')}}</td>
                                    <td>{{$tvbc3 = $all_variables->where('state','Nasarawa')->where('total_valid_bio','!=','')->sum('total_valid_bio')}}</td>
                                    <td>{{$tvbc4 = $all_variables->where('state','Rivers')->where('total_valid_bio','!=','')->sum('total_valid_bio')}}</td>
                                </tr>
                                @php $tvbc = $tvbc1.",".$tvbc2.",".$tvbc3.",".$tvbc4; @endphp
                                <!--
                                    To be used later
                                    <tr>
                                        <td style="font-weight: bold;">Last Central Database Upload</td>
                                        <td>{{$all_variables->where('state','FCT')->last()->central_database_upload}}</td>
                                        <td>{{$all_variables->where('state','Katsina')->last()->central_database_upload}}</td>
                                        <td>{{$all_variables->where('state','Nasarawa')->last()->central_database_upload}}</td>
                                        <td>{{$all_variables->where('state','Rivers')->last()->central_database_upload}}</td>
                                    </tr>
                                -->
                            
                            </tbody>
                            <tfoot>
                                <tr>                    
                                    <th>Indicator</th>
                                    <th>FCT</th>
                                    <th>Katsina</th>
                                    <th>Nasarawa</th>
                                    <th>Rivers</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col l3">
                        <h6 class="green">Summary</h6>
                        <hr>
                        <table id="audits" class="display striped responsive-table" style="width:100%; font-size: 0.9em;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Indicator (Across EMR Sites)</th>
                                    <th>Value</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                            
                                
                                <tr>
                                    <td style="font-weight: bold;">Total TX_CURR</td>
                                    <td>{{$all_variables->where('tx_curr','!=','')->sum('tx_curr')}}</td>                                  
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Total Valid Bio Metric Capture (Valid/Invalid)%</td>
                                    <td>{{number_format($all_variables->where('total_valid_bio','!=','')->sum('total_valid_bio')/$all_variables->where('total_bio_captured','!=','')->sum('total_bio_captured'),2)}}%</td>                                  
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Valid Biometric Data Capture</td>
                                    <td>{{$all_variables->where('total_valid_bio','!=','')->sum('total_valid_bio')}}</td>                                  
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">LIMS/EMR Deployment %</td>
                                    <td>{{number_format($all_variables->where('lims_emr_module','Yes')->count()/$all_variables->count(),2)}}%</td>                                  
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">CMM Inventory Module Deploment %</td>
                                    <td>{{number_format($all_variables->where('cmm_module','Yes')->count()/$all_variables->count(),2)}}%</td>                                  
                                </tr>

                                <tr>
                                    <td style="font-weight: bold;">Mobile Biometric Deployment %</td>
                                    <td>{{number_format($all_variables->where('bio_service_update','Yes')->count()/$all_variables->count(),2)}}%</td>                                  
                                </tr>

                              
                            </tbody>
                            
                        </table>
                        
                    </div>
                    
                </div>

                
            </div>

            <div style="padding: 35px;" align="center" class="row card">
               

                <div class="col m12">
                    <div class="row">
                        <div class="left card-title">
                        <b>Latest Activity</b>
                        </div>
                    </div>

                    <div class="row">
                        <div class = "col m6">
                            <h5 class="text-center">Activities / Audit Trails</h5>
                        
                            @if ($audits!=NULL)
                              
                            <table id="audits" class="display bordered responsive-table" style="width:100%; font-size: 0.8em;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 20% !important;">Date & Time</th>
                                        <th style="width: 60% !important;">Event/Action</th>
                                        <th style="width: 20% !important;">User</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $au)                 
                                    
                                    <tr>
                                        <td>{{$au->created_at}}</td>
                                        <td>{{$au->action}}</td>
                                        <td>{{$au->doneby}}</td>
                                        
                                      
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>                    
                                        <th>Datetime</th>
                                        <th>Event/Action</th>
                                        <th>User</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <style>
                                .m6 nav{
                                    background-color: none !important;
                                }
                            </style>
                            <div class="col m6 offset-m3">{{$audits->links()}}</div>
                            @else
                                <blockquote>No Audit trails found in the database.</blockquote>
                            @endif
                    
                        </div>   
                        <div class="col m6">
                            <h5 class="text-center">Issues</h5>
                            <hr>
                            @if ($all_variables!=NULL)
                              
                            <table id="audits" class="display bordered responsive-table" style="width:100%; font-size: 0.8em;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="60%">Comments</th>
                                        <th width="20%">Remarks</th>
                                        <th width="20%">Facility</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_variables as $issue)   
                                    @if ($issue->comments || $issue->remarks != '')
                                        <tr>
                                            <td>{!!$issue->comments??''!!}</td>
                                            <td>{{$issue->remarks??''}}</td>
                                            <td>{{$issue->health_facility}}, {{$issue->lga}}, {{$issue->state}}</td>
                                            
                                        
                                        </tr>
                                    @endif              
                                    
                                   
                                    @endforeach
                                </tbody>
                               
                            </table>
                            
                            @else
                                <blockquote>No Issues found in the database.</blockquote>
                            @endif
                        </div>   
                    </div>
                </div>
            </div>
        
        </div>
    </main>   
     
@endsection

