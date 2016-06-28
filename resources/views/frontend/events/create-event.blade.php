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
                    <h3 class="section-header-style">
                        Create Event Form
                    </h3>
                </div>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                    <br>
                    </br>
                </div>
                @endif

            {!! Form::open(array('route' => ['createEvent'], 'files'=>true)) !!}
            {{ csrf_field() }}
                <div class="steps" data-stp="1">
                    <div class="form-group">
                        <label class="req" for="event_name">
                            Event Title*
                        </label>
                        {!! Form::text('event_name', old('event_name'), ['class' => 'form-control', 'placeholder' => 'Title of the Event']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_theme">
                            Event Theme*
                        </label>
                        {!! Form::text('event_theme', old('event_theme'), ['class' => 'form-control', 'placeholder' => 'Theme of the Event']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_type_id">
                            Event Type*
                        </label>
                        <br>
                            {!! Form::select('event_type_id', array('1' => 'Conference', '2' => 'Seminar or Talks','3'=>'Cultural','4'=>'Workshop',5=>'Other')); !!}
                            <br>
                            </br>
                        </br>
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_start_date">
                            Start Date*
                        </label>
                        {!! Form::text('event_start_date', old('event_start_date'), ['class'=>'form-control', 'id'=>'event_start_date'])!!}
                        <span class="help-text">
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_end_date">
                            End Date*
                        </label>
                        {!! Form::text('event_end_date', old('event_end_date'), ['class'=>'form-control', 'id'=>'event_end_date'])!!}
                        <span class="help-text">
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_start_time">
                            Start Time(HH:MM:SS)*
                        </label>
                        {!! Form::text('event_start_time', old('event_start_time'), ['class' => 'form-control', 'placeholder' => 'Start Time']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_end_time">
                            End Time(HH:MM:SS)*
                        </label>
                        {!! Form::text('event_end_time', old('event_end_time'), ['class' => 'form-control', 'placeholder' => 'End Time']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_venue">
                            Event Venue*
                        </label>
                        {!! Form::text('event_venue', old('event_venue'), ['class' => 'form-control', 'placeholder' => 'Venue of the Event']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_description">
                            Event Description*
                        </label>
                        {!! Form::text('event_description', old('event_description'), ['class' => 'form-control', 'placeholder' => 'Description of the Event']) !!}
                    </div>
                    <div class="form-group" id="pay">
                        <label class="req">
                            Payment Option*
                        </label>
                        <div class="radio">
                            <label class="radio-inline">
                                <input checked="" id="payment_option1" name="payment_option" type="radio" value="0">
                                    Unpaid
                                </input>
                            </label>
                            <label class="radio-inline">
                                <input id="payment_option2" name="payment_option" type="radio" value="1">
                                    Paid
                                </input>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="req">
                            Target Audience*
                        </label>
                        <div class="checkbox">
                            <label class="checkbox-inline">
                                <input name="targetType_1" type="checkbox" value="1">
                                    CSI Professional
                                </input>
                            </label>
                            <div class="form-group" id="fee_1">
                                <label for="fee_1">
                                    Enter Fee*
                                </label>
                                <input class="form-control" name="fee_1" placeholder="Fee" type="text">
                                </input>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label class="checkbox-inline">
                                <input name="targetType_2" type="checkbox" value="2">
                                    CSI Student
                                </input>
                            </label>
                            <div class="form-group" id="fee_2">
                                <label for="fee_2">
                                    Enter Fee*
                                </label>
                                <input class="form-control" name="fee_2" placeholder="Fee" type="text">
                                </input>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label class="checkbox-inline">
                                <input name="targetType_3" type="checkbox" value="3">
                                    Non CSI Member
                                </input>
                            </label>
                            <div class="form-group" id="fee_3">
                                <label for="fee_3">
                                    Enter Fee*
                                </label>
                                <input class="form-control" name="fee_3" placeholder="Fee" type="text">
                                </input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="req" for="payment_date_deadline">
                            Payment Deadline Date(If Paid)*
                        </label>
                        {!! Form::text('payment_date_deadline', old('payment_date_deadline'), ['class'=>'form-control', 'id'=>'payment_date_deadline', 'placeholder' => 'Deadline Time'])!!}
                        <span class="help-text">
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="req" for="payment_time_deadline">
                            Payment Deadline Time(HH:MM:SS)*
                        </label>
                        {!! Form::text('payment_time_deadline', old('payment_time_deadline'), ['class' => 'form-control', 'placeholder' => 'Deadline Time']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_banner">
                            Event Banner
                        </label>
                        {!! Form::file('event_banner', old('event_banner'), ['class' => 'form-control', 'id'=>'event_banner']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_pdf">
                            Event Description PDF
                        </label>
                        {!! Form::file('event_pdf', old('event_pdf'), ['class' => 'form-control', 'id'=>'event_pdf']) !!}
                    </div>
                    <div class="form-group">
                        <label class="req" for="event_logo">
                            Event Logo
                        </label>
                        {!! Form::file('event_logo', old('event_logo'), ['class' => 'form-control', 'id'=>'event_logo']) !!}
                    </div>
                    <!-- Event Type details -->
                    <hr>
                        <div class="form-group">
                            <label class="req" for="max_seats">
                                Maximum seats available*
                            </label>
                            {!! Form::text('max_seats', old('max_seats'), ['class' => 'form-control', 'placeholder' => 'Maximum number of seats available.']) !!}
                        </div>
                        <div class="form-group">
                            <label class="req" for="registration_start_date">
                                registration Start Date*
                            </label>
                            {!! Form::text('registration_start_date', old('registration_start_date'), ['class'=>'form-control', 'id'=>'registration_start_date'])!!}
                            <span class="help-text">
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="req" for="registration_end_date">
                                Registration End Date*
                            </label>
                            {!! Form::text('registration_end_date', old('registration_end_date'), ['class'=>'form-control', 'id'=>'registration_end_date'])!!}
                            <span class="help-text">
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="req" for="registration_start_time">
                                Registration Start Time(HH:MM:SS)*
                            </label>
                            {!! Form::text('registration_start_time', old('registration_start_time'), ['class' => 'form-control', 'placeholder' => 'Registration Start Time']) !!}
                        </div>
                        <div class="form-group">
                            <label class="req" for="registration_end_time">
                                Registration End Time(HH:MM:SS)*
                            </label>
                            {!! Form::text('registration_end_time', old('registration_end_time'), ['class' => 'form-control', 'placeholder' => 'Registration End Time']) !!}
                        </div>
                        <div class="form-group" id="certification">
                            <label class="req">
                                Certificate Option*
                            </label>
                            <div class="radio">
                                <label class="radio-inline">
                                    <input id="certification_option1" name="certification_option" type="radio" value="0">
                                        Provide
                                    </input>
                                </label>
                                <label class="radio-inline">
                                    <input checked="" id="certification_option2" name="certification_option" type="radio" value="1">
                                        Not Provide
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="meals">
                            <label class="req">
                                Meals Option*
                            </label>
                            <div class="radio">
                                <label class="radio-inline">
                                    <input id="meals_option1" name="meals_option" type="radio" value="0">
                                        Provide
                                    </input>
                                </label>
                                <label class="radio-inline">
                                    <input checked="" id="certification_option2" name="meals_option" type="radio" value="1">
                                        Not Provide
                                    </input>
                                </label>
                            </div>
                        </div>
                        <!-- Event Grant details -->
                        <hr>
                            <div class="form-group">
                                <h5>
                                    Grants To Be Requested
                                </h5>
                                <div class="form-group" id="technical_description">
                                    <label for="technical_description">
                                        Enter Technical Grant Description
                                    </label>
                                    <input class="form-control" name="technical_description" placeholder="Technical Grants" type="text">
                                    </input>
                                </div>
                                <div class="form-group" id="financial_description">
                                    <label for="Financial_description">
                                        Enter Financial Grant Description
                                    </label>
                                    <input class="form-control" name="financial_description" placeholder="Financial Grants" type="text">
                                    </input>
                                </div>
                                <div class="form-group" id="infrastructure_description">
                                    <label for="infrastructure_description">
                                        Enter Infrastructure Grant Description
                                    </label>
                                    <input class="form-control" name="infrastructure_description" placeholder="Infrastructure Grants" type="text">
                                    </input>
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('SUBMIT') !!}
                                </div>
                                {!! Form::Close() !!}
                            </div>
                        </hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('footer-scripts')
    <script src={{ asset('js/events.js') }}></script>
    <script src={{ asset("js/validateit.js") }}></script>
@endsection
