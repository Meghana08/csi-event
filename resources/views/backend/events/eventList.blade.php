@extends('backend.master')


@section('page-header')
    <h4>Events </h4>
@endsection

@section('custom-styles')

<style type="text/css">
  .ui-datepicker {
  background-color: #fff;
  border: 1px solid #66AFE9;
  border-radius: 4px;
  box-shadow: 0 0 8px rgba(102,175,233,.6);
  display: none;
  margin-top: 4px;
  padding: 10px;
  width: 240px;
}
.ui-datepicker a,
.ui-datepicker a:hover {
  text-decoration: none;
}
.ui-datepicker a:hover,
.ui-datepicker td:hover a {
  color: #2A6496;
  -webkit-transition: color 0.1s ease-in-out;
     -moz-transition: color 0.1s ease-in-out;
       -o-transition: color 0.1s ease-in-out;
          transition: color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-header {
  margin-bottom: 4px;
  text-align: center;
}
.ui-datepicker .ui-datepicker-title {
  font-weight: 700;
}
.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next {
  cursor: default;
  font-family: 'Glyphicons Halflings';
  -webkit-font-smoothing: antialiased;
  font-style: normal;
  font-weight: normal;
  height: 20px;
  line-height: 1;
  margin-top: 2px;
  width: 30px;
}
.ui-datepicker .ui-datepicker-prev {
  float: left;
  text-align: left;
}
.ui-datepicker .ui-datepicker-next {
  float: right;
  text-align: right;
}
.ui-datepicker .ui-datepicker-prev:before {
  content: "\e079";
}
.ui-datepicker .ui-datepicker-next:before {
  content: "\e080";
}
.ui-datepicker .ui-icon {
  display: none;
}
.ui-datepicker .ui-datepicker-calendar {
  table-layout: fixed;
  width: 100%;
}
.ui-datepicker .ui-datepicker-calendar th,
.ui-datepicker .ui-datepicker-calendar td {
  text-align: center;
  padding: 4px 0;
}
.ui-datepicker .ui-datepicker-calendar td {
  border-radius: 4px;
  -webkit-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
     -moz-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
       -o-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
          transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-calendar td:hover {
  background-color: #eee;
  cursor: pointer;
}
.ui-datepicker .ui-datepicker-calendar td a {
  text-decoration: none;
}
.ui-datepicker .ui-datepicker-current-day {
  background-color: #4289cc;
}
.ui-datepicker .ui-datepicker-current-day a {
  color: #fff
}
.ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover {
  background-color: #fff;
  cursor: default;
}

.filterText {
  width: 50px;
}
</style>

@endsection


@section('main')

<section id="main">
@include('backend.events.filterEvents')
    
<h3>Events List</h3>

<div class="panel panel-default panel-list">
<div class="panel-heading compact-pagination ">
    <div class="row">
          <div class="col-md-9">
            {{-- other content --}}
          </div>
    
          <div class="col-md-3">
                {!! $events->appends(array_except(Request::query(), ['page']) )->render() !!}
          </div>
    </div>
</div>

<!-- panel-body -->
<div class="panel-body">
@if(!($events->isEmpty()))
    @foreach($events as $event)
        <div class="card">
          <div class="row">
              <div class="col-md-8">
                <h5>{{ $event->event_name }}</h5>
              </div>
              <div class="col-md-4">
              </div>
          </div>
          <div class="row">
            <div class="col-md-4">
                <p>
                  <span>
                    <b>Event Type : </b>{{ $event->eventType->event_type_name }}
                    <br>
                    <b>Creator : </b>{{ $event->memberId->getMembership->name }}
                    <br>{{ $event->memberId->email }} -- {{ $event->memberId->getMembership->mobile }}
                  </span>
                </p>
            </div>
            <div class="col-md-4">
                <p>
                  <span>
                    <b>Date of Request : </b>{{date('F d, Y', strtotime($event->created_at))}}
                    <br><b>Start Date : </b>{{date('F d, Y', strtotime($event->event_start_date))}} - {{ date('h:i:sa', strtotime($event->event_start_time)) }}
                    <br><b>End Date : </b>{{date('F d, Y', strtotime($event->event_end_date))}} - {{ date('h:i:sa', strtotime($event->event_end_time)) }}
                  </span>
                </p>                
            </div>
            <div class="col-md-2">
                @if(!strcmp($event->eventStatus->event_status_name,'Accepted'))
                    <span class="label label-success">{{$event->eventStatus->event_status_name}}</span>
                @elseif(!strcmp($event->eventStatus->event_status_name,'Waiting'))
                    <span class="label label-warning">{{$event->eventStatus->event_status_name}}</span>
                @else
                    <span class="label label-danger">{{$event->eventStatus->event_status_name}}</span>
                @endif
            </div>
            <div class="col-md-2" style="padding-top: 15px;">
              <ul class="list-unstyled" style="font-size: 16px">
                <li>
                  <a class="btn btn-info" href={{ route('adminshowSuscribers', $event->id) }}>
                    <span class="glyphicon glyphicon-user"></span>View subscribers
                  </a>
                </li>
                <li>
                  <a class="btn btn-success" href={{ route('adminEventDetails', $event->id) }}>
                    <span class="glyphicon glyphicon-user"></span>View Event
                  </a>
                </li>
              </ul>
            </div>
        </div>
      </div>
      <hr>
    @endforeach

@else
    <p>No records</p>
@endif  
</div>
  
<!-- panel-footer -->
<div class="panel-footer compact-pagination">
    <div class="row">
        <div class="col-md-9">
          {{-- other content --}}
        </div>
        <div class="col-md-3">
          
        </div>
    </div>
</div> 

</section> 
@endsection

@section('footer-scripts')
   <script>
  $(function() {
    $( "#request_to_date" ).datepicker({
       inline: true,
      dateFormat : 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    }).val();

    $( "#request_from_date" ).datepicker({
       inline: true,
      dateFormat : 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    }).val();
});
  </script>

@endsection