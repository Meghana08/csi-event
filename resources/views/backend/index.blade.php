@extends('backend.master')

@section('page-header')
    <div class="col-md-2">
        <h4>Dashboard</h4>
    </div>
    <div class="col-md-10">
        
    </div>
@endsection

@section('main')
            
    <!-- /.row -->
    <div class="row">
        @include('backend.events.dashboard_events_part')
       
    </div>
    <!-- /.row -->
@endsection


@section('footer-scripts')
    <!-- Morris Charts JavaScript -->
    <script src={{ asset("raphael-min.js") }}></script>
    <script src={{ asset("morris.min.js") }}></script>
    <script src={{ asset("js/morris-data.js") }}></script>
@endsection