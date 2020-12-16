@extends('template2')

@section('content')
    
    <div class = "row" style="width:98%; margin:auto;">
        <h5 class="text-center">List of Facilities</h5>
    
        @if ($facilities!=NULL)
          <div>
              <a href="/add_tfacility" class="btn btn-small btn-floating right pulse"><i class="material-icons">add</i></a>
          </div>
          <table id="products" class="display responsive-table" style="width:100%;;">
            <thead class="thead-dark">
                <tr>                    
                    
                    @foreach ($columns as $col) 
                    @if ($col=="created_at" || $col=="updated_at")
                        @break;
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
                        <td>{{$facility->$col}}</td>
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