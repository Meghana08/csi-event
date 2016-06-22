@extends('backend.master')

@section('page-header')
    <h4>Memberships</h4>
@endsection

@section('main')

	
	@if (Session::has('flash_notification.message'))
	    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	        {{ Session::get('flash_notification.message') }}
	    </div>
	@endif
	
		@if(!($users->getCollection()->isEmpty()))
			<div id="filter">
				<div class="row">
					<div class="col-md-12">
					
						{{-- <ul class="list-unstyled">
							<li>
								<a href="">Institutions</a>
							</li>
						</ul> --}}	
						{!! Form::open(['route' => ['adminMembershipContent'], 'method' => 'get', 'class' => 'form-inline' ]) !!}
							<div class="form-group">
											{!! Form::select('membership-type', $membership_types, null) !!}
								    
							</div>

							<div class="form-group">
								<div class="checkbox">
									@foreach($institution_type as $id => $type)
										<label>
										   {!! Form::checkbox('institution_type[]', $id, false) !!} {{ $type }}
										</label>
									@endforeach
								</div>
							</div>

							<div class="form-group">
								<div class="checkbox">
									<label>verified:
									  <input type="checkbox" name="verified" value="0"> yes
									</label>
									<label>
									  <input type="checkbox" name="not-verified" value="1"> no
									</label>
								</div>
							</div>
							<div class="form-group">
								  <input type="number" class="form-control" name="rows" id="rows" value="15">
							</div>
							<div class="form-group">
								<select name="cat"> <!-- search-cateria, self mapped, no db interaction -->
									<option value="0">member id</option>
									<option value="1">email</option>
									<option value="2">request id</option>
									<option value="3">region</option>
									<option value="4">state</option>
									<option value="5">chapter</option>
									<option value="6">student-branch</option>
								</select>
					  
								  <input type="text" class="form-control" name="search_text" id="search_text" placeholder="Enter text">
							</div>
							<button type="submit" class="btn btn-default pull-right">Search</button>
						</form>
						{!! Form::close() !!}
					</div>
				</div>

			</div>
			<h3>Listing All </h3>
			
			
	                
	                <div class="panel panel-default panel-list">
	                	<div class="panel-heading compact-pagination ">
	                		<div class="row">
	                			<div class="col-md-9">
	                				{{-- other content --}}
	                			</div>
								<div class="col-md-3">
	                					{!! $users->appends(array_except(Request::query(), ['page']) )->render() !!}
	                			</div>
	                		</div>
	                	</div>
	                    <!-- /.panel-heading -->
	                    <div class="panel-body">
							@foreach ($users as $user)
								<div class="card">
		                        	<div class="row">
										<div class="col-md-8">
											<h6>{{ $user->getMembership->getName() }}</h6>
											<p>
												<span>
													{{ $user->membership->type }}-{{ $user->getMembership->membershipType->type }}
													{{ $user->chapter->name }}
												</span>
											</p>
					                    </div>
										<div class="col-md-1">
											<h6>
												<span class="glyphicon glyphicon-ok"></span>
											</h6>
										</div>
					                    <div class="col-md-3" style="padding-top: 15px;">
					                    	<ul class="list-unstyled" style="font-size: 16px">
					                    		<li>
					                    			<a href="#"><span class="glyphicon glyphicon-user"></span></a>
					                    			<a href={{ route('adminMemberPaymentDetails', $user->id) }}><span class="glyphicon glyphicon-usd"></span></a>
					                    		</li>
					                    	</ul>
					                    </div>
					                 </div>
		                        </div>
							@endforeach

	                        
			            </div>
	                    <!-- panel-footer -->
	                    <div class="panel-footer compact-pagination">
	                    	<div class="row">
	                			<div class="col-md-9">
	                				{{-- other content --}}
	                			</div>
								<div class="col-md-3">
	                					{!! $users->appends(array_except(Request::query(), ['page']) )->render() !!}
	                			</div>
	                		</div>
	                    </div>
	                </div>
	                <!-- /.panel -->
	            </div>
			</div>
	        
	    @else
	    	<p>No records</p>
	    @endif
                    
@endsection