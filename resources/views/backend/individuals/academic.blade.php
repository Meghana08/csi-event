@extends('backend.master')

@section('main')
	    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{$typeName}} Institutions</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
			        

                    <h3 class="page-header">Listing All {{$typeName}}</h3>
                    @if (Session::has('flash_notification.message'))
			            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

			                {{ Session::get('flash_notification.message') }}
			            </div>
			        @endif
                    	@if(!($academics->isEmpty()))
                    		<div class="row">
                				<div class="col-md-12">
				                    <div class="panel panel-default">
				                        <div class="panel-heading">
											Filters
				                        </div>
				                        <!-- /.panel-heading -->
				                        <div class="panel-body">
				                            <div class="table-responsive">
				                                <table class="table table-hover">
				                                    <thead>
				                                        <tr>
				                                            <th>#</th>
				                                            <th>Name of member</th>
				                                            <th>gender</th>
				                                            <th>Date of Birth</th>
				                                            <th>account status</th>
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                    	
				                                        @foreach ($academics as $inst)
									                    	
									                    	<tr>
					                                            <td>{{ ++$counter }}</td>
					                                            <td>{{ $inst->getName() }}</td>
					                                            <td>
					                                            	{{ $inst->gender}}
					                                            </td>	
					                                            <td>
					                                            	{{ $inst->dob }}
					                                            </td>
					                                            <td>
					                                            @if ($inst->member->is_verified)
					                                            	verified

					                                            @else
					                                            	
                    		
<a class="btn btn-success" href={{ route('backendIndividualVerifyById', ['typeId' => $typeId, 'id' => $inst->id]) }}>Verify</a>
					                                            	
					                                            @endif
					                                            	<a class="btn btn-primary" href={{ route('backendIndividualById', ['typeId' => $typeId, 'id' => $inst->id]) }}>View Profile</a>
					                                            </td>
					                                        </tr>
									                    @endforeach

				                                        
				                                    </tbody>
				                                </table>
				                            </div>
				                            <!-- /.table-responsive -->
				                        </div>
				                        <!-- /.panel-body -->
				                    </div>
				                    <!-- /.panel -->
				                </div>
                    		</div>
		                    
	                    @else
	                    	<p>No {{$typeName}} are in records</p>
	                    @endif
                    
                </div>
            <!-- /.row -->
            </div>
        </div>
        <!-- /#page-wrapper -->
@endsection