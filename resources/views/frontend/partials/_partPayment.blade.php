<div class="steps">
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Mode of transaction*</label>
			{!! Form::select('paymentMode', $payModes, null, ['class'=>'form-control'])!!}

	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Transaction Number*</label>
		{!! Form::text('tno', null, ['class'=>'form-control', 'placeholder'=>'Transaction/ Cheque/ DD number'])!!}
		<span class="help-text">(in case of online payment)/Cheque/DD Number, not required in case of cash</span>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Payable Amount</label>
		<p class="card card_amount">
			<span>Membership Fee:&nbsp;</span><span id="fee"></span>
			<br>
			<span>Service Tax:&nbsp;</span><span id="tax"></span>%
			<br>
			<span style="color:RED">Total Payable Amount:&nbsp;Rs.&nbsp;</span><span id="payable" style="color:RED"></span>								
		</p>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Drawn On*</label>
		{!! Form::text('drawn', null, ['class'=>'form-control', 'id'=>'drawn_on'])!!}
		<span class="help-text"></span>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Bank Name*</label>
		{!! Form::text('bank', null, ['class'=>'form-control', 'placeholder'=>'Enter the Bank Name'])!!}
		<span class="help-text"></span>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Branch Name*</label>
		{!! Form::text('branch', null, ['class'=>'form-control', 'placeholder'=>'Enter the Branch of the bank'])!!}
		<span class="help-text"></span>
	</div>
	<div class="form-group">
		<label for="exampleInputFile" class="req">Payment Receipt*</label>
		<input type="file" name="paymentReciept" id="paymentReciept">
		<p class="help-block">Please upload your payment receipt.(file types allowed are jpg/png/bmp/pdf</p>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1" class="req">Total Amount Paid*</label>
		{!! Form::text('amountPaid', null, ['class'=>'form-control', 'id'=>'amount_paid'])!!}
		<span class="help-text"></span>
	</div>
	<div class="btn-group btn-group-justified">
		<a class="col-md-offset-4 btn btn-default previous">Previous</a>
		<a class="btn btn-default" name="submit" id="submit">Submit</a>
	</div>
</div>