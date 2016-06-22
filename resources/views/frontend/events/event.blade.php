@extends('frontend.master')
@section('title', 'My Event')
@section('page-header')
  <h4>Events</h4>
  @section('custom-styles')
    <style type="text/css">
      
      #payment-list .label {

              font-size: 12px;
              padding: 5px;
      }
    </style>
  @endsection
@endsection

@section('main')
  <section id="main">
      <div class="row">
        <div class="col-md-12">
          @if (Session::has('flash_notification.message'))
              <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                  {{ Session::get('flash_notification.message') }}
              </div>
          @endif

            
          </div>
      </div>


      <div class="row">
        <div class="col-md-3"> <!-- profile right area -->
          @include('backend.partials._profileSidebar')
        </div> <!-- profile left area -->
       
        <!-- profile area right -->
        <div class="col-md-9">
          @include('frontend.events.partials._eventView')
        </div>
      </div>
  </section>
@endsection

@section('footer-scripts')
  <script type="text/javascript">
    $('#editGrant').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var grant_id = button.data('gid') 
      var grant_name = button.data('gname') 
      var descr = button.data('desc') 
      var modal = $(this)
      var url = modal.find('.modal-body form').attr('action');
      url = url.replace("-2", grant_id);
      modal.find('.modal-body form').attr('action', url);
      $('#editGrantLabel').text('Edit Grant# ' + grant_name);
      $('#ta').text(descr);
    });
  </script>
@endsection