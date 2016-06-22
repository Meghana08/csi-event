<!-- frontend -->
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
      <p>
        <ul class="list-inline sub-heading-list pull-right">
        @if(!strcmp($grant->grantStatus->grant_status_name,'Waiting') || !strcmp($grant->grantStatus->grant_status_name,'Negotiable'))
          <li>
            <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#editGrant" data-gid="{{$grant->id}}" data-gname="{{$grant->grantType->grant_type_name}}" data-desc="{{$grant->grant_description}}">Edit</a>
          </li>
        @endif
        @if(!strcmp($grant->grantStatus->grant_status_name,'Waiting') || !strcmp($grant->grantStatus->grant_status_name,'Negotiable') || !strcmp($grant->grantStatus->grant_status_name,'Rejected'))
          <li>
            <a class="btn btn-danger pull-right" href={{ route('removeGrant', $grant->id) }}>Remove</a>
          </li>
        @endif
        </ul>
      </p>
    </div>
  </div>
</div> <!-- card -->


<!-- Modal For Negotiate/Reject Grants -->
<div class="modal fade" id="editGrant" tabindex="-1" role="dialog" aria-labelledby="editGrantLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editGrantLabel">Edit Grant# </h4>
      </div>

      <div class="modal-body">
        {!! Form::open(array('route' => ['editGrant','-2'], 'method' => 'post', 'files'=>true)) !!}
        {{ csrf_field() }}
        <div class="form-group">
          <textarea id="ta" name="new_grant_description" class="form-control" rows="3" placeholder="Enter grant description" required> </textarea>
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