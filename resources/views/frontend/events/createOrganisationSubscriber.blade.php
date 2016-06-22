@extends('frontend.master')
@section('title', 'Non CSI Subscriber Details')
@section('custom-styles')
  <style>
    .section-header-style {
        margin-bottom: 50px;
        text-transform: capitalize;
        text-shadow: 0 0 1px #082238;
        font-size: 28px;
        font-style: italic;
        color: #3f5586;
    }
    p {
        font-size: 16px;
        line-height: 1.4em;
    }
    .box{
      background-color: #F0F0F0 ;
    }

  .ui-datepicker {
  background-color: #fff;
  border: 1px solid #66AFE9;
  border-radius: 4px;
  box-shadow: 0 0 8px rgba(102,175,233,.6);
  display: none;
  margin-top: 4px;
  padding: 10px;
  width: 240px;
}
.ui-datepicker a,
.ui-datepicker a:hover {
  text-decoration: none;
}
.ui-datepicker a:hover,
.ui-datepicker td:hover a {
  color: #2A6496;
  -webkit-transition: color 0.1s ease-in-out;
     -moz-transition: color 0.1s ease-in-out;
       -o-transition: color 0.1s ease-in-out;
          transition: color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-header {
  margin-bottom: 4px;
  text-align: center;
}
.ui-datepicker .ui-datepicker-title {
  font-weight: 700;
}
.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next {
  cursor: default;
  font-family: 'Glyphicons Halflings';
  -webkit-font-smoothing: antialiased;
  font-style: normal;
  font-weight: normal;
  height: 20px;
  line-height: 1;
  margin-top: 2px;
  width: 30px;
}
.ui-datepicker .ui-datepicker-prev {
  float: left;
  text-align: left;
}
.ui-datepicker .ui-datepicker-next {
  float: right;
  text-align: right;
}
.ui-datepicker .ui-datepicker-prev:before {
  content: "\e079";
}
.ui-datepicker .ui-datepicker-next:before {
  content: "\e080";
}
.ui-datepicker .ui-icon {
  display: none;
}
.ui-datepicker .ui-datepicker-calendar {
  table-layout: fixed;
  width: 100%;
}
.ui-datepicker .ui-datepicker-calendar th,
.ui-datepicker .ui-datepicker-calendar td {
  text-align: center;
  padding: 4px 0;
}
.ui-datepicker .ui-datepicker-calendar td {
  border-radius: 4px;
  -webkit-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
     -moz-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
       -o-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
          transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-calendar td:hover {
  background-color: #eee;
  cursor: pointer;
}
.ui-datepicker .ui-datepicker-calendar td a {
  text-decoration: none;
}
.ui-datepicker .ui-datepicker-current-day {
  background-color: #4289cc;
}
.ui-datepicker .ui-datepicker-current-day a {
  color: #fff
}
.ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover {
  background-color: #fff;
  cursor: default;
}

.filterText {
  width: 50px;
}
</style>

@endsection


@section('main')
  <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div>
              <h3 class="section-header-style">Create 
              @if(!$isCSI)
                CSI
              @else
                NON CSI
              @endif
               Organisation Subscrtiber Details Form</h3>
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
            @if($isCSI)
              {!! Form::open(array('route' => ['storeCsiOrganisationSubscriber',$id])) !!}
            @else
              {!! Form::open(array('route' => ['storeOrganisationSubscriber',$id])) !!}
            @endif
                <input type="hidden" id="no_of_candidates" name="no_of_candidates" value="1">

                @if(!$isCSI)
                  <h4> Enter contact Person's Details first : </h4>

                  <div class="form-group">
                    <div class="row">
                    <div class="col-sm-3"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="name" class="req">Organisation Name*</label>
                        <input type="text" name='name'  placeholder='Organisation Name' class="form-control" required />
                         </div>

                        <div class="form-group">
                        <label for="contact_person" class="req">Contact Person*</label>
                        <input type="text" name='contact_person'  placeholder='Contact Person' class="form-control" required />
                         </div>

                        <div class="form-group">
                        <label for="contact_number" class="req">Contact Number*</label>
                        <input type="text" name='contact_number'  placeholder='Contact Number ' class="form-control" required />
                         </div>

                        <div class="form-group">
                        <label for="email" class="req">Email ID*</label>
                        <input type="text" name='email'  placeholder='Email ID' class="form-control" required />
                         </div>
                    </div>
                    <div class="col-sm-3"></div>
                    </div>
                   <hr>
                @endif

                <h4> Enter details of the nominees : </h4>
                <table class="table table-bordered table-hover" id="tab_logic">
                  <thead>
                    <tr >
                      <th class="text-center">
                        #
                      </th>
                      <th class="text-center">
                        Name
                      </th>
                      <th class="text-center">
                        Role/Designation
                      </th>
                      <th class="text-center">
                        Mail
                      </th>
                      <th class="text-center">
                        Contact No.
                      </th>
                      <th class="text-center">
                        Date Of birth
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id='addr0'>
                      <td>
                      1
                      </td>
                      <td>
                      <input type="text" name='name0' placeholder='Name' class="form-control" required />
                      </td>
                      <td>
                      <input type="text" name='role0' placeholder='Role/Designation' class="form-control" required />
                      </td>
                      <td>
                      <input type="text" name='mail0' placeholder='Mail' class="form-control" required />
                      </td>
                      <td>
                      <input type="text" name='mobile0' placeholder='Mobile' class="form-control" required />
                      </td>
                      <td>
                      <input type="text" id='dob0' name='dob0'  placeholder='Date Of Birth' class="form-control" required />
                      </td>
                    </tr>
                              <tr id='addr1'></tr>
                  </tbody>
                </table>
            <a id="add_row" class="btn btn-default pull-left">Add Row</a>
            <a id='delete_row' class="pull-right btn btn-default">Delete Row</a>
            <hr><br>

            <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Submit</button>
            </div>  
             
        
          {!! Form::Close() !!}
        </div>
      </div>
    </section>
@endsection

@section('footer-scripts')
  <script type="text/javascript">
         $(document).ready(function(){
              var i=1;
             $("#add_row").click(function(){
              $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input type='text' name='name"+i+"'  placeholder='Name' class='form-control' required /></td><td><input type='text' name='role"+i+"'  placeholder='Role/Designation' class='form-control' required /></td><td><input type='text' name='mail"+i+"' placeholder='Mail' class='form-control' required /></td><td><input type='text' name='mobile"+i+"' placeholder='Mobile' class='form-control' required /></td><td><input type='text' id='"+i+"' name='dob"+i+"'  placeholder='Date Of Birth' class='form-control' required /></td>");

              $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
              i++; 
              document.getElementById("no_of_candidates").value = i;
          });
             $("#delete_row").click(function(){
               if(i>1){
             $("#addr"+(i-1)).html('');
             i--;
              document.getElementById("no_of_candidates").value = i;
             }
           });

        });

        $(function() {
            $( '#dob0' ).datepicker({
               inline: true,
              dateFormat : 'yy-mm-dd',
              changeMonth: true,
              changeYear: true,
            }).val();
        });
  </script>  
  <script src={{ asset('js/events.js') }}></script>
  <script src={{ asset("js/validateit.js") }}></script>
  <script type="text/javascript">
  </script>
@endsection

