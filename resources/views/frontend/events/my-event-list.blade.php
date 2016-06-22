@extends('frontend.master')

@section('title', 'My Events')

@section('section-after-mainMenu')

@endsection

@section('main')
  <section id="main">

      <div class="container-fluid">
        <h3>My Events</h3>
        
          <!-- Add anything from here -->

            @include('frontend.events.filterMyEvents')
            <div class="panel panel-default panel-list">
                <!-- start panel heading -->
                <div class="panel-heading compact-pagination ">
                  <div class="row">
                    <div class="col-md-9">
                      {{-- other content --}}
                    </div>
                    <div class="col-md-3">
                        <!-- some data -->
                        {!! $events->appends(array_except(Request::query(), ['page']) )->render() !!}
                    </div>
                  </div>
               </div>
                <!-- ending panel-heading -->

                {{-- starting list items --}}
                <div class="panel-body">
                  @if(!($events->isEmpty()))
                    @foreach($events as $event)
                        @include('frontend.events.partials._myEventListCard')
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
    $('#eventCancelModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var event_id = button.data('eid') 
      var modal = $(this)
      var url = modal.find('.modal-body form').attr('action');
      url = url.replace("-2", event_id);
      modal.find('.modal-body form').attr('action', url);
      $('#eventCancelModalLabel').text('Event ' + event_id +' Enter reason to cancel :* ');
    });
  </script>
@endsection
