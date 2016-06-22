@extends('frontend.master')
@section('title', 'Non CSI Subscriber Details')
@section('custom-styles')
  <style>
    .section-header-style {
        margin-bottom: 50px;
        text-transform: capitalize;
        text-shadow: 0 0 1px #082238;
        font-size: 28px;
        /* text-align: center; */
        font-style: italic;
        color: #3f5586;
        /* text-decoration: underline; */
    }
    p {
        font-size: 16px;
        line-height: 1.4em;
    }
    .box{
      background-color: #F0F0F0 ;
    }
  </style>
@endsection

@section('main')
  <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div>
              <h3 class="section-header-style">Create Non-Csi Subscrtiber Details Form</h3>
          </div>
           
           @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

            {!! Form::open(array('route' => ['nonCsiIndiSubscribe', $id], 'files'=>true)) !!}
            <div class="steps" data-stp=1>

              <div class="form-group">
              <label for="non_csi_subscriber_name" class="req">Name*</label>
              {!! Form::text('non_csi_subscriber_name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
               </div>

               <div class="form-group">
              <label for="email_id" class="req">Email ID*</label>
              {!! Form::text('email_id', null, ['class' => 'form-control', 'placeholder' => 'Email Id']) !!}
               </div>
            
           
               <div class="form-group">
                <label for="contact_number" class="req">Contact Number*</label>
              {!! Form::text('contact_number', null, ['class' => 'form-control', 'placeholder' => 'Contact Number']) !!}
               </div>


            <div class="form-group">
              <label for="dob" class="req">Date of birth*</label>
              {!! Form::text('dob', null, ['class'=>'form-control', 'id'=>'dob'])!!}
              <span class="help-text"></span>
            </div>
             <div class="form-group">
              <label for="working_status" class="req">Working Status*</label>
              {!! Form::text('working_status', null, ['class' => 'form-control', 'placeholder' => 'Working Status']) !!}
            </div>
            
            <div class="form-group">
            {!! Form::submit('Subscribe') !!}    
            </div>  
             
        
          {!! Form::Close() !!}
          </div>
        </div>
      </div>
    </section>
@endsection


@section('footer-scripts')
  
  <script src={{ asset('js/events.js') }}></script>
  <script src={{ asset("js/validateit.js") }}></script>
  <script type="text/javascript">
  </script>
@endsection

