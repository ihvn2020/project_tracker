<head>
  <title>Performance Tracker</title>
  <link rel="stylesheet" href="{{asset('/css/materialize.min.css')}}">    
    <link rel="stylesheet" href="{{asset('/css/material-icons.css')}}">
    <link rel="stylesheet" href="{{asset('/css/animate.min.css')}}">    
    <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dataTables.material.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/searchPanes.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/pmain.scss')}}">
    <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css')}}">
    <style>
      .hidden {display:none !important;}
    </style>
</head>

<body>

<nav>
    <div class="nav-wrapper blue darken-5">
      <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
      <a href="/" class="brand-logo"><img src="/uploads/{{$site_settings->logo}}" alt="{{$site_settings->organization_name}}" height="60" width="auto"></a>
      
      <ul class="right hide-on-med-and-down">
      
        <li><a href="/">Dashboard</a></li>
        <li><a href="/edit_settings/1">Settings</a></li>
        <li><a href="/help" target="_blank">Help</a></li>
        <li>
          
            
                
                <a class="btn-flat dropdown-button waves-effect waves-light white-text large" href="#" data-activates="profile-dropdown">Welcome @auth {{auth()->user()->name}} @endauth <i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
                <ul id="profile-dropdown" class="dropdown-content">
                    <li><a href="#"><i class="material-icons">person</i>Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="#lockscreenModal" class="modal-trigger" onclick="lockScreen('{{auth()->user()->name}}')"><i class="material-icons">lock</i>Lock</a></li>
                    <li><a href="/logout"><i class="material-icons">exit_to_app</i>Logout</a></li>
                </ul>
            
          
        </li>
      </ul>

      
      
      <ul class="side-nav teal darken-2" id="mobile-demo">
      <li class="teal center"><a href="#"><i class="material-icons">menu</i>Performance Tracker</a></li>
      <li><a class="collapsible-header waves-effect waves-blue" href="/"><i class="material-icons">dashboard</i>DASHBOARD</a></li>        
        
      
        <li class="white">
          <ul class="collapsible collapsible-accordion">
            
                <li>
                  <a class="collapsible-header waves-effect waves-blue"><i class="material-icons">list</i>Update Tracker<i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a class="waves-effect waves-blue" href="/performance"><i class="material-icons">fullscreen</i>View All<span class="new badge right yellow grey lighten-1" data-badge-caption="updated"></span></a></li>
                      <li><a class="waves-effect waves-blue" href="/add_performance"><i class="material-icons">swap_horiz</i>Add New <span class="new badge right yellow darken-3"></span></a></li>
                      <li><a class="waves-effect waves-blue" href="/view_performance"><i class="material-icons">transfer</i>View My Performance<span class="new badge right yellow darken-3"></span></a></li>
                    </ul>
                  </div>
                </li>
          </ul>
        </li>

        <li class="white">
          <ul class="collapsible collapsible-accordion">
            
                <li>
                  <a class="collapsible-header waves-effect waves-blue"><i class="material-icons">list</i>Sites Management<i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a class="waves-effect waves-blue" href="/sites"><i class="material-icons">fullscreen</i>View All<span class="new badge right yellow grey lighten-1" data-badge-caption="updated"></span></a></li>
                      <li><a class="waves-effect waves-blue" href="/sites"><i class="material-icons">swap_horiz</i>Add New<span class="new badge right yellow darken-3"></span></a></li>
                    </ul>
                  </div>
                </li>
          </ul>
        </li>

        <li class="white">
          <ul class="collapsible collapsible-accordion">
            
                <li>
                  <a class="collapsible-header waves-effect waves-blue"><i class="material-icons">list</i>Indicators / Reporting<i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a class="waves-effect waves-blue" href="/workload"><i class="material-icons">fullscreen</i>All Site Indicators<span class="new badge right yellow grey lighten-1" data-badge-caption="updated"></span></a></li>
                      <li><a class="waves-effect waves-blue" href="/"><i class="material-icons">swap_horiz</i>Add Indicators<span class="new badge right yellow darken-3"></span></a></li>
                    </ul>
                  </div>
                </li>
          </ul>
        </li>
         
      
        <li class="white"><div class="divider"></div></li> 
      
      @if (auth()->user()->role=='Admin')
        <li class="white">
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header waves-effect waves-blue"><i class="material-icons">folder_open</i>System Management<i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a class="waves-effect waves-blue" href="/users"><i class="material-icons">fullscreen</i>Users</a></li>
                  <li><a class="waves-effect waves-blue" href="/facilities"><i class="material-icons">swap_horiz</i>Facilities</a></li>                    
                  <li><a class="waves-effect waves-blue" href="/audits"><i class="material-icons">swap_horiz</i>Audit Trail</a></li>      
                </ul>
              </div>
            </li>
          </ul>
        </li>
      
        <li class="white"><div class="divider"></div></li>      
        
        <li class="white"><a class="waves-effect waves-blue" href="/reports"><i class="material-icons">swap_horiz</i>Activity Report</a></li>                  
        <li class="white"><div class="divider"></div></li>
      @endif
    

        <li class="white"><a href="/edit_settings/1"><i class="material-icons">settings</i>Settings</a></li>
        <li class="white"><a href="/help"><i class="material-icons">help</i>Help</a></li>
        <li class="green">  
                <a class="btn-flat dropdown-button waves-effect waves-light white-text large" href="#" data-activates="profile-dropdown2">@auth {{auth()->user()->name}} @endauth <i class="material-icons right" style="margin-right:0;">arrow_drop_down</i></a>
                <ul id="profile-dropdown2" class="dropdown-content">
                    <li><a href="#"><i class="material-icons">person</i>Profile</a></li>
                    <li class="divider"></li>
                    <a href="#" id="unlock" class="btn btn-large">Click Here to Unlock Screen</a><hr>
                    <li><a href="#lockscreenModal" class="lockscreen modal-trigger" data-username="{{auth()->user()->name}}"><i class="material-icons">lock</i>Lock</a></li>
                    <li><a href="/logout"><i class="material-icons">exit_to_app</i>Logout</a></li>
                </ul>
            
        </li> 
       
      </ul>

      
      
    </div>
  </nav>

<div class="container">
  <p>@include('/alerts')</p>
</div>

@yield('content')
<main>
<div class="container">{{$instruction ?? ''}}</div>
</main>

<!-- Gitter Chat Link -->
  <div class="fixed-action-btn click-to-toggle hide_on_print" style="bottom: 45px; right: 24px;">
      <a class="btn-floating btn-large pink waves-effect waves-light">
          <i class="large material-icons">apps</i>
      </a>

      <ul>
          <li>
              <a class="btn-floating tooltipped" data-position="top" data-tooltip="View All Patients" href="/patients" target="_blank"><i class="material-icons" title>people</i></a>
          </li>
          <li>
              <a class="btn-floating tooltipped" data-position="top" data-tooltip="Samples" href="/samples"><i class="material-icons" title>list</i></a>
          </li>
          <li>
          <a class="btn-floating blue tooltipped" data-position="top" data-tooltip="Sites" href="/sites"><i class="material-icons">house</i></a>
          </li>

          <li> 
          <a class="btn-floating purple darken-1 tooltipped" data-position="top" data-tooltip="Shipping" href="/shippings"><i class="material-icons">local_shipping
            </i></a>
          </li>

          <li>
          <a class="btn-floating green tooltipped" data-position="top" data-tooltip="Users/Operators" href="/users"><i class="material-icons">people</i></a>          
          </li>

          <li>
          <a class="btn-floating blue btn-large tooltipped" data-position="top" data-tooltip="Results" href="/specimens"><i class="material-icons">check</i></a>          
          </li>
      </ul>
  </div>

  <footer class="page-footer blue darken-2">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">{{$site_settings->organization_name}}</h5>
          <p class="grey-text text-lighten-4">{{$site_settings->description}}</p>
        </div>
        <div class="col l2 offset-l2 s6">
          <h6>Links</h6>
          <ul>
            <li><a href="/" class="grey-text text-lighten-3">Dashboard</a></li>
          </ul>
        </div>
        <div class="col l2 s6">
          <h6>System Managment</h6>
          <ul>
            <li><a href="/help" class="grey-text text-lighten-3">Help</a></li>
            <li><a href="/help" class="grey-text text-lighten-3">Support</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright  black darken-4">
      <div class="container">Developed by <a href="https://ihvnigeria.org">IHVN</a></div>
    </div>
  </footer>

  <!-- Lockscreen Modal -->
  <div id="lockscreenModal" class="modal bottom-sheet">
      <div class="modal-content center row">
        <img src="/uploads/{{$site_settings->logo}}" alt="{{$site_settings->organization_name}}" height="60" width="auto">
        <hr>
        <div class="card col m6 offset-m3">
          <h5 class="green">Screen Locked!</h5>
          <i class="material-icons large">lock</i>
          <h6 id="username"></h6>
          <p class="center">
            <a href="#" id="unlock" class="btn btn-large" onclick="showForm()">Click Here to Unlock Screen</a><hr>
            <div class="input-field" id="enter_password">
                    <input id="password" type="password" class="validate initialized @error('password') is-invalid @enderror" name="password" requiblue>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                <label for="password">Enter Password</label>
            </div>

            <a href="/logout" id="notuser">Logout</a>
          </p>
        </div>
      </div>
      <div class="modal-footer right">
      Please enter your password to continue.
      </div>
  </div>
    
</body>
    <script src="{{asset('/js/jquery-3.5.1.js')}}"></script>
    
    <script src="{{asset('/js/pmain.js')}}"></script>
    <script src="{{asset('/js/materialize.min.js')}}"></script>
    <!--<script src="/js/material2.min.css"></script>-->
    <!--<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>-->
    <script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('/js/select2.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.searchPanes.min.js')}}"></script>
    <script src="{{asset('/js/highcharts.js')}}"></script>
    <script src="{{asset('/js/exporting.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" /></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" /></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" /></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" /></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" /></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" /></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" /></script>

</html>