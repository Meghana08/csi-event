@extends('frontend.master')
@section('title', 'Register')

@section('custom-styles')
   <link rel="stylesheet" type="text/css" href={{ asset('css/sidebar.css') }}>
@endsection

@section('main')
<section id="main">

   {{-- start --}}

<div class="container-fluid">
   <div class="row affix-row">
      <div class="col-sm-3 col-md-2 affix-sidebar">
         @if (Auth::user()->user()->is_verified == 1)
            @include('frontend.partials.dashboardSidebar')
         @endif
      </div>

      <div class="col-sm-9 col-md-10" style="padding: 0px 60px;" id="profile">
                 
         <div class="row">
            <div class="col-md-12">
               <h2 class="page-header"><span class="glyphicon glyphicon-user"></span>Request for being a Student Branch</h2>
               @if(Auth::user()->user()->subType->subType->is_student_branch == -1)
                <p>By clicking the link below you confirm to be a student branch</p>
                {!! Form::open(['url' => ['makeStudentBranch'] ]) !!}
                        <!-- Change this to a button or input when using this as a form -->
                         <div class="col-md-2">
                            <button class="btn btn-success btn-block" type="submit">Confirm</button>
                        </div>
                        <div class="col-md-2">
                            <a href={{ url('dashboard') }} class="btn btn-primary">Cancel</a>
                        </div>
                {!! Form::Close() !!}
                @endif
                
                @if(Auth::user()->user()->subType->subType->is_student_branch == 0)
                    <p>Your request is in processing</p>
                @endif

            </div>
         </div>

      </div>
   </div>

</div>

{{-- end --}}
<br/>
<br/>
</section>
@endsection