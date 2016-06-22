@section('navBarSpecific')  <!--himanshu -->
        <li ><a href={{  route('adminEventContent')  }}>All  Events <span class="sr-only"></span></a></li> 
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Event Status<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($statuses as $statusN)
                              <li><a href={{  route('statusWiseEvents',['statusId'=>$statusN->id ])  }}> {{ $statusN->event_status_name }} </a></li>                              
                            @endforeach
                        </ul>                               
        </li>
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Change Requests<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($requests as $request)                             
                                @if($request->id==1)<li> <a href={{  route('adminEventEditReq')  }}>{{ $request->request_type }}</a></li>
                                 @else<li>  <a href= {{ route('adminEventCancelReq') }}>{{ $request->request_type }}</a></li>

                                @endif                                             
                            @endforeach
                        </ul>    
        </li>
                                
@stop