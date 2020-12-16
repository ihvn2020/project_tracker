@extends('template2')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">Search Result</h5>
        <h6 style="clear: both;"><button onclick="window.history.back()" class="text-green center btn btn-inline"><- Go Back</button></h6>

    
        @if ($facilities!=NULL)
          
          <table id="products" class="display responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    
                    @foreach ($columns as $col) 
                    
                    @if ($col=="created_at" || $col=="updated_at")
                        @break;
                    @endif
                        @if ($col=="id")
                            @php $col="Action"; @endphp
                        @endif
                        <th>{{ucwords(str_replace("_"," ",$col))}}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                @foreach ($facilities as $facility)
                 <tr>
                    @foreach ($columns as $col) 
                        @if ($col=="created_at" || $col=="updated_at")
                            @break;
                        @endif

                        @if ($col=="id")
                            @php echo '<td><a href="/tfacility/'.$facility->$col.'" class="btn btn-small blue darken-2">More</a></td>'; @endphp
                        @else
                        <td>{{$facility->$col}}</td>
                        @endif
                    @endforeach
                    
                </tr>
                        
                @endforeach
                
            </tbody>
          </table>
        
        @else
            <blockquote>No Facilities found in the database.</blockquote>
        @endif

    </div>
@endsection