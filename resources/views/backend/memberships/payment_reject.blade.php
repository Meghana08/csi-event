@extends('backend.master')

@section('custom-styles')
    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">
@endsection

@section('main')
	    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Reject Payment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['action' => ['Admin\InstitutionController@store_reject_payment', $typeId, $id, $narration_id ] ]) !!}
                            <div class="form-group">
                                <label class="col-md-12" for="exampleInputPassword1">Rejection Reason</label>
                                {!! Form::textarea('reason', null, ['style' => 'width: 100%']) !!}
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                             <div>
                                <button class="btn btn-success btn-block" type="submit">submit reason</button>
                            </div>
                    {!! Form::Close() !!}
                </div>
            <!-- /.row -->
            </div>
        </div>
        <!-- /#page-wrapper -->
@endsection


@section('footer-scripts')
    <!-- Morris Charts JavaScript -->
    <script src={{ asset("raphael-min.js") }}></script>
    <script src={{ asset("morris.min.js") }}></script>
    <script src={{ asset("js/morris-data.js") }}></script>
@endsection