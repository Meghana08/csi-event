<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateNonCsiSubscriberRequest;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventStatus;
use App\EventGrant;
use App\EventGrantType;
use App\EventGrantStatus;
use App\TargetAudience;
use App\TargetAudienceWithFee;
use DB;
use Auth;
use Input;
use App\EventType;
use App\EventTypeDetails;
use App\EventRequestAdminDecision;
use App\EventPosts;
use App\EventCancelationRequests;
use App\CsiOrganisationSubscribers;
use App\CsiIndividualSubscribers;
use App\NonCsiOrganisationSubscribers;
use App\NonCsiIndividualSubscribers;
use App\Member;
use App\OrganisationSubscriberNominees;
use App\CsiSubscriberNominee;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $err=null;
        $grantType = EventGrantType::all();
        $targetAudience = TargetAudience::all();
        return view('frontend.events.create-event',compact('grantType','targetAudience','err'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function validateCreation(Request $request) {
        $err = null;
        $po = Input::get('payment_option');
        $pd = Input::get('payment_date_deadline');
        if($po && is_null($pd)) {
            $err= "Enter Payment Deadline Date";
        } 
        else if(date(Input::get('event_start_date')) > date(Input::get('event_end_date'))) {
          $err="Start Event date should be earlier than End date";
        }
        else if(strtotime(Input::get('registration_start_date')) > strtotime(Input::get('registration_end_date'))) {
          $err="Registration Start date should be earlier than End date";
        }
        else if(date(Input::get('event_start_date')) < date(Input::get('registration_start_date'))) {
          $err="Start Event date should be earlier than End date";
        }
        else if(strtotime(Input::get('registration_end_date')) > strtotime(Input::get('event_end_date'))) {
          $err="Registration Start date should be earlier than End date";
        }
        else if(!is_null($request->file('event_banner'))) {
           $bnrExt = $request->file('event_banner')->getClientOriginalExtension();
           if(!strcmp($bnrExt,"png") || !strcmp($bnrExt,"jpg") || !strcmp($bnrExt,"gig") || !strcmp($bnrExt,"jpeg")) 
           {
            $err="Banner should be an image. Extensions allowed : .PNG, .JPG, .JPEG. .GIF";
          }
        }
        else if(!is_null($request->file('event_logo'))) {
           $bnrExt = $request->file('event_logo')->getClientOriginalExtension();
           if(!strcmp($bnrExt,"png") || !strcmp($bnrExt,"jpg") || !strcmp($bnrExt,"gig") || !strcmp($bnrExt,"jpeg") || !strcmp($bnrExt,"bmp")) 
           {
            $err="Banner should be an image. Extensions allowed : .PNG, .JPG, .JPEG. .GIF .BMP";
          }
        }
        else if(!is_null($request->file('event_pdf'))) {
           $bnrExt = $request->file('event_pdf')->getClientOriginalExtension();
           if(!strcmp($bnrExt,"pdf")) 
           {
            $err="Only PDFs allowed for Description File.";
          }
        }
        else {
          $err=null;
        }
        return $err;
    }

    public function store(CreateEventRequest $request)
    {
        $grantType = EventGrantType::all();
        $targetAudience = TargetAudience::all();
        $err=null;        
        if(!is_null($err))
          return view('frontend.events.create-event',compact('grantType','targetAudience','err'));        
        $event=new Event;
        $event->event_name = Input::get('event_name');
        $event->event_type_id = Input::get('event_type_id');
        $event->member_id= Auth::user()->user()->id;
        $event->event_theme = Input::get('event_theme');
        $event->event_start_date = date('Y-m-d', strtotime(Input::get('event_start_date')));
        $event->event_end_date = date('Y-m-d', strtotime(Input::get('event_end_date')));
        $event->event_start_time = Input::get('event_start_time');
        $event->event_end_time = Input::get('event_end_time');
        $event->event_venue = Input::get('event_venue');
        $event->event_description = Input::get('event_description');
        $event->payment_option = Input::get('payment_option');
        $event->payment_date_deadline = date('Y-m-d', strtotime(Input::get('payment_deadline_date')));
        $event->payment_time_deadline = Input::get('payment_deadline_time');
        $event->save();
         $id = $event->id;
        if(!is_null($request->file('event_banner'))) {
            $bannerName = $id.'.'.$request->file('event_banner')->getClientOriginalExtension();
            $request->file('event_banner')->move(base_path().'/public/event/event_banners/',$bannerName);
            Event::where('id',$id)->update(['event_banner'=>$bannerName]);
        }
        if(!is_null($request->file('event_pdf'))) {
            $fileName = $id.'.'.$request->file('event_pdf')->getClientOriginalExtension();
            $request->file('event_pdf')->move(base_path().'/public/event/event_pdfs/',$fileName);
            Event::where('id',$id)->update(['event_pdf'=>$fileName]);
        }
        if(!is_null($request->file('event_logo'))) {
            $logo = $id.'.'.$request->file('event_logo')->getClientOriginalExtension();
            $request->file('event_logo')->move(base_path().'/public/event/event_logos/',$logo);
            Event::where('id',$id)->update(['event_logo'=>$logo]);
        }
        $event_name = $event->event_name;
        $event_id = $id;
        foreach($targetAudience as $type) {
            if (Input::get('targetType_'.$type->id) == $type->id) {
              $fee=new TargetAudienceWithFee;
              $fee->event_id=$event_id;
              $fee->target_id=$type->id;
              $po = Input::get('payment_option');
              if($po==1) {
                  $fee->fee=Input::get('fee_'.$type->id);
              }
              else
                  $fee->fee=0;
              $fee->save();
            } 
        }  
        $event_type_details= new EventTypeDetails;
        $event_type_details->event_id = $event->id;
        $event_type_details->event_type_id = Input::get('event_type_id');
        $event_type_details->max_seats = Input::get('max_seats');
        $event_type_details->registration_start_date = date('Y-m-d', strtotime(Input::get('registration_start_date')));
        $event_type_details->registration_end_date = date('Y-m-d', strtotime(Input::get('registration_end_date')));
        $event_type_details->registration_start_time = Input::get('registration_start_time');
        $event_type_details->registration_end_time = Input::get('registration_end_time');
        $event_type_details->certification = Input::get('certification_option');
        $event_type_details->meals = Input::get('meals_option');
        $event_type_details->save();
        foreach ($grantType as $type) {
            if (Input::get($type->grant_type_name.'_description')) {
                $grant = new EventGrant;
                $grant->grant_type_id = $type->id;
                $grant->grant_description = Input::get($type->grant_type_name.'_description');
                $grant->grant_status_id = EventGrantStatus::where('grant_status_name', 'Waiting')->value('id');
                $grant->event_id=$event_id;
                $grant->save();
            }
        }
        return view('frontend.events.confirm-event',compact('event_id', 'event_name'));
    }

    public function viewAllEvents() {
        $sysDate = date('Y-m-d');
        $sysTime = date('H:i:s');        
        $memId = null;
        $memType = null;
        $subscribedEvents = null;
        if(Auth::user()->check()){
          $memId = Auth::user()->user()->id;
          $memType = Member::find($memId)->membership->type;
          if(!strcmp($memType, 'institutional')) {
              $subscribedEvents = CsiOrganisationSubscribers::where('member_id',$memId)->get();
          }
          else {
              $subscribedEvents = CsiIndividualSubscribers::where('member_id',$memId)->get();
          }
        }
        $events = Event::where('event_status', EventStatus::where('event_status_name','Accepted')->value('id'));
        $eventStatus = EventStatus::all();
        $latestEvents = Event::where('event_status', EventStatus::where('event_status_name','Accepted')->value('id'))
                  ->orderBy('event_start_date', 'desc')
                  ->take(3)
                  ->get();
        return view('frontend.events.memberViewAll',compact('events','eventStatus','latestEvents','memId','memType','subscribedEvents','sysDate','sysTime'));
    }

     public function storeCsiIndiSubscriber($id)
     {
            $memId=Auth::user()->user()->id;
            $subscriber=new CsiIndividualSubscribers;
            $subscriber->event_id = $id;
            $subscriber->member_id = $memId;
            $subscriber->save();
            return view('frontend.events.confirm-subscribe',compact('id'));
     }

    public function csiOrganisationSubscriberLoad($id) {
        $isCSI = true;
        return view('frontend.events.createOrganisationSubscriber',compact('id', 'isCSI'));
    }

    public function organisationSubscriberLoad($id) {
        $isCSI = false;
        return view('frontend.events.createOrganisationSubscriber',compact('id', 'isCSI'));
    }

     public function storeOrganisationSubscriber(Request $request, $id)
    {
        $event_id = $id;
      
        $no_of_candidates = Input::get('no_of_candidates');
        $subscriber = new NonCsiOrganisationSubscribers;
        $subscriber->event_id = $event_id;
        $subscriber->name = Input::get('name');
        $subscriber->contact_person = Input::get('contact_person');
        $subscriber->contact_number = Input::get('contact_number');
        $subscriber->email = Input::get('email');
        $subscriber->no_of_candidates=$no_of_candidates;
        $subscriber->save();
        for($i=0; $i<$no_of_candidates; $i++) {
          $organisationSubscriber = new OrganisationSubscriberNominees;
          $organisationSubscriber->subscriber_id = $subscriber->id;
          $organisationSubscriber->nominee_name = Input::get('name'.$i);
          $organisationSubscriber->role = Input::get('role'.$i);
          $organisationSubscriber->email = Input::get('mail'.$i);
          $organisationSubscriber->contact_number = Input::get('mobile'.$i);
          $organisationSubscriber->dob = date('Y-m-d', strtotime(Input::get('dob'.$i)));
          $organisationSubscriber->save();
        }
        return view('frontend.events.confirm-subscribe',compact('id'));            
    }

     public function storeCsiOrganisationSubscriber(Request $request, $id)
    {
        $event_id = $id;
        $no_of_candidates = Input::get('no_of_candidates');
        $subscriber = new CsiOrganisationSubscribers;
        $subscriber->event_id = $event_id;
        $subscriber->member_id = Auth::user()->user()->id;
        $subscriber->no_of_candidates=$no_of_candidates;
        $subscriber->save();
        for($i=0; $i<$no_of_candidates; $i++) {
          $organisationSubscriber = new CsiSubscriberNominee;
          $organisationSubscriber->subscriber_id = $subscriber->id;
          $organisationSubscriber->nominee_name = Input::get('name'.$i);
          $organisationSubscriber->role = Input::get('role'.$i);
          $organisationSubscriber->email = Input::get('mail'.$i);
          $organisationSubscriber->contact_number = Input::get('mobile'.$i);
          $organisationSubscriber->dob = date('Y-m-d', strtotime(Input::get('dob'.$i)));
          $organisationSubscriber->save();
        }          
        return view('frontend.events.confirm-subscribe',compact('id'));            
    }

    public function storeNonCsiIndiSubscriber(CreateNonCsiSubscriberRequest $request, $id)
    {
        $event=new NonCsiIndividualSubscribers;
        $event->name = Input::get('non_csi_subscriber_name');
        $event->event_id=$id;
        $event->dob = Input::get('dob');
        $event->working_status = Input::get('working_status');
        $event->contact_number = Input::get('contact_number');
        $event->email = Input::get('email_id');
        $sname=Input::get('non_csi_subscriber_name');
             $event->save();   
             return view('frontend.events.confirm-subscribe',compact('id'));
    }

    public function showNomineeDetailsCSI($id) {
        $nominees = CsiSubscriberNominee::where('subscriber_id',$id)->get();
        return view('frontend.events.showNomineeDetails',compact('nominees'));
    }

    public function showNomineeDetailsORG($id) {
        $nominees = OrganisationSubscriberNominees::where('subscriber_id',$id)->get();
        return view('frontend.events.showNomineeDetails',compact('nominees'));
    }

    public function showMyEvent($id) {  
          if($id!=null || intval($id)>0){
              $isCreator = 0;
              $userId = Auth::user()->user()->id;
              $creatorId = Event::where('id',$id)->value('member_id');
              if($userId == $creatorId) {
                $isCreator = 1;
              }
              $user = Member::find($creatorId);
              $event = Event::find($id);
              $grants = EventGrant::where('event_id',$id);
              $cancelRequests = EventCancelationRequests::where('event_id',$id)->first();
              $eventPosts = EventPosts::where('event_id',$id);
              return view('frontend.events.event', compact('user', 'event', 'grants','cancelRequests','eventPosts','isCreator'));
          }
    }

   public function cancelEventRequest(Request $request, $id) {
      if($id!=null || intval($id)>0){
        $this->validate($request, [
                        'reason' => 'required|max:255',
                    ]);
        Event::where('id',$id)->update(['event_status' => EventStatus::where('event_status_name','Requested For Cancellation')->value('id')]);
        $delete= new EventCancelationRequests;        
        $delete->event_id=$request->id;
        $delete->reason=$request->reason;
        $delete->save();
        return redirect()->back();
      }
   }

   public function editEventFormLoad($id)
    {
      if($id!=null || intval($id)>0){
        $event=Event::find($id);
        $eventTypeDetail=EventTypeDetails::where('event_id',$id)->first();
        $eventGrant=EventGrant::where('event_id',$id)->get();
        $targetAudienceWithFee = TargetAudienceWithFee::where('event_id',$id)->get();
        $eventType=EventType::all();
        $grantType = EventGrantType::all();
        $targetAudience = TargetAudience::all();
        return view('frontend.events.editEvent',compact('event','eventTypeDetail','eventGrant','eventType','targetAudienceWithFee','grantType','targetAudience'));
      }
   }

   public function editEvent(CreateEventRequest $request, $id) {
      if($id!=null || intval($id)>0){  
        Event::where('id',$id)->update([
                'event_name'=>Input::get('event_name'),
                'event_type_id'=>Input::get('event_type_id'),
                'event_start_date' => date('Y-m-d', strtotime(Input::get('event_start_date'))),
                'event_end_date' => date('Y-m-d', strtotime(Input::get('event_end_date'))),
                'event_start_time' => Input::get('event_start_time'),
                'event_end_time' => Input::get('event_end_time'),
                'event_venue' => Input::get('event_venue'),
                'event_description' => Input::get('event_description'),
                'payment_option' => Input::get('payment_option'),
                'payment_date_deadline' => date('Y-m-d', strtotime(Input::get('payment_deadline_date'))),
                'payment_time_deadline' => Input::get('payment_deadline_time')
              ]);
        if(!is_null($request->file('event_banner'))) {
            $bannerName = $id.'.'.$request->file('event_banner')->getClientOriginalExtension();
            $request->file('event_banner')->move(base_path().'/public/event/event_banners/',$bannerName);
            Event::where('id',$id)->update(['event_banner'=>$bannerName]);
         }
        if(!is_null($request->file('event_pdf'))) {
            $fileName = $id.'.'.$request->file('event_pdf')->getClientOriginalExtension();
            $request->file('event_pdf')->move(base_path().'/public/event/event_pdfs/',$fileName);
            Event::where('id',$id)->update(['event_pdf'=>$fileName]);
        }
        if(!is_null($request->file('event_logo'))) {
            $logo = $id.'.'.$request->file('event_logo')->getClientOriginalExtension();
            $request->file('event_logo')->move(base_path().'/public/event/event_logos/',$logo);
            Event::where('id',$id)->update(['event_logo'=>$logo]);
        }
        $event = Event::find($id);
        $targetAudience = TargetAudience::all();
        foreach ($targetAudience as $type) {
          $audience = TargetAudienceWithFee::where('event_id',$id)->where('target_id',$type->id)->count();
          echo $audience.'-';
          if($audience) {
            TargetAudienceWithFee::where('event_id',$id)->where('target_id',$type->id)->update([
                'fee' => Input::get('fee_'.$type->id)
              ]);
          }
          else {
            if (Input::get('targetType_'.$type->id) == $type->id) {
              $fee=new TargetAudienceWithFee;
              $fee->event_id=$event->id;
              $fee->target_id=$type->id;
              if($event->payment_option===1)
                  $fee->fee=Input::get('fee_'.$type->id);
              else
                  $fee->fee=0;
              $fee->save();
            }
          }
        }
        EventTypeDetails::where('event_id',$id)->update([
              'event_type_id' => Input::get('event_type_id'),
              'max_seats' => Input::get('max_seats'),
              'registration_start_date' => date('Y-m-d', strtotime(Input::get('registration_start_date'))),
              'registration_end_date' => date('Y-m-d', strtotime(Input::get('registration_end_date'))),
              'registration_start_time' => Input::get('registration_start_time'),
              'registration_end_time' => Input::get('registration_end_time'),
              'certification' => Input::get('certification_option'),
              'meals' => Input::get('meals_option')
          ]);
        $grantType = EventGrantType::all();
        foreach ($grantType as $type) {
          $grants = EventGrant::where('event_id',$id)->where('grant_type_id',$type->id)->count();
          if($grants) {
            EventGrant::where('event_id',$id)->where('grant_type_id',$type->id)->update([
                'grant_description' => Input::get($type->grant_type_name.'_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id')
              ]);
          }
          else {
            if (Input::get($type->grant_type_name.'_description')) {
                $grant = new EventGrant;
                $grant->grant_type_id = $type->id;
                $grant->grant_description = Input::get($type->grant_type_name.'_description');
                $grant->grant_status_id = EventGrantStatus::where('grant_status_name', 'Waiting')->value('id');
                $grant->event_id=$id;
                $grant->save();
            }
          }
        }
        return redirect()->back();
      }
   }

   public function showSuscribers($id) {
      if($id!=null || intval($id)>0){
        $search_text="";
        $fromDate="";
        $toDate="";
        $csiIndi=0;
        $nonCsiIndi=0;
        $csiOrg=0;
        $nonCsiOrg=0;
        $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id',$id)->paginate();
        $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id',$id)->paginate();
        $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id',$id)->paginate();
        $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id',$id)->paginate();
        return view('frontend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
      }
   }

   public function subscribersFilter(Request $request, $id){
     if($id!=null || intval($id)>0){
        $search_text=$request->search_text;
        $fromDate=$request->request_from_date;
        $toDate=$request->request_to_date;
        $csiIndi = $request->csiIndi;   
        $nonCsiIndi = $request->nonCsiIndi;
        $csiOrg = $request->csiOrg;
        $nonCsiOrg = $request->nonCsiOrg; 
          $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id','<','0')->paginate();
          $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id','<','0')->paginate();
          $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id','<','0')->paginate();
          $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id','<','0')->paginate(); 
        if(!is_null($csiIndi) || !is_null($nonCsiIndi) || !is_null($csiOrg) || !is_null($nonCsiOrg)) {
            if($csiIndi) {
              if(!is_null($search_text))
                  $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id',$id)->paginate();
              else
                  $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($nonCsiIndi) {
              if(!is_null($search_text))
                  $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id',$id)->paginate();
              else
                  $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($csiOrg) {
              if(!is_null($search_text))
                $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id',$id)->paginate();
              else
                $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($nonCsiOrg) {
              if(!is_null($search_text))
                $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id',$id)->paginate();
              else
                $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id',$id)->where('id',$search_text)->paginate();
            }
        }
        else {
            $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id',$id)->paginate();
            $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id',$id)->paginate();
            $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id',$id)->paginate();
            $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id',$id)->paginate(); 
        }
      return view('frontend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
   }
  }

   public function addPost(Request $request, $id) {
      if($id!=null || intval($id)>0){
            $post = new EventPosts;
            $post->event_id = $id;
            $post->post_text = Input::get('post_text');
            if(!is_null($request->file('post_image'))) {
              $imageId = $id.'_'.EventPosts::orderBy('id','desc')->value('id')+1;
              $postImage = $imageId.'.'.$request->file('post_image')->getClientOriginalExtension();
              $request->file('post_image')->move(base_path().'/public/event/event_post_images/',$postImage);
              $post->post_image = $postImage;
            }
            $post->save();
            return redirect()->back();
      }
    }

    public function editGrant($id) {
      if($id!=null || intval($id)>0){
        EventGrant::where('id',$id)->update([
            'grant_description' => Input::get('new_grant_description'),
            'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id')
          ]);
        $event_id = EventGrant::where('id',$id)->value('event_id');
        return redirect()->back();
      }
    }

    public function removeGrant($id) {
      if($id!=null || intval($id)>0){
        EventGrant::where('id',$id)->update([ 'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Closed')->value('id')
          ]);
        $event_id = EventGrant::where('id',$id)->value('event_id');
        return redirect()->back();
      }
    }

    public function listMyEvents(){        
        $statuses = EventStatus::all();
        $checkbox_array=array();
        $search=0;
        $search_text="";
        $fromDate="";
        $toDate="";
        $rows = (Input::exists('rows'))?abs(Input::get('rows')): 15;
        $page = (Input::exists('page'))? abs(Input::get('page')): 1;
        $current_id= Auth::user()->user()->id;
        $events = Event::where('member_id',$current_id)->paginate($rows);
        return view('frontend.events.my-event-list',compact('events','page','rows', 'search_text','statuses','checkbox_array','search','fromDate','toDate','current_id'));
    }

    public function filterMyEvents(Request $request)    
    {
        $current_id= Auth::user()->user()->id;
        $rows = (Input::exists('rows'))?abs(Input::get('rows')): 15;
        $search=$request->search;
        $search_text=$request->search_text;
        $status=$request->status; 
        $fromDate=$request->request_from_date;
        $toDate=$request->request_to_date;        
        $statuses= EventStatus::all();
        $page = (Input::exists('page'))? abs(Input::get('page')): 1;
        if(count($status)){
          $checkbox_array=$request->status;
        }else{
          $checkbox_array=array();
        } 
        if($search)
      {
        switch($search)
        {
          case 1: $events= Event::where('member_id',$current_id)->where('event_id',$search_text)->latest()->paginate($rows);
                  break;
          case 2: if(count($status))
                  {
                    $events= Event::where('member_id',$current_id)->where('event_name','like','%'.$search_text.'%')->whereIn('event_status',$status)->latest()->paginate($rows);                    
                  }
                  else
                  {
                    $events= Event::where('member_id',$current_id)->where('event_name','like','%'.$search_text.'%')->latest()->paginate($rows);
                  }
                  break;
            case 3: if(count($status))
                  {
                    $type=EventType::select('id')->where('event_type_name','like','%'.$search_text.'%')->get();
                    $events= Event::where('member_id',$current_id)->whereIn('event_type_id',$type)->whereIn('event_status',$status)->latest()->paginate($rows);                    
                  }
                  else
                  {
                    $type=EventType::select('id')->where('event_type_name','like','%'.$search_text.'%')->get();
                    $events= Event::where('member_id',$current_id)->whereIn('event_type_id',$type)->latest()->paginate($rows); 
                  }
                  break;
            case 4:$events= Event::where('member_id',$current_id)->where('id',$search_text)->latest()->paginate($rows);
                  break;
        }       
      }
      else
      {
        if(count($status))
        {
          $events= Event::where('member_id',$current_id)->whereIn('event_status',$status)->latest()->paginate($rows);                    
        }
        else
        {
          $events= Event::where('member_id',$current_id)->paginate($rows);
        }
      }
        $from_date_records = array();
        $to_date_records = array();
        foreach ($events as $key => $event) {
            if($fromDate){
              if($event->created_at <= $fromDate ){ 
                array_push($from_date_records, $key);
              }
            }
            if($toDate){
              if($event->created_at >= $toDate ){ 
                array_push($to_date_records, $key);
              }
            }       
        if(!empty($fromDate)){
          $events->forget($from_date_records);
        } 
        if(!empty($toDate))
          $events->forget($to_date_records);
        }   
      return view('frontend.events.my-event-list',compact( 'events' ,'page','rows', 'search_text','statuses','checkbox_array','search','fromDate','toDate','current_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}