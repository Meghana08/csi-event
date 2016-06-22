<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Institution;
use App\InstitutionType;
use App\Member;
use App\MembershipType;
use Illuminate\Http\Request;
use DB;
use Input;
use App\Event;
use App\EventStatus;
use App\EventStatusChange;
use App\EventRequestAdminDecision;
use App\EventCancelationRequests;
use App\EventType;
use App\EventGrant;
use App\EventGrantType;
use App\EventGrantStatus;
use App\Payment;
use App\Journal;
use App\CsiIndividualSubscribers;
use App\CsiOrganisationSubscribers;
use App\NonCsiIndividualSubscribers;
use App\CsiSubscriberNominee;
use App\NonCsiOrganisationSubscribers;
use App\OrganisationSubscriberNominees;

class EventController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()     
    {
        $Institution = Institution::all();
        $statuses = EventStatus::all();
        $checkbox_array=array();
        $search=0;
        $search_text="";
        $fromDate="";
        $toDate="";
        $rows = (Input::exists('rows'))?abs(Input::get('rows')): 15;        
        $page = (Input::exists('page'))? abs(Input::get('page')): 1;
       $events= Event::where('event_type_id','>=',0)
                    ->paginate($rows);  
        return view( 'backend.events.eventList' , compact( 'events','page','rows', 'search_text','statuses','checkbox_array','search','fromDate','toDate','Institution') );
    }

     public function filterEvents(Request $request)    
    {
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
          case 1: $events= Event::where('event_id',$search_text)->latest()->paginate($rows);
                  break;
          case 2: if(count($status))
                  {
                    $events= Event::where('event_name','like','%'.$search_text.'%')->whereIn('event_status',$status)->latest()->paginate($rows);                    
                  }
                  else
                  {
                    $events= Event::where('event_name','like','%'.$search_text.'%')->latest()->paginate($rows);
                  }
                  break;
            case 3: if(count($status))
                  {
                    $type=EventType::select('id')->where('event_type_name','like','%'.$search_text.'%')->get();
                    $events= Event::whereIn('event_type_id',$type)->whereIn('event_status',$status)->latest()->paginate($rows);                    
                  }
                  else
                  {
                    $type=EventType::select('id')->where('event_type_name','like','%'.$search_text.'%')->get();
                    $events= Event::whereIn('event_type_id',$type)->latest()->paginate($rows); 
                  }
                  break;
            case 4:$events= Event::where('id',$search_text)->latest()->paginate($rows);
                  break;
            case 5: if(count($status))
                  {
                    $events=Event::where('member_id',$search_text)->whereIn('event_status',$status)->latest()->paginate($rows);
                  }
                  else
                  {
                    $events=Event::where('member_id',$search_text)->latest()->paginate($rows);
                  }
                  break;
          case 6: if(count($status))
                  {
                    $member_id=Individual::select('member_id')->where('first_name','like','%'.$search_text.'%')->get();
                    $events=Event::whereIn('member_id',$member_id)->whereIn('event_status',$status)->latest()->paginate($rows);
                  }
                  else
                  {
                    $member_id=Individual::select('member_id')->where('first_name','like','%'.$search_text.'%')->get();
                    $events=Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                  }
                  break;
          case 7: if(count($status))
                  {
                    $member_id=Institution::select('member_id')->where('name','like','%'.$search_text.'%')->get();                    
                    $events= Event::whereIn('member_id',$member_id)->whereIn('event_status',$status)->latest()->paginate($rows);
                  }
                  else
                  {
                    $member_id=Institution::select('member_id')->where('name','like','%'.$search_text.'%')->get();                    
                    $events= Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                  }
                  break;
          case 8: if(count($status))
                  {
                    $member_id=Member::select('id')->where('email','like','%'.$search_text.'%')->get();
                    $events= Event::whereIn('member_id',$member_id)->whereIn('event_status',$status)->latest()->paginate($rows);
                  }
                  else
                  {
                    $member_id=Member::select('id')->where('email','like','%'.$search_text.'%')->get();
                    $events= Event::whereIn('member_id',$member_id)->latest()->paginate($rows);
                  }
                  break;
        }       
      }
      else
      {
        if(count($status))
        {
          $events= Event::whereIn('event_status',$status)->latest()->paginate($rows);                    
        }
        else
        {
          $events= Event::all();
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
      return view('backend.events.eventList',compact( 'events' ,'page','rows', 'search_text','statuses','checkbox_array','search','fromDate','toDate','Institution'));
    } 

    public function showEvent($id) {
          if($id!=null || intval($id)>0){
              $user = Member::find(Event::where('id',$id)->value('member_id'));
              $event = Event::find($id);
              $grants = EventGrant::where('event_id',$id)->get();
              $cancelRequests = EventCancelationRequests::where('event_id',$id)->first();
              return view('backend.events.event', compact('user', 'event', 'grants','cancelRequests'));
          }
    }

    public function viewSpecific($id)
    {
      if($id!=null || intval($id)>0)   
      {
          $Institution = Institution::all();
          $statuses = EventStatus::all();
          $checkbox_array=array();
          $search=0;
          $search_text="";
          $fromDate="";
          $toDate="";
          $rows = (Input::exists('rows'))?abs(Input::get('rows')): 15;       
          $page = (Input::exists('page'))? abs(Input::get('page')): 1;
          $events= Event::where('event_type_id','>=',0)
                      ->paginate($rows);  
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
              Event::where('event_type_id','>=',0)->paginate($rows);
              break;
          }
          return view( 'backend.events.eventList' , compact( 'events','page','rows', 'search_text','statuses','checkbox_array','search','fromDate','toDate','Institution') );
      }
    }

    public function changeStatusAccept($id)
    {
      $event = Event::find($id);
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
        EventCancelationRequests::where('event_id',$event_id)->update(['decision_id' => EventRequestAdminDecision::where('decision','accepted')->value('id')]);
        Event::where('id',$event_id)->update(['event_status' => EventStatus::where('event_status_name','Cancelled')->value('id')]);
        $grants = EventGrant::where('event_id',$event_id)->get();
        foreach ($grants as $grant) {
            EventGrant::where('id',$grant->id)->update(['grant_status_id' => EventGrantStatus::where('grant_status_name','Closed')->value('id')]);
        }  
        return redirect()->back();
    }

    public function cancelEventReject($id)
    {
        EventCancelationRequests::where('event_id',$id)->update(['decision_id' =>EventRequestAdminDecision::where('decision','rejected')->value('id')]);
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
        $csiIndividualSubscribers = CsiIndividualSubscribers::where('event_id',$id)->paginate();
        $csiOrganisationSubscribers = CsiOrganisationSubscribers::where('event_id',$id)->paginate();
        $nonCsiIndividualSubscribers = NonCsiIndividualSubscribers::where('event_id',$id)->paginate();
        $nonCsiOrganisationSubscribers = NonCsiOrganisationSubscribers::where('event_id',$id)->paginate();
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
      return view('backend.events.showSuscribersList',compact('csiIndividualSubscribers','csiOrganisationSubscribers','nonCsiIndividualSubscribers','nonCsiOrganisationSubscribers','nominees1','nominees2','page','search_text','fromDate','toDate','id','csiIndi','nonCsiIndi','csiOrg','nonCsiOrg'));
   }
  }

    public function showNomineeDetailsCSI($id) {
        $nominees = CsiSubscriberNominee::where('subscriber_id',$id)->get();
        return view('backend.events.showNomineeDetails',compact('nominees'));
    }

    public function showNomineeDetailsORG($id) {
        $nominees = OrganisationSubscriberNominees::where('subscriber_id',$id)->get();
        return view('backend.events.showNomineeDetails',compact('nominees'));
    }
}
