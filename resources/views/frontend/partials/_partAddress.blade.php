<div class="steps" data-stp=2>
	<div class="form-group">
		<label for="exampleInputEmail1" class="req">Country*</label>
		<select class="form-control" id="country" data-form="0" name="country">
		  		<option value="invalid">Please select a country</option>
		  		<option value="IND">India</option>							
		  	</select>
	</div>
	<div class="form-group">
		<label for="exampleInputEmail1" class="req">State*</label>
			<select class="form-control" id="state" data-state={{ ( $entity == 'individual-student')? "1" : "0" }} name="state">
		</select>
	</div>
	@if( $entity == 'individual-student')
		<div class="form-group">
		    <label class="control-label" class="req">Student Branch*</label>
		  	<select class="form-control" id="stud_branch" name="stud_branch">
		  		<option>Please select a state from the drop down first</option>
		  	</select>
		</div>
	
	@elseif ( ( $entity == 'institution-academic') || ( $entity == 'institution-non-academic') || ( $entity == 'individual-professional') )
		<div class="form-group">
			<label for="exampleInputEmail1" class="req">Chapters*</label>
			<select class="form-control" id="chapter" name="chapter">
			  		<option value="invalid" selected="selected">Please select a state from the drop down first</option>							
			  	</select>
		</div>
	@endif
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Address*</label>
		{!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Parmanent Address']) !!}
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">City*</label>
		{!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City']) !!}
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Pincode*</label>
		{!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Pincode']) !!}
	</div>
	<div class="btn-group btn-group-justified">
		<a class="col-md-offset-4 btn btn-default previous">Previous</a>
		<a class="btn btn-default next">Next</a>
	</div>

</div>