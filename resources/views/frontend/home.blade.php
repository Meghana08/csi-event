@extends('frontend.master')
@section('title', 'Dashboard home')


@section('main')
<section id="main"> 

   {{-- start --}}


<div class="container-fluid">
 
<div class="row">
   <div class="col-md-offset-2 col-md-10">
       @if (Session::has('flash_notification.message'))
         <div class="alert alert-{{ Session::get('flash_notification.level') }}">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

             {{ Session::get('flash_notification.message') }}
         </div>
      @endif
   </div>
</div>

   <div class="row">
      <div class="col-sm-3 col-md-3 sidebar" style="padding-top:130px; ">
         
         @include('frontend.partials.dashboardSidebar')
         
      </div>
      <h2 style="text-align: center;">
         Dashboard
         </h2>
 
      <div class="col-sm-9 col-md-9">
        
         
         <h4 style="text-align: center;">
            Institution- {{ Auth::user()->user()->getMembership->getName() }}
         </h4>
        
         @if ($verified==1)

            <div class="row">
               <div class="col-md-4">
                  <div class="panel">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                                 <span class="glyphicon glyphicon-globe fa-5x"></span>
                              </div>
                              <div class="col-xs-9 text-right">
                                    <div class="huge">2</div>
                                 <div>New Notification!</div>
                              </div>
                           </div>
                     </div>
                     <a href="#">
                     
                        <div class="panel-footer">
                        <div class="clearfix">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                  
                        </div>
                     </div>
                     </a>
                  </div>
               </div>            
               
               <div class="col-md-4">
                  <div class="panel panel-green">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                                 <span class="glyphicon glyphicon-exclamation-sign fa-5x"></span>
                              </div>
                              <div class="col-xs-9 text-right">
                                    <div class="huge">2</div>
                                 <div>Latest News!</div>
                              </div>
                           </div>
                     </div>
                     <a href="#">
                     
                        <div class="panel-footer">
                         <div class="clearfix">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span>
                          </div>
                        </div>
                     </a>
                  </div>
               </div>

               <div class="col-md-4">
                  <div class="panel panel-yellow">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                                 <span class="glyphicon glyphicon-user fa-5x"></span>
                              </div>
                              <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                 <div>View Profile</div>
                              </div>
                           </div>
                     </div>
                     <a href={{ route('profile') }}>
                       
                        <div class="panel-footer">
                         <div class="clearfix">
                           <span class="pull-left">View Details</span>
                           <span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
              
            </div>  {{-- end of panel row --}}
         

            <div class="row">
               <div class="col-md-12">
                  <h2 class="page-header" style="margin-bottom: 20px; ">Latest News</h2>
                        <div id="profile">
                           <ul class="list-unstyled">
                              <li>
                                 <span class="title-text">
                                    CSI-India launches new Website
                                 </span>
                              </li> 
                           </ul>
                        </div>

               </div>
            </div>
         @else

            <div class="row">
               <div class="col-md-12">
                  <h2 class="page-header" style="margin-bottom: 20px; ">Not Verified Yet</h2>
                        <div id="profile">
                           <ul class="list-unstyled">
                              <li>
                                 <span class="title-text">
                                    Your Services are not verified. Please wait until to use your services.
                                 </span>
                              </li> 
                           </ul>
                        </div>

               </div>
            </div>

         @endif
</span>

      </div>
   </div>

</div>

{{-- end --}}
<br/>
<br/>
<br/>
<br/>
<br/>
</section>
@endsection


@section('footer-scripts')
<script src={{ asset("js/validateit.js") }}></script>
<script src={{ asset('js/function7.js') }}></script>
@endsection