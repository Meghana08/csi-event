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
			        

                    <h3 class="page-header">Listing All Student Branch Requests</h3>
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
				                                            <th>Name of institution</th>
				                                            <th>Is a Student Branch?</th>
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                    	
				                                        @foreach ($academics as $inst)
									                    	
									                    	<tr>
					                                            <td>{{ ++$counter }}</td>
					                                            <td>{{ $inst->requestedBy->subType->name }}</td>
					                                            <td>
					                                            @if ($inst->requestedBy->subType->subType->is_student_branch == 1)
					                                            	yes

					                                            @else
					                                            	
                    		
<a class="btn btn-success" href={{ route('backendInstitutionMakeStudentBranch', ['rid' => $inst->id]) }}>make a student branch</a>
					                                            	
					                                            @endif
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