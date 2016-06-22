@extends('backend.master')

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
          @include('backend.events.partials._eventView')
        </div>
      </div>
  </section>
@endsection
