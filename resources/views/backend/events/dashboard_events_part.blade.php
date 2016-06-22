
<div class="row">
<div class="col-md-12">
   <h2>Events Requests</h2> 
</div>
   </div> 
<div class="row">
<div class="col-md-6">  
      <!-- /.row -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel dashboard-divs panel-primary">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-md-12">
                        <h5 style="color: #fff">Events</h5>
                        <p>There are <span class="badge">{{$pendingEventRequests}}</span> request pending</p>
                     </div>
                  </div> <!-- row -->
                  <div class="row">
                     <div class="col-md-12">
                        <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',1) }}" style="color:#fff">
                           <span class="pull-left">Click here to View All Events</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                        <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',2) }}" style="color:#fff">
                           <span class="pull-left">Click here to process Pending Events</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                        <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',3) }}" style="color:#fff">
                           <span class="pull-left">Click here to View Accepted Events</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                         <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',4) }}" style="color:#fff">
                           <span class="pull-left">Click here to View Rejected Events</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                         <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',5) }}" style="color:#fff">
                           <span class="pull-left">Click here to View Closed Events</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                        
                     </div>
                  </div> <!-- row -->
                  
               </div> <!-- panel-heading -->
            </div>   <!-- panel -->
         </div>   <!-- div.md-4 -->         
      </div> <!-- /.row -->
    </div><!--col-->


<div class="col-md-6">
      <!-- /.row -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel dashboard-divs panel-primary">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-md-12">
                        <h5 style="color: #fff">Event Cancellation Requests</h5>
                        <p>There are <span class="badge">{{$pendingEventCancelRequests}}</span> request pending</p>
                     </div>
                  </div> <!-- row -->
                  <div class="row">
                     <div class="col-md-12">
                        <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',6) }}" style="color:#fff">
                           <span class="pull-left">Click here to View All Cacellation Requests</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>
                        <hr style="border-top: dashed 1px #444444"; />
                        <a href="{{ route('adminViewSpecificEvents',7) }}" style="color:#fff">
                           <span class="pull-left">Click here to View Accepted Cacellation Requests</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                           <div class="clearfix"></div>
                        </a>                        
                     </div>
                  </div> <!-- row -->
                  
               </div> <!-- panel-heading -->
            </div>   <!-- panel -->
         </div>   <!-- div.md-4 -->         
      </div> <!-- /.row -->
    </div><!--col-->
</div>