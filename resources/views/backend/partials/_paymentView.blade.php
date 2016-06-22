<div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
  <div class="panel panel-default" id="payment-list">
    <div class="panel-heading">
      <h3>
        #Payment-ID: {{ $payment->id }}
      </h3>
      <p class="lead">
        Service Applied -  Membership <small>for</small> {{ $payment->paymentHead->membershipPeriod->first()->name  }}
      </p>
      <p>
        <span>Request ID - {{$payment->requestService->first()->id}} </span>
        <span>Total Paid Amount - {{$journal->sum('paid_amount')}} </span>
      </p>
    </div>
    <div class="panel-body">
      @foreach($journal->get() as $j)
        @include('backend.partials._paymentCard')
      @endforeach
    </div>
  </div>
</div> <!-- div card-->