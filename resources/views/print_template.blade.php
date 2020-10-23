<head>
  <title>RESTHUB | TB Management System</title>
  <link rel="stylesheet" href="{{asset('/css/materialize.min.css')}}">    
  <link rel="stylesheet" href="{{asset('/css/material-icons.css')}}">
    <style>
            #printable{
                margin-top: 0px !important;
            }
    </style>
</head>

<body>

<main>
    <p>@include('/alerts')</p>
    <div id="printable">
        @yield('content')
       
    </div>
    
    @if (!isset($hide_controls))
        <div class="row center" id="controls">
            <a href="#" class="badge blue white-text controller" style="padding: 10px;" onclick="hideControls();" target="_blank"><i class="material-icons">print</i> Print</a>
        </div>
    @endif
    
</main>
    
</body>

<script>
    function hideControls() {
        document.getElementById('controls').style.display = 'block';
        document.getElementById('controls').style.display = 'none';
        window.print();
        window.location.reload(); 
        
    }
</script>
</html>