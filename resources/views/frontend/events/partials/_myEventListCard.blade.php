<div class="listing-items">
    <div class="row">
      <div class="col-md-9">        
        <p class="lead">{{ $event->event_name }} - {{ $event->event_theme }}</p>
      </div>
      <div class="col-md-3">   
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
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
      <div class="col-md-3">
        <p>
          <span><b>Date of Request : </b>{{date('F d, Y', strtotime($event->created_at))}}</span>
        </p>
        <p>
          <span><b>Start Date : </b>{{date('F d, Y', strtotime($event->event_start_date))}} - {{ date('h:i:sa', strtotime($event->event_start_time)) }}</span>
        </p>
        <p>
          <span><b>End Date : </b>{{date('F d, Y', strtotime($event->event_end_date))}} - {{ date('h:i:sa', strtotime($event->event_end_time)) }}</span>
        </p>
    </div>
    <div class="col-md-2">
      <p>
          @if(!strcmp($event->eventStatus->event_status_name,'Accepted'))
            <span class="label label-success">{{$event->eventStatus->event_status_name}}</span>
          @elseif(!strcmp($event->eventStatus->event_status_name,'Waiting'))
            <span class="label label-warning">{{$event->eventStatus->event_status_name}}</span>
          @else
            <span class="label label-danger">{{$event->eventStatus->event_status_name}}</span>
          @endif
      </p>
    </div>
    <div class="col-md-4" style="padding-top: 15px;">
      <ul class="list-unstyled pull-right" style="font-size: 16px">
        <li>
          <a class="btn btn-success" href={{ route('myEvents', $event->id) }}>
            <span class="glyphicon glyphicon-user"></span>View Event
          </a>
        @if(!strcmp($event->eventStatus->event_status_name,'Waiting'))
            <a class="btn btn-primary" href={{ route('editEvent', $event->id) }}> Edit </a>
            <a class="btn btn-danger" data-toggle="modal" data-target="#eventCancelModal" data-eid="{{$event->id}}">Cancel</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</div>




<!-- Modal For Cancel Event -->
<div class="modal fade" id="eventCancelModal" tabindex="-1" role="dialog" aria-labelledby="eventCancelModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <h4 class="modal-title" id="eventCancelModalLabel"></h4>
      </div>

      <div class="modal-body">
        <h3>Reason </h3>
        {!! Form::open(array('route' => ['cancelEventRequest','-2'], 'method' => 'post', 'files'=>true)) !!}
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
