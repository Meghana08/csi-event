@extends('frontend.master')
@section('title', 'Register')
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-offset-4 col-md-4">
   					<div>
					  <h1 class="section-header-style">Login</h1>
					</div>

					@if ( $errors->any() )
   						<ul class="no-style">
   						@foreach ($errors->all() as $error)
   							<li>{{ $error }}</li>
   						@endforeach
   						</ul>
   				@endif

   					{!! Form::open(['url' => 'login']) !!}
					  	
						<div class="form-group">
							<label for="exampleInputPassword1">Email</label>
        					<input type="email" class="form-control"  name="email" value="{{ old('email') }}">

						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
        					<input type="password" class="form-control"  name="password" id="password">

						</div>
					    <div>
					        <button type="submit">Login</button>
					    </div>
		
					{!! Form::Close() !!}
   				</div>
   			</div>
   		</div>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   		<br/>
   	</section>
@endsection


@section('footer-scripts')
	<script src={{ asset("js/validateit.js") }}></script>
	<script src={{ asset('js/function7.js') }}></script>
@endsection