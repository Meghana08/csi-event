@extends('frontend.master')
@section('title', 'Register')
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-12">
   					<div>
					  	<h1 class="section-header-style">academic institutional membership form</h1>
					</div>
   					<ul id="progressbar">
						<li class="active">General Details</li>
						<li>Address Details</li>
						<li>Contact Details</li>
						<li>Professional Details</li>
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
					  <div class="steps">
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
							<label for="exampleInputPassword1 req">First Name*</label>
							{!! Form::text('fname', null, ['class' => 'form-control', 'placeholder' => 'First Name ']) !!}
						</div>						
						<div class="form-group">
							<label for="exampleInputPassword1">Middle Name</label>
							{!! Form::text('mname', null, ['class' => 'form-control', 'placeholder' => 'Middle Name ']) !!}
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Last Name*</label>
							{!! Form::text('lname', null, ['class' => 'form-control', 'placeholder' => 'Last Name ']) !!}
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Name on CSI Card*</label>
							{!! Form::text('card_name', null, ['class' => 'form-control', 'placeholder' => 'Name on CSI Card ']) !!}
						</div>

						<div class="form-group">
							<label for="exampleInputPassword1" class="req">Date of Birth*</label>
							{!! Form::text('dob', null, ['class'=>'form-control', 'id'=>'dob_student'])!!}
							<span class="help-text"></span>
						</div>

						<div class="form-group">
					    <label class="req">Gender*</label>
	      				  <div class="radio">
	      				  		<label class="radio-inline">
									{!! Form::radio('gender', 'm') !!}
									Male
								</label>
								<label class="radio-inline">
									{!! Form::radio('gender', 'f') !!}
									Female 
								</label>
						  </div>
					  </div>
						<div class="btn-group btn-group-justified">
							<a class="btn btn-default next">Next</a>
						</div>
					  </div>
					  
					  
					  @include('frontend.partials._partAddress')
					  @include('frontend.partials._partContact')


					  <div class="steps">
					  	
						<div class="form-group">
						    <label class="control-label" class="req">Organisation Name*</label>
						    {!! Form::text('organisation', null, ['class' => 'form-control', 'placeholder' => 'Enter your organisation name']) !!}
						</div>
					
					<div class="form-group
										">
					    <label class="control-label" class="req">designation*
					    	<span id="helpBlock" class="text-danger">*</span>
					    	</label>
					    {!! Form::text('designation', null, ['class' => 'form-control', 'placeholder' => 'Enter your designation']) !!}
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
	<script src={{ asset('js/function10.js') }}></script>
@endsection

