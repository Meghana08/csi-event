<div id="filter">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => ['adminSubscriberFilters', $id], 'method' => 'get','class' => 'form-inline']) !!}
                

                <div class="form-group">
                    <label for="search"><b>Search By Subscriber Id:-</b></label>
                   {!! Form::text('search_text',$search_text,['class'=>'form-control','placeholder'=>'Enter ID']) !!}



                        @if($csiIndi)
                            {!! Form::checkbox('csiIndi',1,true) !!}
                        @else
                            {!! Form::checkbox('csiIndi',1) !!}
                        @endif
                            {!! Form::label('csiIndi','CSI Individual Member') !!}
                        @if($nonCsiIndi)
                            {!! Form::checkbox('nonCsiIndi',1,true) !!}
                        @else
                            {!! Form::checkbox('nonCsiIndi',1) !!}
                        @endif
                            {!! Form::label('nonCsiIndi','NON CSI Individual Member') !!}
                        @if($csiOrg)
                            {!! Form::checkbox('csiOrg',1,true) !!}
                        @else
                            {!! Form::checkbox('csiOrg',1) !!}
                        @endif
                            {!! Form::label('csiOrg','CSI Organisation') !!}


                            

                        @if($nonCsiOrg)
                            {!! Form::checkbox('nonCsiOrg',1,true) !!}
                        @else
                            {!! Form::checkbox('nonCsiOrg',1) !!}
                        @endif
                            {!! Form::label('nonCsiOrg','Non CSI Organisation') !!}


                </div>

                 
                <button type="submit" class="btn btn-default pull-right">Search</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>