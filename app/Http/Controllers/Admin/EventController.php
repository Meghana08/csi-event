<?php

namespace App\Http\Controllers\Admin;
use App\CsiIndividualSubscriber;
use App\CsiOrganisationSubscriber;
use App\CsiSubscriberNominee;
use App\Event;
use App\EventCancellationRequest;
use App\EventGrant;
use App\EventGrantStatus;
use App\EventGrantType;
use App\EventRequestAdminDecision;
use App\EventStatus;
use App\EventStatusChange;
use App\EventType;
use App\TargetAudience;
use App\TargetAudienceWithFee;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Institution;
use App\InstitutionType;
use App\Journal;
use App\Member;
use App\MembershipType;
use App\NonCsiIndividualSubscriber;
use App\NonCsiOrganisationSubscriber;
use App\OrganisationSubscriberNominee;
use App\Payment;
use DB;
use Illuminate\Http\Request;
use Input;
use Laracasts\Flash\Flash;

class EventController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)     
    {
        $rows = (Input::exists('row'))? (Input::get('row') < 5)?5:Input::get('row'): 15; // how many rows for pagination
        $statuses = EventStatus::lists('event_status_name','id');
        $search_options = [
            0=>'nothing',
            1=>'event id',
            2=>'event name',
            3=>'event type',
            4=>'request id',
            5=>'member id',
            6=>'member name',
            7=>'institution name',
            8=>'email id',
        ];

        // filters
        $page = (Input::exists('page'))? abs(Input::get('page')): 1;        // current page
        $status_selected = (Input::exists('status'))? $request->get('status'): array(); 
        $search_option_selected = (Input::exists('search'))? intval(Input::get('search')): 0; 
        $search_text = (Input::exists('search_text'))? Input::get('search_text'): "";         
        $fromDate=(Input::exists('request_from_date'))? $request->request_from_date: "";
        $toDate=(Input::exists('request_to_date'))? $request->request_to_date: "";

        $events= Event::latest()->paginate($rows);
        
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
              case 5: if(empty($status_selected) )
                    {
                      $events=Event::where('member_id',$search_text)->latest()->paginate($rows);
                    }
                    else
                    {
                      $events=Event::where('member_id',$search_text)->whereIn('event_status',$status_selected)->latest()->paginate($rows);
                    }
                    break;
            case 6: if(empty($status_selected) )
                    {
                      $member_id=Individual::select('member_id')->where('first_name',$search_text)->get();
                      $events=Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                    }
                    else
                    {
                      $member_id=Individual::select('member_id')->where('first_name',$search_text)->get();
                      $events=Event::whereIn('member_id',$member_id)->whereIn('event_status',$status_selected)->latest()->paginate($rows);
                    }
                    break;
            case 7: if(empty($status_selected) )
                    {
                      $member_id=Institution::select('member_id')->where('name',$search_text)->get();                    
                      $events= Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                    }
                    else
                    {
                      $member_id=Institution::select('member_id')->where('name',$search_text)->get();                    
                      $events= Event::whereIn('member_id',$member_id)->whereIn('event_status',$status_selected)->latest()->paginate($rows);
                    }
                    break;
            case 8: if(empty($status_selected) )
                    {
                      $member_id=Member::select('id')->where('email',$search_text)->get();
                      $events= Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                    }
                    else
                    {
                      $member_id=Member::select('id')->where('email',$search_text)->get();
                      $events= Event::whereIn('member_id',$member_id)->whereIn('event_status',$status_selected)->latest()->paginate($rows);
                    }
                    break;

            }       
        } else {
            if(empty($status_selected) )
            {
              $events= Event::latest()->paginate($rows);
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

      return view('backend.events.eventList',compact( 'rows','statuses','search_options','page','status_selected','search_option_selected','search_text','fromDate','toDate','events'));
    }

    public function showEvent($id) {
          if($id!=null || intval($id)>0){
              $user = Member::find(Event::find($id)->value('member_id'));
              $event = Event::find($id);
              $grants = EventGrant::where('event_id',$id)->get();
              $targetAudience = TargetAudienceWithFee::where('event_id',$id)->get();
              $cancelRequests = EventCancellationRequest::where('event_id',$id)->first();
              return view('backend.events.event', compact('user', 'event', 'grants','cancelRequests','targetAudience'));
          }
    }

    public function viewSpecific($id)
    {
      if($id!=null || intval($id)>0)   
      {
          $rows = (Input::exists('row'))? (Input::get('row') < 5)?5:Input::get('row'): 15; // how many rows for pagination
          $statuses = EventStatus::lists('event_status_name','id');
          $search_options = [
              0=>'nothing',
              1=>'event id',
              2=>'event name',
              3=>'event type',
              4=>'request id',
              5=>'member id',
              6=>'member name',
              7=>'institution name',
              8=>'email id',
          ];

          // filters
          $page = (Input::exists('page'))? abs(Input::get('page')): 1;        // current page
          $status_selected = array(); 
          $search_option_selected = 0; 
          $search_text = "";         
          $fromDate="";
          $toDate="";

          $events= Event::latest()->paginate($rows);  
          switch ($id) {
            case '1': 
              $events = Event::where('event_type_id','>=',0)->paginate($rows);
              break;
            case '2': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Waiting')->value('id'))->paginate($rows);
              break;
            case '3': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Accepted')->value('id'))->paginate($rows);
              break;
            case '4': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Rejected')->value('id'))->paginate($rows);
              break;
            case '5': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Closed')->value('id'))->paginate($rows);
              break;
            case '6': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Requested For Cancellation')->value('id'))->paginate($rows);
              break;
            case '7': 
              $events = Event::where('event_status',EventStatus::where('event_status_name','Cancelled')->value('id'))->paginate($rows);
              break;
            default:
              Event::latest()->paginate($rows);
              break;
          }
          return view('backend.events.eventList',compact( 'rows','statuses','search_options','page','status_selected','search_option_selected','search_text','fromDate','toDate','events'));
      }
    }

    public function changeStatusAccept($id)
    {
      $event = Event::find($id);
      $allGrantOK = true;
      foreach($event->eventGrants as $grant){
        if( !($grant->grant_status_id == 2 || $grant->grant_status_id == 5) ){
            $allGrantOK = false;
            break;
        }
      }

      if(!$allGrantOK){
          Flash::error("All grants have to be accepted or closed to peform this action");
          return redirect()->back();
      }
      
      $status_id = EventStatus::where('event_status_name','Accepted')->value('id');
      $change = new EventStatusChange;
      $change->event_id = $id;
      $change->prev_status = $event->event_status;
      $change->cur_status = $status_id;              
      $change->save();  
      Event::where('id',$id)->update(['event_status' => $status_id]);        
      Event::where('id',$id)->update(['event_id'=>$id ]);     //Generating Event ID

      return redirect()->back();          
    }

    public function changeStatusReject($id)
    {
      $event = Event::find($id);
      $allGrantOK = true;
      foreach($event->eventGrants as $grant){
        if( !($grant->grant_status_id == 2 || $grant->grant_status_id == 5) ){
            $allGrantOK = false;
            break;
        }
      }

      if(!$allGrantOK){
          Flash::error("All grants have to be accepted or closed to peform this action");
          return redirect()->back();
      }
      
      $status_id = EventStatus::where('event_status_name','Rejected')->value('id');
      $change = new EventStatusChange;
      $change->event_id = $id;
      $change->prev_status = $event->event_status;
      $change->cur_status = $status_id;              
      $change->save();      
      Event::where('id',$id)->update(['event_status' => $status_id]);   
      $grants = EventGrant::where('event_id',$id)->get();
      foreach ($grants as $grant) {
          EventGrant::where('id',$grant->id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Closed')->value('id')]);
      }
      return redirect()->back();          
    }

    public function grantStatusChangeAccept($id) {
      $grant_id = $id;
      EventGrant::where('id',$grant_id)->update(['reason' => Input::get('grant_status_reason')]);      
      EventGrant::where('id',$grant_id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Accepted')->value('id')]);                
      $event_id = EventGrant::where('id',$grant_id)->value('event_id');
      return redirect()->back();         
    }

    public function grantStatusChangeReject($id) {
       $grant_id = $id;
          EventGrant::where('id',$grant_id)->update(['reason' => Input::get('grant_status_reason')]);      
          EventGrant::where('id',$grant_id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Rejected')->value('id')]);                
      $event_id = EventGrant::where('id',$grant_id)->value('event_id');
      return redirect()->back();         
    }

    public function grantStatusChangeNegotiate($id) {
      $grant_id = $id;
      EventGrant::where('id',$grant_id)->update(['reason' => Input::get('grant_status_reason')]);
      EventGrant::where('id',$grant_id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Negotiable')->value('id')]);                
      $event_id = EventGrant::where('id',$grant_id)->value('event_id');
      return redirect()->back();         
    }

    public function cancelEvent($id)
    {
        EventCancellationRequest::where('event_id',$event_id)->update(['decision_id' => EventRequestAdminDecision::where('decision','accepted')->value('id')]);
        Event::where('id',$event_id)->update(['event_status' => EventStatus::where('event_status_name','Cancelled')->value('id')]);
        $grants = EventGrant::where('event_id',$event_id)->get();
        foreach ($grants as $grant) {
            EventGrant::where('id',$grant->id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Closed')->value('id')]);
        }  
        return redirect()->back();
    }

    public function cancelEventReject($id)
    {
        EventCancellationRequest::where('event_id',$id)->update(['decision_id' =>EventRequestAdminDecision::where('decision','rejected')->value('id')]);
        Event::where('id',$id)->update(['event_status' => EventStatus::where('event_status_name','Waiting')->value('id')]);
        return redirect()->route('adminEventDetails',[$id]);
    }

//PREVIOUS FUNCTIONS

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('backend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
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
      return view('backend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
   }
  }

    public function showNomineeDetailsCSI($id) {
        $nominees = CsiSubscriberNominee::where('subscriber_id',$id)->get();
        return view('backend.events.showNomineeDetails',compact('nominees'));
    }

    public function showNomineeDetailsORG($id) {
        $nominees = OrganisationSubscriberNominee::where('subscriber_id',$id)->get();
        return view('backend.events.showNomineeDetails',compact('nominees'));
    }
}
