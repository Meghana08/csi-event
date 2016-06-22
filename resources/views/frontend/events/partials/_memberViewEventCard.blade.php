<div class="listing-items">
    <div class="row">
      <div class="col-md-9">        
        <p class="lead">{{ $event->event_name }} - {{ $event->event_theme }}</p>
      </div>
      <div class="col-md-3">   
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <p>
          <span><b>Event Type : </b>{{ $event->eventType->event_type_name }}</span>
        </p>
        <p>
          <span><b>Creator : </b>{{ $event->memberId->getMembership->name }}</span>
        </p>
        <p>
          <span>{{ $event->memberId->email }} -- {{ $event->memberId->getMembership->mobile }}</span>
        </p>
      </div>
      <div class="col-md-4">
        <p>
          <span><b>Date of Request : </b>{{date('F d, Y', strtotime($event->created_at))}}</span>
        </p>
        <p>
          <span><b>Start Date : </b>{{date('F d, Y', strtotime($event->event_start_date))}} - {{ date('h:i:sa', strtotime($event->event_start_time)) }}</span>
        </p>
        <p>
          <span><b>Payment Deadline : </b>{{date('F d, Y', strtotime($event->event_end_date))}} - {{ date('h:i:sa', strtotime($event->payment_deadline)) }}</span>
        </p>
    </div>
    <div class="col-md-4" style="padding-top: 15px;">
      <ul class="list-unstyled pull-right" style="font-size: 16px">
        <li>
        @if(Auth::user()->check())

            <?php 
                $subscribed=false;
                foreach ($subscribedEvents as $subscribedEvent) {
                  if($subscribedEvent->event_id == $event->id)
                    $subscribed=true;
                }
            ?>
            <!-- todo check fior registration date and if it is over then show event-subscription over text -->
            @if($memId != $event->member_id && !$subscribed)

                <!-- Checking for registration time period -->
                
                    @if(!strcmp($memType,'institutional'))     
                      <a class="btn btn-primary"  href={{ route('viewCsiOrganisationSubscriber' , $event->id)}}>Subscribe</a>
                    @else
                      <a class="btn btn-primary"  href={{ route('CsiIndiSubscribe' , $event->id)}}>Subscribe</a>
                    @endif
                
            @else
              @if($memId == $event->member_id)
                <span class="label label-warning pull-right">Creator</span>
              @else
                <span class="label label-success pull-right">Subscribed</span>
              @endif
              <br>
              <a class="btn btn-success pull-right" href={{ route('myEvents', $event->id) }}>
                <span class="glyphicon glyphicon-user"></span>View Event
              </a>
            @endif
        @else
                <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target="#myModal" data-eid="{{$event->id}}">Subscribe</a>
        @endif
        </li>
      </ul>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subscribe to event {{$event->id}}</h4>
      </div>
      <div class="modal-body">
      <h4>  Chose Your member Type : </h4>
      </div>
      <div class="modal-footer">
         <a class="btn btn-primary" href={{ url("login") }}>CSI Member</a>
        <a id="nsi" class="btn btn-primary" href={{ route('nonCsiIndiSubscribe', '-2') }}>Non CSI Individual</a>
        <a id="nso" class="btn btn-primary" href={{ route('viewOrganisationSubscriber', '-2') }}>Non CSI Organisation</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
