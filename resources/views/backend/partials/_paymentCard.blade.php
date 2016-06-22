<div class="list-card">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">
                <span>Transaction #: {{ $j->narrations->first()->transaction_number }} </span>
                <span class="pull-right">Dated: {{ $j->narrations->first()->date_of_payment->toFormattedDateString() }} </span>
              </p>
              <h6 style="font-weight:bold; color: #000">
                Amount Paid: {{ $j->paid_amount }}
              </h6>
            </div>
          </div>
        
        <div class="row">
          <div class="col-md-3">
            <ul class="list-unstyled">
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Paid By</span>
                {{ $j->narrations->first()->payer->getMembership->getName() }}
              </li>
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Drafted Amount</span>
               {{ $j->narrations->first()->drafted_amount }}
              </li>
              
            </ul>
          </div>
          <div class="col-md-3">
            <ul class="list-unstyled">
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Drafted Amount</span> 
                {{ $j->narrations->first()->paymentMode->name }}
              </li>
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Payment Mode</span>
                {{ $j->narrations->first()->paymentMode->name }}
              </li>
            </ul>
          </div>
          <div class="col-md-3">
            <ul class="list-unstyled">
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Bank</span>
                {{ $j->narrations->first()->bank }}
              </li>
              <li>
                <span class="glyphicon glyphicon-briefcase"></span><span class="header">Branch</span>
                {{ $j->narrations->first()->branch }}
              </li>
            </ul>
          </div>
          
        </div> <!-- row -->
      </div> <!-- card -->