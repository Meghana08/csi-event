<!-- backend -->
<div class="list-card">
  <div class="row">
    <div class="col-md-12">
      <p class="lead">
        <span>Grant #: {{ $grant->grantType->grant_type_name }} </span>
        @if(!strcmp($grant->grantStatus->grant_status_name,'Accepted'))
            <span class="label label-success pull-right">{{ $grant->grantStatus->grant_status_name }}</span>
        @elseif(!strcmp($grant->grantStatus->grant_status_name,'Waiting'))
            <span class="label label-warning pull-right">{{ $grant->grantStatus->grant_status_name }}</span>
        @else
            <span class="label label-danger pull-right">{{ $grant->grantStatus->grant_status_name }}</span>
        @endif
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6">
          <p>
            <h6 style="font-weight:bold; color: #000">
              {{ $grant->grant_description }}
            </h6>
          </p>
        </div>
        <div class="col-md-6">
          <p>
            <span><b>Reason of status(if any) : </b></span>
          </p>
          <p>
            <span>{{ $grant->reason }}</span>
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
    @if(!strcmp($grant->grantStatus->grant_status_name,'Waiting'))
      <p>
        <ul class="list-inline sub-heading-list pull-right">
          <li>
            <a class="label label-success pull-right" href={{ route('grantStatusChangeAccept', $grant->id) }} href="#">Accept</a>
          </li>
          <li>
            <a class="label label-primary pull-right" data-toggle="modal" data-target="#grantStatusReason" data-gid={{$grant->id}}  data-status="N">Negotiate</a>
          </li>
          <li>
            <a class="label label-danger pull-right" data-toggle="modal" data-target="#grantStatusReason" data-gid={{$grant->id}} data-status="R">Reject</a>
          </li>
        </ul>
      </p>
    @endif
    </div>
  </div>
</div> <!-- card -->


<!-- Modal For Negotiate/Reject Grants -->
<div class="modal fade" id="grantStatusReason" tabindex="-1" role="dialog" aria-labelledby="grantStatusReasonLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="grantStatusReasonLabel"></h4>
      </div>

      <div class="modal-body">
        {!! Form::open(array('route' => ['grantStatusChangeReject',$grant->id], 'method' => 'post')) !!}
        {{ csrf_field() }}
        <div class="form-group">
          <textarea name="grant_status_reason" class="form-control" rows="3" placeholder="Enter reason of your status chosen" required></textarea>
        </div>          
      </div>
      <div class="modal-footer">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-md">Submit</button>   
          </div>             
      </div> 
          {!! Form::Close() !!}       
    </div>
  </div>
</div>       

@section('footer-scripts')
  <script type="text/javascript">
    $('#grantStatusReason').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var g_action = button.data('status') // Extract info from data-* attributes
      var modal = $(this);
      var url = window.location.origin+"/admin/events";
      var gid = button.data('gid');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      if(g_action=='R') {
        url+="/grant-status-change/"+gid+"/reject";
        console.log(url);
        modal.find('.modal-body form').attr('action', url);
        $('#grantStatusReasonLabel').text('Enter reason to Reject :');
      } else {
        url+="/grant-status-change/"+gid+"/negotiate";
        console.log(url);
        modal.find('.modal-body form').attr('action', url);
        $('#grantStatusReasonLabel').text('Enter your nagotiation');
      }
    });
  </script>
@endsection
