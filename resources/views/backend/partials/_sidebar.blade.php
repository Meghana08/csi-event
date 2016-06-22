<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation" style="margin-bottom: 0">
    
    <ul class="nav sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
               CSI-Admin
            </a>
        </li>
<!--                 <li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
  <ul class="dropdown-menu" role="menu">
    <li class="dropdown-header">Dropdown heading</li>
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li><a href="#">Separated link</a></li>
    <li><a href="#">One more separated link</a></li>
  </ul>
</li> -->
        <li>
            <a href={{ route('adminDashboard') }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Membership <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href={{ route('adminMembershipContent') }}>View All</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>


        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href={{ route('adminEventContent') }}>View All</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
                

       
        {{-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href={{ route('backendIndividual', ['typeId' => 3]) }}>Students</a>
                </li>
                <li>
                    <a href={{ route('backendIndividual', ['typeId' => 4]) }}>Professionals</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li> --}}
    </ul>
    <!-- /.navbar-static-side -->
</nav>