@extends('frontend.master')

@section('title', 'Nominees')

@section('section-after-mainMenu')

@endsection

@section('main')
  <section>
      <div class="container-fluid">
          
          <!-- Add anything from here -->

            <div class="panel panel-default panel-list">
                <!-- start panel heading -->
                <div class="panel-heading compact-pagination ">
                  <div class="row">
                  </div>
               </div>
                <!-- ending panel-heading -->

                {{-- starting list items --}}
                <div class="panel-body">
                <?php $i=1; ?>
                @foreach($nominees as $nominee)
                    <div class="listing-items">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="lead">
                            <span class="label label-info">{{ $i }}</span>
                            <span>{{ $nominee->nominee_name }}</span>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <b>Role/Designation :</b>
                            <span>
                              {{$nominee->role}}
                            </span>
                      </div>
                        <div class="col-md-4">
                          <b>Email ID :</b>
                            <span>
                              {{$nominee->email}}
                            </span>
                      </div>
                        <div class="col-md-2">
                          <b>Contact No. :</b>
                            <span>
                              {{$nominee->contact_number}}
                            </span>
                      </div>
                        <div class="col-md-2">
                          <b>Date of Birth :</b>
                            <span>
                              {{$nominee->dob}}
                            </span>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <?php $i++; ?>
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