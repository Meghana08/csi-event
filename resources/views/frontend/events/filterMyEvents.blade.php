<div id="filter">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'myEventFilters', 'method' => 'get','class' => 'form-inline']) !!}
                <div class="form-group">
                    <label><b>Event Status:-</b></label>
                    @foreach($statuses as $status)
                        @if(in_array($status->id,$checkbox_array))
                            {!! Form::checkbox('status[]',$status->id,true) !!}
                        @else
                            {!! Form::checkbox('status[]',$status->id) !!}
                        @endif
                        {!! Form::label('status',$status->event_status_name) !!}
                    @endforeach                                   
                </div>

                <div class="form-group">
                    <label for="search"><b>Search By:-</b></label>
                    &emsp;
                    {!! Form::select('search', ['0'=>'Select','1' => 'Event id', '2' => 'Event Name', '3' => 'Event Type', '4' => 'Request Id'],$search) !!}
                    &emsp;
                   {!! Form::text('search_text',$search_text,['class'=>'form-control','placeholder'=>'Search text']) !!}
                </div>
                
                <br>         
                <div class="form-group">
                    <label for="request_from_date"><b>Requests from:-</b></label>
                    &emsp;
                    {!! Form::text('request_from_date',$fromDate, ['class'=>'form-control', 'id'=>'request_from_date','placeholder'=>'From Date'])!!}
                    <span class="help-text"></span>
               </div>

               <div class="form-group">
                    <label for="request_to_date"><b>Requests upto:-</b></label>
                    &emsp;
                    {!! Form::text('request_to_date', $toDate, ['class'=>'form-control', 'id'=>'request_to_date','placeholder'=>'To Date'])!!}
                    <span class="help-text"></span>
               </div>

               <div class="form-group">
                     <label for="rows"><b>Records per page</b></label>
                    &emsp;
                    <input type="number" name="rows" maxlength="2" width="20px" class="form-control" id="rows" value="{{$rows}}">
                </div>
                <button type="submit" class="btn btn-default pull-right">Search</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>