@extends('frontend.master')

@section('title', 'Grants')

@section('section-after-mainMenu')

@endsection

@section('main')

	
	<!-- @if (Session::has('flash_notification.message'))
	    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	        {{ Session::get('flash_notification.message') }}
	    </div>
	@endif	-->	
	<section>
		  <div class="container-fluid">
		@if(($users))
<h2 style="text-align:center;">Welcome</h2>

			
			<h3>All of the Research Grant Requests-</h3>
  
	                <div class="panel panel-default panel-list">
	                	<div class="panel-heading compact-pagination">
	                	
	                	</div>
	                    <!-- /.panel-heading -->
	                    <div class="panel-body">
               				 @foreach ($arr as $a)

               				 <a href="/showversions/{{$a->proposal_id}}">
								<div class="listing-items">
		                        	<div class="row">
										<div class="col-md-8">
													<h7><b>Title:</b></h7> {{$a['title']}}
											
											<p>
												<span>
													
													<b>Field:</b> {{$a['field']}}
													
											</p>

											<p><b>version:</b>{{$a->version_number}}
					                    </div>
										<div class="col-md-1">
											<h6><b>Status:</b> 

											@if($a->research_status==0)
           										 new/pending
           										 <br>
												<span class="glyphicon glyphicon-asterisk"></span>
           									           									
           									@elseif($a->research_status==1)
            								     changes required
            									<br>
												<span class="glyphicon glyphicon-repeat"></span>
        									
        									@elseif($a->research_status==2)
            									 accepted
            									 <br>
												<span class="glyphicon glyphicon-ok"></span>
            								           								
            								@elseif($a->research_status==3)
            									 rejected
            									 <br>
												<span class="glyphicon glyphicon-remove"></span>
            								@endif

												
											</h6>
										</div>

										<div class="col-md-1">
											<h6><b>Rs. Grant money /-</b>
											 
										{{$a->proposed_amount}}
																	
											</h6>
										</div>
										<div class="col-md-1">
										<!-- Version number in array-->
											@if(($a->research_status==1))
           										 <h6><a href="{{ action('ResearchGrantController@grantversions',array($a->proposal_id)) }}"><b>Update</b></a></h6>           									        									
        									@elseif(($a->research_status==2)||($a->research_status==3)||($a->research_status==0))
            									 <h6><font color="gray"><strike>Update</strike></font>
											</h6>
            								@endif
										</div>
					                    
					                 </div>
		                        </div>
					                    <hr>
					                 </a>
							@endforeach
                   			<center>{!! $arr->render() !!}</center>
               			 </div>
	                    <!-- panel-footer -->
	                    <div class="panel-footer compact-pagination">
	                    	<div class="row">
	                			<div class="col-md-9">
	                				{{-- other content --}}
	                			</div>
								<div class="col-md-3">
	                					</div>
	                		</div>
	                    </div>
	                </div>
	                <!-- /.panel -->
	            </div>
	</section>

	        
	    @else
	    	<p>No records</p>
	    @endif          
@endsection


