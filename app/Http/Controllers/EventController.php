<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\EditEventRequest;
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
use App\EventTypeDetail;
use App\EventRequestAdminDecision;
use App\EventPost;
use App\EventCancellationRequest;
use App\CsiOrganisationSubscriber;
use App\CsiIndividualSubscriber;
use App\NonCsiOrganisationSubscriber;
use App\NonCsiIndividualSubscriber;
use App\Member;
use App\OrganisationSubscriberNominee;
use App\CsiSubscriberNominee;
use Carbon\Carbon;

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

        $err=null;
        $err = array();
        $po = Input::get('payment_option');
        $pd = Input::get('payment_date_deadline');
        if($po && is_null($pd)) {
            array_push($err, "Enter Payment Deadline Date");
        } 
        if(date(Input::get('payment_date_deadline')) > date(Input::get('event_end_date'))) {
          array_push($err, "Payment Deadline should be earlier than Event End Date");
        }
        if(date(Input::get('event_start_date')) > date(Input::get('event_end_date'))) {
          array_push($err, "Start Event date should be earlier than End date");
        }
        if(date(Input::get('registration_start_date')) > date(Input::get('registration_end_date'))) {
          array_push($err, "Registration Start date should be earlier than End date");
        }
        if(date(Input::get('event_start_date')) > date(Input::get('registration_start_date'))) {
          array_push($err, "Event start date should be earlier than Registration start date");
        }
        if(date(Input::get('registration_end_date')) > date(Input::get('event_end_date'))) {
          array_push($err, "Event end date should be later than Registration end date");
        }
        if(date(Input::get('event_start_date')) == date(Input::get('registration_start_date')) && date(Input::get('event_start_time')) > date(Input::get('registration_start_time'))) {
          array_push($err, "Event start Time should be earlier than Registration start Time");
        }
        if(date(Input::get('registration_end_date')) == date(Input::get('event_end_date')) && date(Input::get('registration_end_time')) > date(Input::get('event_end_time'))) {
          array_push($err, "Event end time should be later than Registration end time");
        }
        if((date(Input::get('registration_end_date')) == date(Input::get('registration_start_date'))) && (date(Input::get('registration_start_time')) > date(Input::get('registration_end_time')))) {
          array_push($err, "Registration end time should be later than Registration Start time");
        }
        if((date(Input::get('event_end_date')) == date(Input::get('event_start_date'))) && (date(Input::get('event_start_time')) > date(Input::get('event_end_time')))) {
          array_push($err, "event end time should be later than event Start time");
        }
        
        return $err;
    }

    public function store(CreateEventRequest $request)
    {
        $errors = $this->validateCreation($request);
      
        if($errors) {
          return redirect()->back()->withErrors($errors)->withInput();
        }

        $e = DB::transaction(function($connection) use($request) {
            $event=new Event;
            $event->event_name = Input::get('event_name');
            $event->event_type_id = Input::get('event_type_id');
            $event->member_id= Auth::user()->user()->id;
            $event->event_theme = Input::get('event_theme');
            $event->event_start_date = date(Input::get('event_start_date'));
            $event->event_end_date = date(Input::get('event_end_date'));
            $event->event_start_time = Input::get('event_start_time');
            $event->event_end_time = Input::get('event_end_time');
            $event->event_venue = Input::get('event_venue');
            $event->event_description = Input::get('event_description');
            $event->payment_option = Input::get('payment_option');
            $event->payment_date_deadline = date(Input::get('payment_date_deadline'));
            $event->payment_time_deadline = Input::get('payment_time_deadline');
            $event->save();

            $bannerName = $event->id.'.'.$request->file('event_banner')->getClientOriginalExtension();
            $request->file('event_banner')->move(storage_path('uploads/events/banners'),$bannerName);
            $event->event_banner=$bannerName;

            $fileName = $event->id.'.'.$request->file('event_pdf')->getClientOriginalExtension();
            $request->file('event_pdf')->move(storage_path('uploads/events/pdfs'),$fileName);
            $event->event_pdf=$fileName;

            $logo = $event->id.'.'.$request->file('event_logo')->getClientOriginalExtension();
            $request->file('event_logo')->move(storage_path('uploads/events/logos'),$logo);
            $event->event_logo=$logo;

            $event_name = $event->event_name;
            $event->save();
            
            if (Input::exists('targetType_1')) {
                $type_id = TargetAudience::where('target_name','CSI Professional')->first()->id;
                TargetAudienceWithFee::create([
                    'event_id' => $event->id,
                    'target_id' => $type_id,
                    'fee' => (Input::exists('payment_option') && Input::get('payment_option')==1)?Input::get('fee_1'):0,
                ]);
            }  
            if (Input::exists('targetType_2')) {
                $type_id = TargetAudience::where('target_name','CSI Student')->first()->id;
                TargetAudienceWithFee::create([
                    'event_id' => $event->id,
                    'target_id' => $type_id,
                    'fee' => (Input::exists('payment_option') && Input::get('payment_option')==1)?Input::get('fee_2'):0,
                ]);
            }  
            if (Input::exists('targetType_3')) {
                $type_id = TargetAudience::where('target_name','Non CSI Member')->first()->id;
                TargetAudienceWithFee::create([
                    'event_id' => $event->id,
                    'target_id' => $type_id,
                    'fee' => (Input::exists('payment_option') && Input::get('payment_option')==1)?Input::get('fee_3'):0,
                ]);
            }  

            EventTypeDetail::create([
              'event_id' => $event->id,
              'event_type_id' => Input::get('event_type_id'),
              'max_seats' => Input::get('max_seats'),
              'registration_start_date' => date(Input::get('registration_start_date')),
              'registration_end_date' => date(Input::get('registration_end_date')),
              'registration_start_time' => Input::get('registration_start_time'),
              'registration_end_time' => Input::get('registration_end_time'),
              'certification' => Input::get('certification_option'),
              'meals' => Input::get('meals_option'),
            ]);
            
            if (Input::has('technical_description')) {
                EventGrant::create([
                  'grant_type_id'  =>  EventGrantType::where('grant_type_name', 'technical')->first()->id,
                  'grant_description'  =>  Input::get('technical_description'),
                  'grant_status_id'  =>  EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                  'event_id' => $event->id,
                ]);
            }
            if (Input::has('financial_description')) {
                EventGrant::create([
                  'grant_type_id'  =>  EventGrantType::where('grant_type_name', 'financial')->first()->id,
                  'grant_description'  =>  Input::get('financial_description'),
                  'grant_status_id'  =>  EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                  'event_id' => $event->id,
                ]);
            }
            if (Input::has('infrastructure_description')) {
                EventGrant::create([
                  'grant_type_id'  =>  EventGrantType::where('grant_type_name', 'infrastructure')->first()->id,
                  'grant_description'  =>  Input::get('infrastructure_description'),
                  'grant_status_id'  =>  EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                  'event_id' => $event->id,
                ]);
            }
            return $event;
        });
        

        return view('frontend.events.confirm-event',compact('e'));
    }

    public function viewAllEvents() {
        date_default_timezone_set('Asia/Kolkata');
        $sysDate = date('Y-m-d');
        $sysTime = date('H:i:s');
        $memId = null;
        $memType = null;
        $subscribedEvents = null;
        if(Auth::user()->check()){
          $memId = Auth::user()->user()->id;
          $memType = Member::find($memId)->membership->type;
          if(!strcmp($memType, 'institutional')) {
              $subscribedEvents = CsiOrganisationSubscriber::where('member_id',$memId)->get();
          }
          else {
              $subscribedEvents = CsiIndividualSubscriber::where('member_id',$memId)->get();
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
            $subscriber=new CsiIndividualSubscriber;
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
        $subscriber = new NonCsiOrganisationSubscriber;
        $subscriber->event_id = $event_id;
        $subscriber->name = Input::get('name');
        $subscriber->contact_person = Input::get('contact_person');
        $subscriber->contact_number = Input::get('contact_number');
        $subscriber->email = Input::get('email');
        $subscriber->no_of_candidates=$no_of_candidates;
        $subscriber->save();
        for($i=0; $i<$no_of_candidates; $i++) {
          $organisationSubscriber = new OrganisationSubscriberNominee;
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
        $subscriber = new CsiOrganisationSubscriber;
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
        $event=new NonCsiIndividualSubscriber;
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
        $nominees = OrganisationSubscriberNominee::where('subscriber_id',$id)->get();
        return view('frontend.events.showNomineeDetails',compact('nominees'));
    }

    public function showMyEvent($id) {  
          if($id!=null || intval($id)>0){
              $isCreator = 0;
              $userId = Auth::user()->user()->id;
              $creatorId = Event::find($id)->value('member_id');
              if($userId == $creatorId) {
                $isCreator = 1;
              }
              $user = Member::find($creatorId);
              $event = Event::find($id);
              $grants = EventGrant::where('event_id',$id);
              $targetAudience = TargetAudienceWithFee::where('event_id',$id)->get();
              $cancelRequests = EventCancellationRequest::where('event_id',$id)->first();
              $eventPosts = EventPost::where('event_id',$id);
              return view('frontend.events.event', compact('user', 'event', 'grants','cancelRequests','eventPosts','isCreator','targetAudience'));
          }
    }

   public function cancelEventRequest(Request $request, $id) {
      if($id!=null || intval($id)>0){
        $this->validate($request, [
                        'reason' => 'required|max:255',
                    ]);
        Event::find($id)->update(['event_status' => EventStatus::where('event_status_name','Requested For Cancellation')->value('id')]);
        $delete= new EventCancellationRequest;        
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
        $eventTypeDetail=EventTypeDetail::where('event_id',$id)->first();
        $eventGrant=EventGrant::where('event_id',$id)->get();
        $targetAudienceWithFee = TargetAudienceWithFee::where('event_id',$id)->get();
        $eventType=EventType::all();
        $grantType = EventGrantType::all();
        $targetAudience = TargetAudience::all();
        return view('frontend.events.editEvent',compact('event','eventTypeDetail','eventGrant','eventType','targetAudienceWithFee','grantType','targetAudience'));
      }
   }

   public function editEvent(EditEventRequest $request, $id) {
      if($id!=null || intval($id)>0){

        $errors = $this->validateCreation($request);
      
        if($errors) {
          return redirect()->back()->withErrors($errors);
        }

        DB::transaction(function($connection) use($request, $id){

          $event = Event::find($id);
          $event->event_name = Input::get('event_name');
          $event->event_type_id = Input::get('event_type_id');
          $event->event_start_date = date(Input::get('event_start_date'));
          $event->event_end_date = date(Input::get('event_end_date'));
          $event->event_start_time = Input::get('event_start_time');
          $event->event_end_time = Input::get('event_end_time');
          $event->event_venue = Input::get('event_venue');
          $event->event_description = Input::get('event_description');
          $event->payment_date_deadline = date(Input::get('payment_date_deadline'));
          $event->payment_time_deadline = Input::get('payment_time_deadline');
          

          if(!is_null($request->file('event_banner'))) {
            $bannerName = $id.'.'.$request->file('event_banner')->getClientOriginalExtension();
            $request->file('event_banner')->move(storage_path('uploads/events/banners'),$bannerName);
            $event->event_banner = $bannerName;
          }
          
      
          if(!is_null($request->file('event_pdf'))) {
            $fileName = $id.'.'.$request->file('event_pdf')->getClientOriginalExtension();
            $request->file('event_pdf')->move(storage_path('uploads/events/pdfs'),$fileName);
            $event->event_pdf = $fileName;
          }
      
          if(!is_null($request->file('event_logo'))) {
            $logo = $id.'.'.$request->file('event_logo')->getClientOriginalExtension();
            $request->file('event_logo')->move(storage_path('uploads/events/logos'),$logo);
            $event->event_logo = $logo;
          }
          
          $event->save();
          
          $target_csi_professional = TargetAudience::where('target_name','CSI Professional')->first();
          if(TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_csi_professional->id)->exists()) {
            TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_csi_professional->id)->update([
                'fee' => Input::get('fee_1')
              ]);
          } else if( Input::exists('targetType_1') ) {
              TargetAudienceWithFee::create([
                  'event_id' => $event->id,
                  'target_id' => $type->id,
                  'fee' => ($event->payment_option===1)?Input::get('fee_'.$type->id):0,
              ]);
          }

          $target_csi_student = TargetAudience::where('target_name','CSI Student')->first();
          if(TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_csi_student->id)->exists()) {
            TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_csi_student->id)->update([
                'fee' => Input::get('fee_1')
              ]);
          } else if( Input::exists('targetType_2') ) {
              TargetAudienceWithFee::create([
                  'event_id' => $event->id,
                  'target_id' => $target_csi_student->id,
                  'fee' => ($event->payment_option===1)?Input::get('fee_2'):0,
              ]);
          }

          $target_non_csi = TargetAudience::where('target_name','Non CSI Member')->first();
          if(TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_non_csi->id)->exists()) {
            TargetAudienceWithFee::where('event_id',$id)->where('target_id',$target_non_csi->id)->update([
                'fee' => Input::get('fee_3')
              ]);
          } else if( Input::exists('targetType_3') ) {
              TargetAudienceWithFee::create([
                  'event_id' => $event->id,
                  'target_id' => $target_non_csi->id,
                  'fee' => ($event->payment_option===1)?Input::get('fee_3'):0,
              ]);
          }
          
          EventTypeDetail::where('event_id',$id)->update([
              'event_type_id' => Input::get('event_type_id'),
              'max_seats' => Input::get('max_seats'),
              'registration_start_date' => date(Input::get('registration_start_date')),
              'registration_end_date' => date(Input::get('registration_end_date')),
              'registration_start_time' => Input::get('registration_start_time'),
              'registration_end_time' => Input::get('registration_end_time'),
              'certification' => Input::get('certification_option'),
              'meals' => Input::get('meals_option')
          ]);

          $grant_technical = EventGrantType::where('grant_type_name', 'technical')->first();
          if(EventGrant::where('event_id',$id)->where('grant_type_id',$grant_technical->id)->exists()) {
            EventGrant::where('event_id',$id)->where('grant_type_id',$grant_technical->id)->update([
                'grant_description' => Input::get('technical_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id')
              ]);
          }else if (Input::get('technical_description')) {
              EventGrant::create([
                'grant_type_id' => $grant_technical->id,
                'grant_description' => Input::get('technical_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                'event_id' => $id,
              ]);
          }

          $grant_financial = EventGrantType::where('grant_type_name', 'financial')->first();
          if(EventGrant::where('event_id',$id)->where('grant_type_id',$grant_financial->id)->exists()) {
            EventGrant::where('event_id',$id)->where('grant_type_id',$grant_financial->id)->update([
                'grant_description' => Input::get('financial_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id')
              ]);
          }else if (Input::get('financial_description')) {
              EventGrant::create([
                'grant_type_id' => $grant_financial->id,
                'grant_description' => Input::get('financial_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                'event_id' => $id,
              ]);
          }

          $grant_infrastructure = EventGrantType::where('grant_type_name', 'infrastructure')->first();
          if(EventGrant::where('event_id',$id)->where('grant_type_id',$grant_infrastructure->id)->exists()) {
            EventGrant::where('event_id',$id)->where('grant_type_id',$grant_infrastructure->id)->update([
                'grant_description' => Input::get('infrastructure_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id')
              ]);
          }else if (Input::get('infrastructure_description')) {
              EventGrant::create([
                'grant_type_id' => $grant_infrastructure->id,
                'grant_description' => Input::get('infrastructure_description'),
                'grant_status_id' => EventGrantStatus::where('grant_status_name', 'Waiting')->value('id'),
                'event_id' => $id,
              ]);
          }
      
        });
      }
      
      return redirect()->back();
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
        $csiIndividualSubscribers = CsiIndividualSubscriber::where('event_id',$id)->paginate();
        $csiOrganisationSubscribers = CsiOrganisationSubscriber::where('event_id',$id)->paginate();
        $nonCsiIndividualSubscribers = NonCsiIndividualSubscriber::where('event_id',$id)->paginate();
        $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscriber::where('event_id',$id)->paginate();
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
          $csiIndividualSubscribers = CsiIndividualSubscriber::where('event_id','<','0')->paginate();
          $csiOrganisationSubscribers = CsiOrganisationSubscriber::where('event_id','<','0')->paginate();
          $nonCsiIndividualSubscribers = NonCsiIndividualSubscriber::where('event_id','<','0')->paginate();
          $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscriber::where('event_id','<','0')->paginate(); 
        if(!is_null($csiIndi) || !is_null($nonCsiIndi) || !is_null($csiOrg) || !is_null($nonCsiOrg)) {
            if($csiIndi) {
              if(!is_null($search_text))
                  $csiIndividualSubscribers = CsiIndividualSubscriber::where('event_id',$id)->paginate();
              else
                  $csiIndividualSubscribers = CsiIndividualSubscriber::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($nonCsiIndi) {
              if(!is_null($search_text))
                  $nonCsiIndividualSubscribers = NonCsiIndividualSubscriber::where('event_id',$id)->paginate();
              else
                  $nonCsiIndividualSubscribers = NonCsiIndividualSubscriber::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($csiOrg) {
              if(!is_null($search_text))
                $csiOrganisationSubscribers = CsiOrganisationSubscriber::where('event_id',$id)->paginate();
              else
                $csiOrganisationSubscribers = CsiOrganisationSubscriber::where('event_id',$id)->where('id',$search_text)->paginate();
            }
            if($nonCsiOrg) {
              if(!is_null($search_text))
                $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscriber::where('event_id',$id)->paginate();
              else
                $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscriber::where('event_id',$id)->where('id',$search_text)->paginate();
            }
        }
        else {
            $csiIndividualSubscribers = CsiIndividualSubscriber::where('event_id',$id)->paginate();
            $csiOrganisationSubscribers = CsiOrganisationSubscriber::where('event_id',$id)->paginate();
            $nonCsiIndividualSubscribers = NonCsiIndividualSubscriber::where('event_id',$id)->paginate();
            $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscriber::where('event_id',$id)->paginate(); 
        }
      return view('frontend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
   }
  }

   public function addPost(Request $request, $id) {
      if($id!=null || intval($id)>0){
            $post = new EventPost;
            $post->event_id = $id;
            $post->post_text = Input::get('post_text');
            if(!is_null($request->file('post_image'))) {
              $imageId = $id.'_'.EventPost::orderBy('id','desc')->value('id')+1;
              $postImage = $imageId.'.'.$request->file('post_image')->getClientOriginalExtension();
              $request->file('post_image')->move(storage_path('uploads/events/post_images'),$postImage);
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

    public function listMyEvents(Request $request){  
        $current_id= Auth::user()->user()->id;
        $rows = (Input::exists('row'))? (Input::get('row') < 5)?5:Input::get('row'): 15; // how many rows for pagination
        $statuses = EventStatus::lists('event_status_name','id');
        $search_options = [
            0=>'nothing',
            1=>'event id',
            2=>'event name',
            3=>'event type',
            4=>'request id',
        ];

        $page = (Input::exists('page'))? abs(Input::get('page')): 1;        // current page
        $status_selected = (Input::exists('status'))? $request->get('status'): array(); 
        $search_option_selected = (Input::exists('search'))? intval(Input::get('search')): 0; 
        $search_text = (Input::exists('search_text'))? Input::get('search_text'): "";         
        $fromDate=(Input::exists('request_from_date'))? $request->request_from_date: "";
        $toDate=(Input::exists('request_to_date'))? $request->request_to_date: "";
        
        $events = Event::where('member_id',$current_id)->paginate($rows);

        if($search_option_selected){
          switch($search_option_selected){
            case 1: if(empty($status_selected) )
                    {
                        $events= Event::where('event_id',$search_text)->latest()->paginate($rows);
                    }
                    else
                    {
                      $events= Event::where('event_id',$search_text)->whereIn('event_status',$status_selected)->latest()->paginate($rows); 
                    }
                    break;
            case 2: if(empty($status_selected) )
                    {
                        $events= Event::where('event_name',$search_text)->latest()->paginate($rows);
                    }
                    else
                    {
                      $events= Event::where('event_name',$search_text)->whereIn('event_status',$status_selected)->latest()->paginate($rows); 
                    }
                    break;
              case 3: if(empty($status_selected) )
                    {
                      $type=EventType::select('id')->where('event_type_name','like','%'.$search_text.'%')->get();
                      $events= Event::whereIn('event_type_id',$type)->latest()->paginate($rows); 
                    }
                    else
                    {
                      $type=EventType::select('id')->where('event_type_name',$search_text)->get();
                      $events= Event::whereIn('event_type_id',$type)->whereIn('event_status',$status_selected)->latest()->paginate($rows);                    
                    }
                    break;
              case 4:if(empty($status_selected) )
                    {
                        $events= Event::where('id',$search_text)->latest()->paginate($rows);
                    }
                    else
                    {
                      $events= Event::where('id',$search_text)->whereIn('event_status',$status_selected)->latest()->paginate($rows); 
                    }
                    break;
            }       
        } else {
            if(empty($status_selected) )
            {
              $events = Event::where('member_id',$current_id)->paginate($rows);
            }
            else
            {
              $events= Event::whereIn('event_status',$status_selected)->latest()->paginate($rows);
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

      return view('frontend.events.my-event-list',compact( 'rows','statuses','search_options','page','status_selected','search_option_selected','search_text','fromDate','toDate','events','current_id'));
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