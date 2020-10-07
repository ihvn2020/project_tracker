@extends('template')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Specimen Results</h5>
    <form action="product_search" method="post">
        @csrf
        <div class="input-field col m6 offset-m2">
            <select name="keyword" id="keyword" class="browser-default" style="width: 100% !important;">
                    <option value="-" selected>Search All Specimen Results Here</option>
                    @foreach ($all_specimens as $sr)                  
                    
                        <option value="{{$sr->id}}">{{$sr->first_name}} - {{$sr->last_name}} - {{$sr->hosp_id}}</option>                                                 
                    
                    @endforeach
            </select>
        </div>
        <div class="input-field col m1">
            <button type="submit" class="btn blue darken-5"><i class="material-icons right">search</i></button>
        </div>
    </form>
        @if ($specimens!=NULL)
          <div>
              <a href="/add_specimenresult" class="btn btn-small btn-floating right pulse btn blue darken-5"><i class="material-icons">add</i></a>
          </div>
        <table id="products" class="display print_table responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>
                    <th>ID-Sample ID</th>
                    <th>Sample Result</th>   
                    <th>Date</th>                
                    <th>P Site ID</th>
                    <th>Signatures</th>
                    <th>Fasta File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($specimens as $srt)                 
                
                <tr>
                    <td>{{$srt->id}} - {{$srt->sample_id}}</td>
                    <td>{{$srt->specimen_result}}</td>
                    <td>{{$srt->result_date}}</td>
                    <td>{{$srt->processing_site_id}}</td>
                    <td>{{$srt->result_signatures}}</td>
                    <td>
                        @if ($srt->fasta_file_path!="")
                            <a href="#fileModal" id="viewfile{{$srt->id}}" onclick="viewFile({{$srt->id}})" class="btn-floating btn-small waves-effect waves-light btn modal-trigger tooltipped" data-position="top" data-tooltip="View / Edit Item" data-src="/uploads/{{$srt->id}}/{{$srt->fasta_file_path}}.txt" data-filename="Fasta File for Specimen Result on Sample ID: {{$srt->sample_id}}"><i class="material-icons">remove_red_eye</i></a>
                        @endif
                    </td>                   
                    
                    <td>                    
                        <div class="fixed-action-btn horizontal direction-top direction-left click-to-toggle sales_action" style="position: relative !important; float: text-align: center; display: inline-block; bottom: 0px !important; padding: 0px !important">
                                <a class="btn-floating btn-small btn blue darken-5 waves-effect waves-light" style="display: inline-block" >
                                    <i class="small material-icons">menu</i>
                                </a>
                                <ul style="top: 0px !important">
                                    
                                    <li>
                                            <form method="POST" action="{{route('specimens.destroy',$srt->id)}}">
                                                @csrf
                                                @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this specimen result?')" class="btn-floating btn-small waves-effect red waves-light tooltipped" data-position="top" data-tooltip="Delete this Specimen"><i class="material-icons">delete</i></button>
                                            </form>
                                    </li>
                          
                                    
                                    <li>
                                            <a href="/add_drugresistance/{{$srt->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="Add Drug Restrictions"><i class="material-icons" >add</i></a>          
                                    </li>

                                    <li>
                                            <a href="/specimen_result/{{$srt->id}}" class="btn-floating btn-small waves-effect btn blue darken-5 waves-light tooltipped" data-position="top" data-tooltip="View / Print Result"><i class="material-icons" >remove_red_eye</i></a>          
                                    </li>
                                    
                                </ul>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>                    
                    <th>ID - Sample ID</th>
                    <th>Sample Result</th>    
                    <th>Date</th>               
                    <th>P Site ID</th>
                    <th>Signatures</th>
                    <th>Fasta File</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="col m6 offset-m3">{{$specimens->links()}}</div>
        @else
            <blockquote>No Specimen Results found in the database.</blockquote>
        @endif

    </div>

    <!-- Modal Structure -->
    <div id="fileModal" class="modal bottom-sheet">
        <div class="modal-content">
        <h4 id="filename"></h4>
        <p><iframe src="" id="fileframe" frameborder="0" style="width:100%;min-height:640px;"></iframe></p>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>
@endsection