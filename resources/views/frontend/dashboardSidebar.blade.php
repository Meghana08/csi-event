   <div class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
     <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span>
        </button> 
        <a class="navbar-brand active"><p style="padding-left:30px;">Services</p></a>  <!--services-->
     </div>
     <div class="collapse navbar-collapse sidebar-navbar-collapse">
                <ul class="nav nav-sidebar" id="sidenav01">
                  <!--institutional services-->
                  <div class="dropdown menu">
                      <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" style="width:240px;">
                           <h6>{{ Auth::user()->user()->membership->type }}services</h6>
                           <span class="caret pull-right"></span>
                      </a>
 
                      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="width:240px;">                        
         @if (Auth::user()->user()->membership->type == 'individual')

         @endif

         @if (Auth::user()->user()->membership->type == 'institutional')

           @if(Auth::user()->user()->getMembership->membershipType->type == 'academic')
              @if(Auth::user()->user()->getMembership->subType->is_student_branch != 1)
                <li><a href={{ route('confirmStudentBranch') }}><span class="glyphicon glyphicon-certificate"></span> Request for Student branch</a></li>
              @endif
           @endif
           <li>
              <a href="#"><span class="glyphicon glyphicon-plus"></span> Add Nominee</a>
           </li>
           {{-- <li><a href="#"><span class="glyphicon glyphicon-calendar"></span> WithBadges <span class="badge pull-right">42</span></a></li> --}}
           <li>
              <a href=""><span class="glyphicon glyphicon-duplicate"></span> Bulk Payments</a>
           </li>
         @endif 
         
           <!--profile and its dropdown-->    
                          <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">Profile</a>
                              <!--<span class="caret pull-right"></span>-->
                              <ul class="dropdown menu">
                              <li><a tabindex="-1" href={{ route('profile') }}>View Profile</a></li>
                              @if (Auth::user()->user()->membership->type == 'individual')
                              <li><a href={{ route('card') }}>Print CSI-Card</a></li>
                              @endif
                              <li><a href="#">Payment History</a></li>
                        </ul>
                        </li>   
          <!--profile ends-->
                  </ul>
        </div>
       </ul>
    </div><!--/.nav-collapse -->
  </div>
 </div>