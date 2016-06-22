@extends('frontend.master')

@section('custom-styles')
	
@endsection
@section('title', 'Register')
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-12">
   					<div>
					  	<h3 class="section-header-style">academic institutional membership form</h3>
					</div>
   					<ul id="progressbar">
						<li class="active">Institution &amp; Category Details</li>
						<li>Address Details</li>
						<li>Contact Details</li>
						<li>Details of Head of the Institution</li>
						<li>Payment Details</li>
					</ul>

					@if ( $errors->any() )
   						
   						<ul class="list-unstyle">
   						<li>
   						@foreach ($errors->all() as $error)
   							<li>{{ $error }}</li>
   						@endforeach
   						</ul>
   					@endif
   					<div class="page-header">
					  <div class="col-md-8">
					  	<h3 id="stepText"> <small id="stepSubText"></small></h3>
					  </div>
					  <div class="col-md-4">
					  	<p class="pull-right" style="    font-size: 14px;    margin: 35px 15px; color: RED;font-weight: bold;letter-spacing: 1px;">field with * are required</p>
					  </div>
					</div>
   					{!! Form::open(['url' => ['register', 'entity'=>$entity], 'files' => true]) !!}
					  <div class="steps" data-stp=1>
						<div class="form-group">
							<label for="membership-period" class="req">Membership period*</label>
							<div class="radio">
							    @foreach($membershipPeriods as $period)
								    <label class="radio-inline">
										{!! Form::radio('membership-period', $period->id) !!} {{ $period->name }}
									</label>
							    @endforeach
							    
						 	</div>
						</div>
						
						<div class="form-group">
							<label for="institution_type" class="req">Institution Type*</label>
							<div class="radio">
							    @foreach($institutionTypes as $type)
								    <label class="radio-inline">
										{!! Form::radio('institution_type', $type->id) !!}
										{{ $type->name }} 
									</label>
							    @endforeach
								
							</div>
						</div>
						
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Name of the Institution*</label>
							{!! Form::text('nameOfInstitution', null, ['class' => 'form-control', 'placeholder' => 'Name of the Institution']) !!}
						</div>
						<div class="btn-group btn-group-justified">
							<a class="btn btn-default next">Next</a>
						</div>
					  </div>
					  
					  
					  @include('frontend.partials._partAddress')
					  @include('frontend.partials._partContact')


					  <div class="steps">
					  	<div class="form-group">
							<label for="exampleInputPassword1" class="req">Title of applicant*</label>
							<div class="radio">
							    <label class="radio-inline">
									{!! Form::radio('salutation', 1) !!}
									Mr
								</label>
								<label class="radio-inline">
									{!! Form::radio('salutation', 2) !!}
									Miss
								</label>
								<label class="radio-inline">
									{!! Form::radio('salutation', 3) !!}
									Mrs
								</label>
								<label class="radio-inline">
									{!! Form::radio('salutation', 4) !!}
									Dr
								</label>
								<label class="radio-inline">
									{!! Form::radio('salutation', 5) !!}
									Prof 
								</label>								
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Name*</label>
							{!! Form::text('headName', null, ['class' => 'form-control', 'placeholder' => 'Name of the Head of the institution']) !!}
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Designation*</label>
							{!! Form::text('headDesignation', null, ['class' => 'form-control', 'placeholder' => 'Designation of the Head of the institution']) !!}
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Email-ID*</label>
							{!! Form::text('headEmail', null, ['class' => 'form-control', 'placeholder' => 'Email ID of the Head of the institution']) !!}
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Mobile*</label>
							<div class="input-group">
						    	<span class="input-group-addon">+</span>
		      				 	{!! Form::text('country-code', null, ['class' => 'form-control', 'placeholder' => 'Country Code', 'id'=>'country-code', 'style'=> 'width: 30%; float:left']) !!}
						   		{!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'id'=>'mobile', 'style'=> 'width: 70%; float:left']) !!}
						    </div>
						    <div class="row">
					    		<div class="col-md-4" id="errorCountry">
					    			<span id="helpBlock" class="help-block ">STD Code</span>
							    		
					    		</div>
					    		<div class="col-md-6" id="errorMobile">
					    			<span id="helpBlock" class="help-block ">Landline number</span>
						    				
					    		</div>
					    	</div>
						</div>
						<div class="btn-group btn-group-justified">
							<a class="col-md-offset-4 btn btn-default previous">Previous</a>
							<a class="btn btn-default next">Next</a>
						</div>
					  </div>


					  @include('frontend.partials._partPayment')

					{!! Form::Close() !!}
   				</div>
   			</div>
   		</div>
   	</section>
@endsection


@section('footer-scripts')
	<script src={{ asset("js/validateit.js") }}></script>
	<script src={{ asset('js/function7.js') }}></script>
@endsection