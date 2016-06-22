@extends('backend.master')

@section('custom-styles')
    <!-- Timeline CSS -->
    <link href={{ asset('css/timeline.css') }} rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href={{ asset("css/morris.css") }} rel="stylesheet">
    <style>
        span.title {
            font-family: 'Lato', sans-serif;
            font-weight: bold;
            color: #3F5586;
            font-size: 16px;
        }
       
        span.title-text {
            margin: 0px 17px 11px;
            font-size: 16px;
            padding: 5px 20px;
            display: block;
        }

        span.title .glyphicon{
            margin-right: 7px;
        }
        .panel, .btn{
          border-radius: 0px;
        }

    </style>

@endsection

@section('main')
	    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    
                </div>
            </div>

           <div class="row">
                <div class="col-md-12">
                   <h2 class="page-header"><span class="glyphicon glyphicon-user"></span>Profile <small>{{ $user->getName() }}</small>
                  {{--  <a class="btn btn-success pull-right" href={{ route('backendInstitutionById', ['typeId' => 1, 'id' => $id]) }}>Verify this member</a> --}}
                   </h2>
                   <div class="row">

                    @if (Session::has('flash_notification.message'))
                        <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            {{ Session::get('flash_notification.message') }}
                        </div>
                    @endif

                        <div class="col-lg-4">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    General Information
                                </div>
                                <div class="panel-body">
                                    
                                   <div class="col-md-12">
                                      <ul class="list-unstyled">
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Name of the Member</span><br/>
                                            <span class="title-text">
                                            {{ $user->getName() }}
                                            </span>
                                         </li>                     
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Membership Category</span><br/>
                                            <span class="title-text">
                                              @if ($typeId == 1)
                                                {{ $user->membershipType->type }}  - {{ $user->subType->InstitutionType->type  }}
                                              @else 
                                                {{ $user->membershipType->type }}
                                                {{-- expr --}}
                                              @endif
                                            </span>
                                         </li>

                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Email (Login ID)</span><br/>
                                            <span class="title-text">
                                               {{ $user->member->email }}
                                            </span>
                                         </li>
                                         
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Chapter</span><br/>
                                            <span class="title-text">
                                               {{ $user->member->chapter->name }}
                                            </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Region</span><br/>
                                            <span class="title-text">
                                               {{ $user->member->chapter->state->region->name }}
                                            </span>
                                         </li>

                                      </ul>
                                   </div>
                                </div>
                                {{-- <div class="panel-footer">
                                    
                                </div> --}}
                            </div>
                        </div>

                      @if(  $typeId == 4)
                        <div class="col-lg-4">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    Professional Details
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                      <ul class="list-unstyled">
                                          <li>
                                              <span class="title"><span class="glyphicon glyphicon-tag"></span>    Associating Student Branch</span><br/>
                                              <span class="title-text">
                                                  @if ( $user->subType->hasAssociatingInstitution )
                                                      {{ $user->subType->institution->name }}
                                                  @else 
                                                      no associating institution
                                                  @endif
                                              </span>
                                          </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Organisation</span><br/>
                                            <span class="title-text">
                                               {{ $user->subType->organisation }}
                                            </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-briefcase"></span>Designation</span><br/>
                                            <span class="title-text">
                                               {{ $user->subType->designation }}
                                            </span>
                                         </li>
                                      </ul>
                                   </div> 
                                </div>
                                {{-- <div class="panel-footer">
                                    
                                </div> --}}
                            </div>
                        </div>
                      @endif

                      @if( $typeId == 3)
                        <div class="col-lg-4">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    Student Details
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                      <ul class="list-unstyled">
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>Associating Student Branch</span><br/>
                                            <span class="title-text">
                                               {{$user->subType->institution->name}}
                                            </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-tag"></span>College</span><br/>
                                            <span class="title-text">
                                               {{$user->subType->college_name}}
                                            </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-briefcase"></span>Course</span><br/>
                                            <span class="title-text">
                                               {{ $user->subType->course_name }}
                                            </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-briefcase"></span>Course branch</span><br/>
                                            <span class="title-text">                                          
                                          @if ( !is_null($user->subType->course_branch) && $user->subType->course_branch!='' )
                                            {{ $user->subType->course_branch }}
                                          @else
                                              none specifed
                                          @endif
                                           </span>
                                         </li>
                                         <li>
                                            <span class="title"><span class="glyphicon glyphicon-envelope"></span>Course Duration</span><br/>
                                            <span class="title-text">
                                               {{ $user->subType->course_duration }}
                                            </span>
                                         </li>
                                      </ul>
                                   </div> 
                                </div>
                                {{-- <div class="panel-footer">
                                    
                                </div> --}}
                            </div>
                        </div>
                      @endif
                        <div class="col-lg-4">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    Contact Information
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="title"><span class="glyphicon glyphicon-envelope"></span>Primary Email</span><br/>
                                                <span class="title-text">
                                                {{ $user->member->email }}
                                                </span>
                                            </li>
                                            @if ( !is_null($user->member->email_extra) && $user->member->email_extra!='')
                                            <li>
                                               <span class="title"><span class="glyphicon glyphicon-envelope"></span>Secondary Email</span><br/>
                                               <span class="title-text">
                                               {{ $user->member->email_extra }}
                                               </span>
                                            </li>
                                            @endif
                             
                                
                                            @forelse ($user->member->addresses as $address)
                                            <li>
                                                  <span class="title"><span class="glyphicon glyphicon-map-marker"></span>{{ $address->type->type }}</span><br/>
                                                  <span class="title-text">
                                                  <address>
                                                    <strong>{{ $address->address_line_1 }}</strong><br>
                                                    {{ $address->city }}<br>
                                                    {{ $address->state->name }}<br>
                                                    {{ $address->pincode }}<br>
                                                    {{ $address->country->name }}<br>
                                                  </address>
                                                  </span>
                                            </li>
                                            @empty
                                            {{-- <li> --}}
                                                  {{-- empty expr --}}
                                            {{-- </li> --}}
                                            @endforelse

                                            @if (!empty($user->phones))
                                             <li>
                                                <span class="title"><span class="glyphicon glyphicon-earphone"></span>Phone</span><br/>
                                               

                                                @foreach ($user->phones as $phone)
                                                   <span class="title-text">
                                                      <address>
                                                         @if ( !is_null($phone->landline) && $phone->landline!= '')
                                                            <abbr title="Landline">P:</abbr> ({{ $phone->std_code }}) {{ $phone->landline }}
                                                         @endif
                                                         @if ( !is_null($phone->mobile) && $phone->mobile!= '')
                                                            <abbr title="Mobile">P:</abbr> +({{ $phone->country_code }}) {{ $phone->mobile}}
                                                         @endif
                                                      </address>
                                                   </span>
                                                @endforeach
                                             </li>
                                            @endif                             
                                        </ul>
                                      <br/>
                                   </div>
                                </div>
                                {{-- <div class="panel-footer">
                                    
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @forelse ($user->member->payments as $payment)
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ $payment->service->name }}</h3>
                    </div>
                <?php $counter=1; ?>
                @forelse ($payment->journals as $journal)   
                        @forelse ($journal->narration as $n)
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Payment#: {{ $counter++ }}
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Paid By</th>
                                                        <th>Payment Mode</th>
                                                        <th>Transaction#</th>
                                                        <th>Date of Payment</th>
                                                        <th>Rejected?</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $n->payer->subType->getName() }}</td>
                                                        <td>{{ $n->paymentMode->name }}</td>
                                                        <td>{{ $n->transaction_number }}</td>
                                                        <td>{{ $n->date_of_payment }}</td>
                                                        @if ( $n->is_rejected )
                                                            <td>Yes</td>
                                                        @else
                                                            <td>No</td>
                                                            
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-4">
                                                <a class="btn btn-primary" href={{ route('backendIndividualAcceptById', ['typeId'=>$typeId, 'id' => $id, 'pid' => $n->id]) }}>Accept</a>
                                                <a class="btn btn-primary" target="_blank" href={{ url('admin/proofs', ['filename'=> $n->proof]) }}>View Payment Proof</a>

                                                <a class="btn btn-primary" href={{ route('backendIndividualRejectById', ['typeId'=>$typeId, 'id' => $id, 'pid' => $n->id]) }}>Reject</a>
                                            </div>
                                            <div class="col-md-offset-2 col-md-8" style="border-top: 1px solid #ddd;    text-align: center;    margin-top: 20px;">
                                                @if ( $n->is_rejected == -1 )
                                                    <p>new payment, waiting to be approved/rejected</p>
                                                @endif
                                                @if ( $n->is_rejected == 0)
                                                    <p>This payment has been accepted</p>
                                                @else
                                                  @if ( $n->rejection )
                                                    <p>Reason: {{ $n->rejection->reason }}</p>
                                                  @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @empty
                            {{-- empty narration --}}
                        @endforelse

                    @empty
                    {{-- empty expr --}}
                    <tr>
                        <td>no details available</td>
                    </tr>
                @endforelse
                </div>
            @empty
                {{-- empty expr --}}
            @endforelse
            
        </div>
        <!-- /#page-wrapper -->
@endsection


@section('footer-scripts')
    <!-- Morris Charts JavaScript -->
    <script src={{ asset("raphael-min.js") }}></script>
    <script src={{ asset("morris.min.js") }}></script>
    <script src={{ asset("js/morris-data.js") }}></script>
@endsection