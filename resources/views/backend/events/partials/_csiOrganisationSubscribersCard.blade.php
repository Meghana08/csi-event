<!-- Non CSI Details -->
<div class="listing-items">
  <div class="row">
    <div class="col-md-8">        
      <p class="lead">{{$subscriber->memberId->getMembership->name}}</p>
    </div>
    <div class="col-md-3">   
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <p>
        <span>
          CSI - Institution - {{ $subscriber->memberId->getMembership->membershipType->type }}
        </span>
      </p>
      <p>
        <span>
          <b>Subscribed on</b> - {{ date('F d, Y', strtotime($subscriber->created_at))}}
        </span>
      </p>
    </div>
    <div class="col-md-4">
      <p><span><b>Email : </b>{{$subscriber->memberId->email}}</span></p>
      <p><span><b>Contact Number : </b>{{$subscriber->memberId->getMembership->mobile}}</span></p>
      <p><span><b>Date of birth : </b>{{$subscriber->memberId->getMembership->dob}}</span></p>
    </div>
    <div class="col-md-1">
      <p>
        @if($subscriber->Payment_status)
          <span class="label label-success">Paid</span>
        @else
          <span class="label label-danger">Unpaid</span>
        @endif
      </p>
    </div>
    <div class="col-md-3" style="padding-top: 15px;">
      <p>
        <span class="label label-info pull-right">{{ $subscriber->no_of_candidates }} Nominees</span>
      </p>
      <br>
      <ul class="list-unstyled" style="font-size: 16px">
        <li>
          <a class="btn btn-success pull-right" href={{ route('adminshowNomineesCSI', $subscriber->id )}}>
            <span class="glyphicon glyphicon-user"></span>View Nominees
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<hr>