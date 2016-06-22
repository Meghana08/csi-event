@extends('frontend.master')
@section('title', 'Edit Event')
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
  </style>
@endsection
@section('main')
  <section id="main">
      
      <div class="container"> 


        <h2><center> {{$event->event_name}}</center></h2>
        
      <h3>Edit</h3><br>

      @if(count($errors))
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach 
        </ul> 
      @endif

      {!! Form::open(array('route' => ['editEvent',$event->id], 'files'=>true)) !!}
        {{ csrf_field() }}
        <div class="steps" data-stp=1>


              <div class="form-group">
              <label for="event_name" class="req">Event Title*</label>
              {!! Form::text('event_name', $event->event_name, ['class' => 'form-control', 'placeholder' => 'Title of the Event']) !!}
               </div>

              <div class="form-group">
                <label for="event_theme" class="req">Event Theme*</label>
                {!! Form::text('event_theme', $event->event_theme, ['class' => 'form-control', 'placeholder' => 'Theme of the Event']) !!}
              </div>
            
              
               <div class="form-group">
                <label for="event_type_id" class="req">Event Type*</label><br>

               <select name="event_type_id" value="{{$event->event_type_id}}">
                  @foreach($eventType as $type)
                    <option value="{{$type->id}}">{{$type->event_type_name}}</option>
                  @endforeach
               </select>
               <br>
               </div>


              <div class="form-group">
                <label for="event_start_date" class="req">Start Date*</label>
                {!! Form::text('event_start_date', date('d/m/Y', strtotime($event->event_start_date)), ['class'=>'form-control', 'id'=>'event_start_date'])!!}
                <span class="help-text"></span>
              </div>

            

             <div class="form-group">
              <label for="event_end_date" class="req">End Date*</label>
              {!! Form::text('event_end_date',  date('d/m/Y', strtotime($event->event_end_date)), ['class'=>'form-control', 'id'=>'event_end_date'])!!}
              <span class="help-text"></span>
            </div>

              <div class="form-group">
              <label for="event_start_time" class="req">Start Time(HH:MM:SS)*</label>
              {!! Form::text('event_start_time', $event->event_start_time, ['class' => 'form-control', 'placeholder' => 'Start Time']) !!}
               </div>

                <div class="form-group">
              <label for="event_end_time" class="req">End Time(HH:MM:SS)*</label>
              {!! Form::text('event_end_time', $event->event_end_time, ['class' => 'form-control', 'placeholder' => 'End Time']) !!}
               </div>


            <div class="form-group">
              <label for="event_venue" class="req">Event Venue*</label>
              {!! Form::text('event_venue', $event->event_venue, ['class' => 'form-control', 'placeholder' => 'Venue of the Event']) !!}
            </div>

            <div class="form-group">
              <label for="event_description" class="req">Event Description*</label>
              {!! Form::text('event_description', $event->event_description, ['class' => 'form-control', 'placeholder' => 'Description of the Event']) !!}
            </div>            

           <div id="pay" class="form-group">
              <label class="req">Payment Option*</label>
              @if($event->payment_option)
                <div class="radio">
                  <label class="radio-inline">
                    <input type="radio" name="payment_option" id="payment_option1" value="0"> Unpaid
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  name="payment_option" id="payment_option2" value="1" checked> Paid
                  </label>
                </div>
              @else
                <div class="radio">
                  <label class="radio-inline">
                    <input type="radio" name="payment_option" id="payment_option1" value="0" checked> Unpaid
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  name="payment_option" id="payment_option2" value="1"> Paid
                  </label>            
                </div>
              @endif
            </div>


             <div class="form-group">
              <label class="req">Target Audience*</label>
              @foreach($targetAudience as $type)
                <?php 
                  $fee=-1;
                  foreach($targetAudienceWithFee as $audience) {
                    if($type->id == $audience->target_id)
                      $fee=$audience->fee;
                  }
                ?>
                @if($fee!=-1)
                  <div class="checkbox">
                      <label class="checkbox-inline">
                        <input name="{{'targetType_'.$type->id}}" type="checkbox" value="{{$type->id}}" checked> {{$type->target_name}}
                      </label>

                      <div id="{{'fee_'.$type->id}}" class="form-group">
                        <label for="{{'fee_'.$type->id}}" >Enter Fee*</label>
                        {!! Form::text('fee_'.$type->id, $fee, ['class' => 'form-control', 'placeholder' => 'Fee']) !!}
                     </div>
                  </div>
                @else
                  <div class="checkbox">
                      <label class="checkbox-inline">
                        <input name="{{'targetType_'.$type->id}}" type="checkbox" value="{{$type->id}}" > {{$type->target_name}}
                      </label>

                      <div id="{{'fee_'.$type->id}}" class="form-group">
                        <label for="{{'fee_'.$type->id}}" >Enter Fee*</label>
                        {!! Form::text('fee_'.$type->id, null, ['class' => 'form-control', 'placeholder' => 'Fee']) !!}
                     </div>
                  </div>
                @endif
              @endforeach
             
                
            </div>

            <div class="form-group">
              <label for="payment_date_deadline" class="req">Payment Deadline Date(If Paid)*</label>
              {!! Form::text('payment_date_deadline',  date('d/m/Y', strtotime($event->payment_date_deadline)), ['class'=>'form-control', 'id'=>'payment_date_deadline'])!!}
              <span class="help-text"></span>
            </div>

            <div class="form-group">
              <label for="payment_time_deadline" class="req">Payment Deadline Time(If Paid)*</label>
              {!! Form::text('payment_time_deadline',$event->payment_time_deadline, ['class'=>'form-control', 'id'=>'payment_date_deadline'])!!}
              <span class="help-text"></span>
            </div>

           

            <div class="form-group">
              <label for="event_banner" class="req">Event Banner : </label><br>
                 @if(!is_null($event->event_banner))
                  <img width="80%" src={{ asset('event/event_banners/'.$event->event_banner) }} alt="...">
                 @endif
              {!! Form::file('event_banner',null, ['class' => 'form-control', 'id'=>'event_banner']) !!}
            </div>

            <div class="form-group">
              <label for="event_pdf" class="req">Event Description PDF : 
               @if(!is_null($event->event_pdf))
                <a href={{ asset('event/event_pdfs/'.$event->event_pdf) }}>Description File</a>
               @endif
              </label>
              {!! Form::file('event_pdf',null, ['class' => 'form-control', 'id'=>'event_pdf']) !!}
            </div>

            <div class="form-group">
              <label for="event_logo" class="req">Event Logo : 
              @if(!is_null($event->event_logo))
                <img height="20px" width="20px" src={{ asset('event/event_logos/'.$event->event_logo) }} alt="...">
              @endif
              </label>
              {!! Form::file('event_logo', null, ['class' => 'form-control', 'id'=>'event_logo']) !!}
            </div>




            <!-- Event Type details -->
            <hr>

                <div class="form-group">
              <label for="max_seats" class="req">Maximum seats available*</label>
              {!! Form::text('max_seats', $eventTypeDetail->max_seats, ['class' => 'form-control', 'placeholder' => 'Maximum number of seats available.']) !!}
               </div>


            <div class="form-group">
              <label for="registration_start_date" class="req">registration Start Date*</label>
              {!! Form::text('registration_start_date',  date('d/m/Y', strtotime($eventTypeDetail->registration_start_date)), ['class'=>'form-control', 'id'=>'registration_start_date'])!!}
              <span class="help-text"></span>
            </div>

            

             <div class="form-group">
              <label for="registration_end_date" class="req">Registration End Date*</label>
              {!! Form::text('registration_end_date',  date('d/m/Y', strtotime($eventTypeDetail->registration_end_date)), ['class'=>'form-control', 'id'=>'registration_end_date'])!!}
              <span class="help-text"></span>
            </div>

              <div class="form-group">
              <label for="registration_start_time" class="req">Registration Start Time(HH:MM:SS)*</label>
              {!! Form::text('registration_start_time', $eventTypeDetail->registration_start_time, ['class' => 'form-control', 'placeholder' => 'Registration Start Time']) !!}
               </div>

                <div class="form-group">
              <label for="registration_end_time" class="req">Registration End Time(HH:MM:SS)*</label>
              {!! Form::text('registration_end_time', $eventTypeDetail->registration_end_time, ['class' => 'form-control', 'placeholder' => 'Registration End Time']) !!}
               </div>

           <div id="certification" class="form-group">
              <label class="req">Certificate Option*</label>
              @if($eventTypeDetail->certification)
                <div class="radio">
                  <label class="radio-inline">
                    <input type="radio" name="certification_option" id="certification_option1" value="0" > Not Provide
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  name="certification_option" id="certification_option2" value="1"  checked> Provide
                  </label>                
                </div>
              @else
                <div class="radio">
                  <label class="radio-inline">
                    <input type="radio" name="certification_option" id="certification_option1" value="0" checked> Not Provide
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  name="certification_option" id="certification_option2" value="1"  > Provide
                  </label>                
                </div>
              @endif
            </div>

            <div id="meals" class="form-group">
              @if($eventTypeDetail->meals)
                <label class="req">Meals Option*</label>
                    <div class="radio">
                  <label class="radio-inline">
                  <input type="radio" name="meals_option" id="meals_option1" value="0"> Not Provide
                </label>
                <label class="radio-inline">
                  <input type="radio"  name="meals_option" id="certification_option2" value="1" checked> Provide
                </label>
              @else
                <label class="req">Meals Option*</label>
                    <div class="radio">
                  <label class="radio-inline">
                  <input type="radio" name="meals_option" id="meals_option1" value="0" checked> Not Provide
                </label>
                <label class="radio-inline">
                  <input type="radio"  name="meals_option" id="certification_option2" value="1"> Provide
                </label>
              @endif
              </div>
            </div>




            <!-- Event Grant details -->
            <hr>

            <div class="form-group">
            <h5>Grants To Be Requested</h5>
              @foreach($grantType as $type)
                <?php 
                  $description = "";
                  foreach($eventGrant as $grant) {
                    if($type->id == $grant->grant_type_id)
                      $description = $grant->grant_description;
                  }
                ?>
                <div id="{{$type->grant_type_name}}_description" class="form-group">
                  <label for="{{$type->grant_type_name}}_description" >{{$type->grant_type_name}} Grant Description</label>
                  <input type="textarea" class="form-control" name="{{$type->grant_type_name}}_description" placeholder="{{$type->grant_type_name}} Grants" value="{{$description}}">
                </div>
              @endforeach
            </div>
            
        <div> 
          {!! Form::submit('SUBMIT') !!} 
        </div>
          {!! Form::Close() !!}
        <br><br><br><br>
      </div>

      

    </section>
@endsection