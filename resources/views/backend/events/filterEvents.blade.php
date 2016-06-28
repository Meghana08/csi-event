<div id="filter">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'adminFilters', 'method' => 'get','class' => 'form-inline']) !!}
                <div class="form-group">
                    <div class="checkbox">
                        <label><b>Event Status:-</b></label>
                        @foreach($statuses as $id => $type)                    
                            <label>
                               {!! Form::checkbox('status[]', $id, ( in_array($id, $status_selected) )?true:false) !!} {{ $type }}
                            </label>
                        @endforeach
                    </div>                                  
                </div>


                <div class="form-group">
                    <label for="search"><b>Search By:-</b></label>
                    {!! Form::select('search', $search_options, $search_option_selected) !!}
                    {{-- st = search text --}}
                    {!! Form::input('text', 'search_text', $search_text, ['class' => 'form-control', 'id' => 'search_text']) !!}
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
                {!! Form::hidden('page', $page) !!}
                <button type="submit" class="btn btn-default pull-right">Search</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>