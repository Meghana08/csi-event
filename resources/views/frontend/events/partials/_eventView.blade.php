<!-- frontend -->
<div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
  <div class="panel panel-default" id="payment-list">
    <div class="panel-heading">
      <div class="row">
        <div class="col-md-6">
          <h3>
          @if(!is_null($event->event_logo))
            <img height="50px" width="50px" src={{ route('eventLogo', [$event->event_logo]) }} alt="...">
          @endif
            #Event-ID: {{ $event->id }}
          </h3>
          <p class="lead">
            {{$event->event_name}} - {{ $event->event_theme }}
            <br><span>Description : {{ $event->event_description }}</span>
          </p>
        </div>
        <div class="col-md-6">
           @if(!is_null($event->event_banner))
            <img width="99%" height="100px" src={{ route('eventBanner', [$event->event_banner]) }} alt="...">
           @endif          
        </div>
      </div>
      <div class="row">
          <div class="col-md-3">
            <p>
              <span><b>Event Type : </b>{{ $event->eventType->event_type_name }}</span>
              <span><b>Venue : </b>{{ $event->event_venue }}</span>
              <span><b>Max Seats : </b>{{ $event->getEventTypeDetails->max_seats }}</span>
              <span><b>Payment Option : </b>
                @if($event->payment_option)
                  Paid Event
                @else
                  Unpaid Event
                @endif
              </span>
              <span><b>Certification : </b>
                @if($event->getEventTypeDetails->certification)
                  Provided
                @else
                  Not Provided
                @endif
              </span>
              <span><b>Meals : </b>
                @if($event->getEventTypeDetails->meals)
                  Provided
                @else
                  Not Provided
                @endif
              </span>
            </p>
          </div>
          <div class="col-md-5">
            <p>
              <span><b>Date of Request : </b>{{date('F d, Y', strtotime($event->created_at))}}</span>
              <span><b>Start of Event : </b>{{date('F d, Y', strtotime($event->event_start_date))}} - {{ date('h:i:sa', strtotime($event->event_start_time)) }}</span>
              <span><b>End of Event : </b>{{date('F d, Y', strtotime($event->event_end_date))}} - {{ date('h:i:sa', strtotime($event->event_end_time)) }}</span>
              <span><b>Payment Deadline : </b>{{date('F d, Y', strtotime($event->payment_date_deadline))}} - {{ date('h:i:sa', strtotime($event->payment_time_deadline)) }}</span>
              <span><b>Start of Registration : </b>{{date('F d, Y', strtotime($event->getEventTypeDetails->registration_start_date))}} - {{ date('h:i:sa', strtotime($event->getEventTypeDetails->registration_start_time)) }}</span>
              <span><b>End of Registration : </b>{{date('F d, Y', strtotime($event->getEventTypeDetails->registration_end_date))}} - {{ date('h:i:sa', strtotime($event->getEventTypeDetails->registration_end_time)) }}</span>
            </p>
          </div>
          @if($isCreator)
            <div class="col-md-4">
              <p>
                  @if(!strcmp($event->eventStatus->event_status_name,'Accepted'))
                      <span class="label label-success pull-right">{{$event->eventStatus->event_status_name}}</span>
                  @elseif(!strcmp($event->eventStatus->event_status_name,'Waiting'))
                      <span class="label label-warning pull-right">{{$event->eventStatus->event_status_name}}</span>
                  @else
                      <span class="label label-danger pull-right">{{$event->eventStatus->event_status_name}}</span>
                  @endif
              </p>
              @if(!strcmp($event->eventStatus->event_status_name,'Requested For Cancellation') || !strcmp($event->eventStatus->event_status_name,'Cancelled'))
                <br>
                <p>
                  <span><b>Reason for cancellation : </b>{{ $cancelRequests->reason }}</span>
                </p>
              @elseif(!strcmp($event->eventStatus->event_status_name,'Waiting'))
              <br>
                <p>
                    <ul class="list-inline sub-heading-list action-list pull-right">
                      <li>
                        <a class="label label-primary" href={{ route('editEvent', $event->id) }}> Edit </a>
                        <a class="label label-danger" data-toggle="modal" data-target="#eventCancelModal" >Cancel</a>
                      </li>
                    </ul>
                </p>
              @else
              <br>
                <p>
                    <ul class="list-inline sub-heading-list action-list pull-right">
                      <li>
                        <a class="label label-info" href={{ route('showSuscribers', $event->id) }}>Subscribers</a>
                        <a class="label label-warning" data-toggle="modal" data-target="#eventPostModal">Add Post</a>
                      </li>
                    </ul>
                </p>
              @endif
            </div>          
          @else
            <div class="col-md-4" style="padding-top: 15px;">
            </div>
          @endif
      </div>
    </div>
    <div class="panel-body">
    @if($isCreator)
      @foreach($grants->get() as $grant)
        @include('frontend.events.partials._eventCard')
      @endforeach
    @endif
      <br><h4><b><u><center>Event Posts</center></u></b></h4><hr>
      @foreach($eventPosts->get() as $post)
        @include('frontend.events.partials._eventPostCard')
      @endforeach
    </div>
  </div>
</div> <!-- div card-->



<!-- Modal For Cancel Event -->
<div class="modal fade" id="eventCancelModal" tabindex="-1" role="dialog" aria-labelledby="eventCancelModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <h4 class="modal-title" id="eventCancelModalLabel">Enter eason to cancel :* </h4>
      </div>

      <div class="modal-body">
        <h3>Reason </h3>
        {!! Form::open(array('route' => ['cancelEventRequest',$event->id], 'method' => 'post', 'files'=>true)) !!}
        {{ csrf_field() }}
        <div class="form-group">
          <textarea name="reason" class="form-control" rows="3" placeholder="Why you want to delete the event  " required>{{ old('reason') }}</textarea>
        </div>  
        <div> 
          <input type="submit" class="btn btn-info" value ="submit">
        </div>          
        {!! Form::Close() !!}          
      </div>
      <div class="modal-footer">

            
      </div>
    </div>
  </div>
</div>


    <!-- Modal For Add Post -->
<div class="modal fade" id="eventPostModal" tabindex="-1" role="dialog" aria-labelledby="eventPostModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <h4 class="modal-title" id="eventPostModalLabel">Add Post</h4>
      </div>

      <div class="modal-body">
            {!! Form::open(array('route' => ['addPost',$event->id], 'method' => 'post', 'files'=>true)) !!}
            {{ csrf_field() }}
            
              <div class="form-group">
                <label for="post_text" class="req">What you want to write</label>
                {!! Form::text('post_text', null, ['class' => 'form-control', 'placeholder' => 'Text to be posted']) !!}
              </div>

              <div class="form-group">
                <label for="post_image" class="req">Add Image</label>
                {!! Form::file('post_image', null, ['class' => 'form-control', 'id'=>'post_image']) !!}
              </div>

              <div class="form-group">
                {!! Form::submit('Submit') !!}    
              </div>

            {!! Form::Close() !!}
        
    </div>
      <div class="modal-footer">
      </div>
      </div>
        
  </div>
</div>


