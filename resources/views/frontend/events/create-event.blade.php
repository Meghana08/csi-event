@extends('frontend.master')

@section('custom-styles')
  
@endsection
@section('title', 'Create Event')
@section('main')
  <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div>
              <h3 class="section-header-style">Create Event Form</h3>
          </div>
           
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul><br>
              </div>
          @endif
          @if(!is_null($err))
          <div class="alert alert-danger">
                  {{ $err }}
          </div>
          @endif

             {!! Form::open(array('route' => ['createEvent'], 'files'=>true)) !!}
            {{ csrf_field() }}
            <div class="steps" data-stp=1>


              <div class="form-group">
              <label for="event_name" class="req">Event Title*</label>
              {!! Form::text('event_name', null, ['class' => 'form-control', 'placeholder' => 'Title of the Event']) !!}
               </div>

              <div class="form-group">
                <label for="event_theme" class="req">Event Theme*</label>
                {!! Form::text('event_theme', null, ['class' => 'form-control', 'placeholder' => 'Theme of the Event']) !!}
              </div>
            
              
               <div class="form-group">
                <label for="event_type_id" class="req">Event Type*</label><br>
               {!! Form::select('event_type_id', array('1' => 'Conference', '2' => 'Seminar or Talks','3'=>'Cultural','4'=>'Workshop',5=>'Other')); !!}
               <br>
               </div>


            <div class="form-group">
              <label for="event_start_date" class="req">Start Date*</label>
              {!! Form::text('event_start_date', null, ['class'=>'form-control', 'id'=>'event_start_date'])!!}
              <span class="help-text"></span>
            </div>

            

             <div class="form-group">
              <label for="event_end_date" class="req">End Date*</label>
              {!! Form::text('event_end_date', null, ['class'=>'form-control', 'id'=>'event_end_date'])!!}
              <span class="help-text"></span>
            </div>

              <div class="form-group">
              <label for="event_start_time" class="req">Start Time(HH:MM:SS)*</label>
              {!! Form::text('event_start_time', null, ['class' => 'form-control', 'placeholder' => 'Start Time']) !!}
               </div>

                <div class="form-group">
              <label for="event_end_time" class="req">End Time(HH:MM:SS)*</label>
              {!! Form::text('event_end_time', null, ['class' => 'form-control', 'placeholder' => 'End Time']) !!}
               </div>


            <div class="form-group">
              <label for="event_venue" class="req">Event Venue*</label>
              {!! Form::text('event_venue', null, ['class' => 'form-control', 'placeholder' => 'Venue of the Event']) !!}
            </div>

            <div class="form-group">
              <label for="event_description" class="req">Event Description*</label>
              {!! Form::text('event_description', null, ['class' => 'form-control', 'placeholder' => 'Description of the Event']) !!}
            </div>            

           <div id="pay" class="form-group">
              <label class="req">Payment Option*</label>
                  <div class="radio">
                <label class="radio-inline">
                <input type="radio" name="payment_option" id="payment_option1" value="0" checked> Unpaid
              </label>
              <label class="radio-inline">
                <input type="radio"  name="payment_option" id="payment_option2" value="1"> Paid
              </label>
                
              </div>
            </div>


             <div class="form-group">
              <label class="req">Target Audience*</label>
              @foreach($targetAudience as $type)
                  <div class="checkbox">
                      <label class="checkbox-inline">
                        <input name="{{'targetType_'.$type->id}}" type="checkbox" value="{{$type->id}}"> {{$type->target_name}}
                      </label>

                      <div id="{{'fee_'.$type->id}}" class="form-group">
                        <label for="{{'fee_'.$type->id}}" >Enter Fee*</label>
                        {!! Form::text('fee_'.$type->id, null, ['class' => 'form-control', 'placeholder' => 'Fee']) !!}
                     </div>
                  </div>
              @endforeach
            </div>

            <div class="form-group">
              <label for="payment_date_deadline" class="req">Payment Deadline Date(If Paid)*</label>
              {!! Form::text('payment_date_deadline', null, ['class'=>'form-control', 'id'=>'payment_date_deadline', 'placeholder' => 'Deadline Time'])!!}
              <span class="help-text"></span>
            </div>

            <div class="form-group">
              <label for="payment_time_deadline" class="req">Payment Deadline Time(HH:MM:SS)*</label>
              {!! Form::text('payment_time_deadline', null, ['class' => 'form-control', 'placeholder' => 'Deadline Time']) !!}
            </div>

            <div class="form-group">
              <label for="event_banner" class="req">Event Banner</label>
              {!! Form::file('event_banner', null, ['class' => 'form-control', 'id'=>'event_banner']) !!}
            </div>

            <div class="form-group">
              <label for="event_pdf" class="req">Event Description PDF</label>
              {!! Form::file('event_pdf', null, ['class' => 'form-control', 'id'=>'event_pdf']) !!}
            </div>

            <div class="form-group">
              <label for="event_logo" class="req">Event Logo</label>
              {!! Form::file('event_logo', null, ['class' => 'form-control', 'id'=>'event_logo']) !!}
            </div>

           <!-- Event Type details -->
            <hr>

                <div class="form-group">
              <label for="max_seats" class="req">Maximum seats available*</label>
              {!! Form::text('max_seats', null, ['class' => 'form-control', 'placeholder' => 'Maximum number of seats available.']) !!}
               </div>


            <div class="form-group">
              <label for="registration_start_date" class="req">registration Start Date*</label>
              {!! Form::text('registration_start_date', null, ['class'=>'form-control', 'id'=>'registration_start_date'])!!}
              <span class="help-text"></span>
            </div>

            

             <div class="form-group">
              <label for="registration_end_date" class="req">Registration End Date*</label>
              {!! Form::text('registration_end_date', null, ['class'=>'form-control', 'id'=>'registration_end_date'])!!}
              <span class="help-text"></span>
            </div>

              <div class="form-group">
              <label for="registration_start_time" class="req">Registration Start Time(HH:MM:SS)*</label>
              {!! Form::text('registration_start_time', null, ['class' => 'form-control', 'placeholder' => 'Registration Start Time']) !!}
               </div>

                <div class="form-group">
              <label for="registration_end_time" class="req">Registration End Time(HH:MM:SS)*</label>
              {!! Form::text('registration_end_time', null, ['class' => 'form-control', 'placeholder' => 'Registration End Time']) !!}
               </div>

           <div id="certification" class="form-group">
              <label class="req">Certificate Option*</label>
                  <div class="radio">
                <label class="radio-inline">
                <input type="radio" name="certification_option" id="certification_option1" value="0" > Provide
              </label>
              <label class="radio-inline">
                <input type="radio"  name="certification_option" id="certification_option2" value="1"  checked> Not Provide
              </label>
                
              </div>
            </div>
             <div id="meals" class="form-group">
              <label class="req">Meals Option*</label>
                  <div class="radio">
                <label class="radio-inline">
                <input type="radio" name="meals_option" id="meals_option1" value="0"> Provide
              </label>
              <label class="radio-inline">
                <input type="radio"  name="meals_option" id="certification_option2" value="1" checked> Not Provide
              </label>
                
              </div>
            </div>




            <!-- Event Grant details -->
            <hr>

               <div class="form-group">
            <h5>Grants To Be Requested</h5>
              @foreach($grantType as $type)
                  <div id="{{$type->grant_type_name}}_description" class="form-group">
                  <label for="{{$type->grant_type_name}}_description" >Enter {{$type->grant_type_name}} Grant Description</label>
                  <input type="textarea" class="form-control" name="{{$type->grant_type_name}}_description" placeholder="{{$type->grant_type_name}} Grants" ></input>
              @endforeach
              </div>
                <div class="form-group">
            {!! Form::submit('SUBMIT') !!}    
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
  <script>
  </script>
@endsection