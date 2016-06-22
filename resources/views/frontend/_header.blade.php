  <header>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1" id="navbar_fixed_top" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div id="navbar1" class="navbar-collapse collapse">
              <div class="row">
                  <div class="col-md-offset-2 col-md-7">
                    <p id="news"><span class="glyphicon glyphicon-bell"></span>This is some news!</p>
                  </div>
                 <!-- <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                      </ul>
                    </li>
                 </ul>-->
                 <div class="col-md-3">
                    <ul class="nav navbar-nav navbar-right">
                      @if ( Auth::user()->check() )
                          <li><a href={{ url("logout") }}><span class="glyphicon glyphicon-log-out"></span> logout <span style="font-family:'open sans condensed', sans-serif; font-weight:normal; text-transform: lowercase;"> {{ Auth::user()->user()->email }} </span></a></li>
                      @else
                          <li><a href={{ url("login") }}><span class="glyphicon glyphicon-log-in"></span>login</a></li>
                      @endif
                      {{-- <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li> --}}
                    </ul>
                 </div>
                </div>
              </div>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        
        <div id="main-navigation">
            <nav class="navbar navbar-inverse nav-home fixed">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <img src={{ asset('img/csi-logo-white.png') }} class="pull-left logo_image">
                  <a class="navbar-brand" href="#">Computer Society of India</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                      <a href={{ url("/home") }}><span class="glyphicon glyphicon-home"></span>Home</a>
                    </li>
                    <li>
                        <a href={{ route('sample') }}>Sample</a>
                    </li>
                    
                    @if ( Auth::user()->check() )

                        <!-- Menu for Travel Grants -->                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>Travel Grants <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href={{ route('profile') }}>Create</a>
                                </li>
                                <li>
                                    <a href={{ route('profile') }}>View All</a>
                                </li>
                                <li>
                                    <a href={{ route('profile') }}>My Grants</a>
                                </li>
                                
                            </ul>
                        </li>
                        <!-- Menu for Travels Grants -->


                        <!-- Menu for Research Grants -->                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>Research Grants <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ action('ResearchGrantController@grantsform') }}">Create</a>
                                </li>
                                <li>
                                    <a href="{{ action('ResearchGrantController@allgrants') }}">View All</a>
                                </li>
                                
                            </ul>
                        </li>
                        <!-- Menu for Research Grants --> 


                        <!-- Menu for Events -->                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>Events <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href={{ route('profile') }}>Create</a>
                                </li>
                                <li>
                                    <a href={{ route('profile') }}>View All</a>
                                </li>
                                <li>
                                    <a href={{ route('profile') }}>My Events</a>
                                </li>
                                
                            </ul>
                        </li>
                        <!-- Menu for Events -->

                        <!-- DashBoard -->
                        <li>
                            <a href={{ url("/dashboard") }}><span class="glyphicon glyphicon-folder-close"></span>DashBoard</a>
                        </li>
                        <!-- My Account -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>My Account <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href={{ route('profile') }}>Profile</a>
                                </li>
                                @if (Auth::user()->user()->membership->type == 'individual')
                                    <li><a href={{ route('card') }}>Print CSI-Card</a></li>
                                @endif
                                <li>
                                    <a href={{ url('/logout') }}>Logout</a>
                                </li>
                            </ul>
                        </li>
                    @else                                    
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Register <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href={{ route('register', [ 'entity' => 'institution-academic' ]) }}>Institution - Academic</a>
                                </li>
                                <li>
                                    <a href={{ route('register', [ 'entity' => 'institution-non-academic' ]) }}>Institution - Non Academic</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href={{ route('register', [ 'entity' => 'individual-student' ]) }}>Individual - student membership</a>
                                </li>
                                <li>
                                    <a href={{ route('register', [ 'entity' => 'individual-professional' ]) }}>Individual - professional membership</a>
                                </li>

                            <!--    <li>
                                    <a href="members/payments/">View Payments</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="members/csi_card">Print CSI Card</a>
                                </li>-->                            </ul>
                        </li>
                    @endif
                  </ul>
                </div>
              </div>
            </nav>
          @section('section-after-mainMenu')
          @show
        </div>

    </header>