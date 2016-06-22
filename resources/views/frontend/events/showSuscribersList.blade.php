@extends('frontend.master')

@section('title', 'Subscribers')


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


@section('section-after-mainMenu')

@endsection

@section('main')
   <section>
        <div class="container-fluid">
          @include('frontend.events.filterSubcriber')

          <h3>Subscribers for event</h3>
        
          <!-- Add anything from here -->

            <div class="panel panel-default panel-list">
                <!-- start panel heading -->
                <div class="panel-heading compact-pagination ">
                    <div class="row">
                          <div class="col-md-9">
                            {{-- other content --}}
                          </div>
                    
                          <div class="col-md-3">
                          </div>
                    </div>
                </div>
                <!-- ending panel-heading -->

                {{-- starting list items --}}
                <div class="panel-body">

                  @foreach($csiIndividualSubscribers as $subscriber)
                     @include('frontend.events.partials._csiIndividualSubscribersCard')
                  @endforeach
                
                  @foreach($csiOrganisationSubscribers as $subscriber)
                     @include('frontend.events.partials._csiOrganisationSubscribersCard')
                  @endforeach

                  @foreach($nonCsiIndividualSubscribers as $subscriber)
                     @include('frontend.events.partials._nonCsiIndividualSubscribersCard')
                  @endforeach
                
                  @foreach($nonCsiOrganisationSubscribers as $subscriber)
                     @include('frontend.events.partials._nonCsiOrganisationSubscribersCard')
                  @endforeach
                </div>
                {{-- ending list items --}}

                  <!-- panel-footer -->
                <div class="panel-footer compact-pagination">
                    <div class="row">
                      <div class="col-md-9">
                        {{-- other content --}}
                      </div>
                      <div class="col-md-3">
                          {{-- some data --}}
                      </div>
                    </div>
                  </div>
                </div>
              <!-- /.panel -->
              <!-- Add anything till here -->
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