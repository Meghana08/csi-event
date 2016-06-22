@extends('backend.master')

@section('page-header')
  <h4>Payements</h4>
@endsection

@section('main')

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
          @include('backend.partials._paymentView')
        </div>
      </div>
@endsection