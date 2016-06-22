@extends('frontend.master')
@section('title', 'All Events')
@section('custom-styles')
  <style>
    .section-header-style {
        margin-bottom: 50px;
        text-transform: capitalize;
        text-shadow: 0 0 1px #082238;
        font-size: 28px;
        /* text-align: center; */
        font-style: italic;
        color: #3f5586;
        /* text-decoration: underline; */
    }
    p {
        font-size: 16px;
        line-height: 1.4em;
    }
    .box{
      background-color: #F0F0F0 ;
    }
  </style>
@endsection

@section('main')

<!--carousal-->
<div id="carousel-example-generic" class=" container carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="overlay"></div>
    <div class="item active">
      <img src={{ asset('img/PIC3.jpg') }} alt="...">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src={{ asset('img/PIC3.jpg') }} alt="...">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

 <br>

<div class="box">
    <div class="container">
        <div class="col-md-12">
      <center> <h2>Upcomming Events</h2></center>     
        </div>
    </div>
</div>
   
<div class="container">
  <div>
    @foreach($latestEvents as $latestEvent)
       <div class="box col-sm-4">                       
            <h3><span class="label label-primary">{{$latestEvent->event_name}}</span></h3>              
            <p>{{$latestEvent->event_description}}</p>
      </div>
      @endforeach
  </div>
</div>

<br>

<div class="box">
    <div class="container">
        <div class="col-md-12">
      <center> <h2>Events this week</h2></center>     
        </div>
    </div>
</div>
   
<section id="main">
  <div class="container-fluid">
            <div class="panel panel-default panel-list">
                <!-- start panel heading -->
                <div class="panel-heading compact-pagination ">
                  <div class="row">
                    <div class="col-md-9">
                      {{-- other content --}}
                    </div>
                    <div class="col-md-3">
                        <!-- some data -->
                      
                    </div>
                  </div>
               </div>
                <!-- ending panel-heading -->

                {{-- starting list items --}}
                <div class="panel-body">
                  @if(!($events->get()->isEmpty()))
                    @foreach($events->get() as $event)
                        @include('frontend.events.partials._viewAllEventCard')
                    @endforeach   
                  @else
                      <p>No records</p>
                  @endif 
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
  <script type="text/javascript">
    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var event_id = button.data('eid') 
      var modal = $(this)
      var url = modal.find('.modal-footer #nsi').attr('href');
      url = url.replace("-2", event_id);
      modal.find('.modal-footer #nsi').attr('href', url);

      url = modal.find('.modal-footer #nso').attr('href');
      url = url.replace("-2", event_id);
      modal.find('.modal-footer #nso').attr('href', url);
      $('#myModalLabel').text('Subscribe to event '+event_id);
    });
  </script>
@endsection
