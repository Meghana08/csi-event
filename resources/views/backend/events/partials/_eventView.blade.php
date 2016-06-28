<!-- backend -->
<div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
  <div class="panel panel-default" id="payment-list">
    <div class="panel-heading">
      <div class="row">
        <div class="col-md-6">
          <h3>
          @if(!is_null($event->event_logo))
            <img height="50px" width="50px" src={{ route('adminEventLogo', [$event->event_logo]) }} alt="...">
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
            <img width="99%" height="100px" src={{ route('adminEventBanner', [$event->event_banner]) }} alt="...">
           @endif          
        </div>
      </div>
      <div class="row">
          <div class="col-md-3">
            <p>
              <span><b>Event Type : </b>{{ $event->eventType->event_type_name }}</span>
              <span><b>Venue : </b>{{ $event->event_venue }}</span>
              @if(!is_null( $event->getEventTypeDetails))
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
                <span><b>Reason For Cancellation Request : </b>{{ $cancelRequests->reason }}</span>
              </p>
              @if(!strcmp($event->eventStatus->event_status_name,'Requested For Cancellation'))
                <br>
                <p>
                    <ul class="list-inline sub-heading-list action-list pull-right">
                      <li>
                        <a class="btn btn-success" href={{ route('cancelEventAccept', $event->id) }}>Accept</a>
                        <a class="btn btn-danger" href={{ route('cancelEventReject', $event->id) }}>Reject</a>
                      </li>
                    </ul>
                </p>
              @endif
            @elseif(!strcmp($event->eventStatus->event_status_name,'Waiting'))
            <br>
              <p>
                  <ul class="list-inline sub-heading-list action-list pull-right">
                    <li>
                      <a class="btn btn-success" href={{ route('changeStatusAccept', $event->id) }}>Accept</a>
                      <a class="btn btn-danger" href={{ route('changeStatusReject', $event->id) }}>Reject</a>
                    </li>
                  </ul>
              </p>
            @else
              <p></p>
            @endif
          </div>
          @endif
              
      </div>
    </div>
    <div class="panel-body">
      @foreach($grants as $grant)
        @include('backend.events.partials._eventCard')
      @endforeach
    </div>
  </div>
</div> <!-- div card-->


<!-- Modal For Accepting Event -->
<div class="modal fade" id="acceptEvent" tabindex="-1" role="dialog" aria-labelledby="acceptEventLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="acceptEventLabel"></h4>
      </div>

      <div class="modal-body">
          <input type="hidden" id="Accepted" value="0">
          <?php 
              $flag=1;
              foreach($grants as $grant) {
                if(strcmp($grant->grantStatus->grant_status_name, 'Accepted') && strcmp($grant->grantStatus->grant_status_name, 'Closed')) {
                   $flag=0;
                 }                  
              }
          ?>
          @if($flag)
            <h6>Are You Sure You Want To Accept The Event?</h6>
            <a class="btn btn-success" href={{ route('changeStatus', $event->id.'Accepted') }}>Yes</a>
            <a class="btn btn-danger" href="#" data-dismiss="modal">No</a>
          @else
              <div class="alert alert-danger">
                All grants should be either 'Aaccepted' or 'Closed' first. 
              </div>
          @endif
      </div>
      <div class="modal-footer">
          <a class="btn btn-default" href="#" data-dismiss="modal">OK</a>               
      </div>        
    </div>
  </div> 
</div>

@section('footer-scripts')
  <script type="text/javascript">
    $('#acceptEvent').on('show.bs.modal', function (event) {
      // var button = $(event.relatedTarget) // Button that triggered the modal
      // var event_id = button.data('eid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      // var modal = $(this)
      // var field = modal.find('.modal-body #Accepted').attr('value');
      // field = field.replace("0", "1");
      // modal.find('.modal-body #Accepted').attr('value', field);
      $('#Accepted').val('1');
    });
  </script>
@endsection