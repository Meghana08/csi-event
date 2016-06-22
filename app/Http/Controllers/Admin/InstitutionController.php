<?php

namespace App\Http\Controllers\Admin;

use App\CsiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Institution;
use App\Jobs\SendVerificationSms;
use App\Narration;
use App\RejectedNarration;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($typeId)
    {   
        $counter = 0;
        // academic
        if($typeId==1) {
            // $institutions = Member::getAllInstitions()->get()->getAllAcademicInstitutions()->get();
            $typeName = 'Academic Institutions';
            $academics = Institution::getAllAcademicInstitutions()->paginate(15);
            return view('backend.institutions.academic', compact('typeId', 'academics', 'counter', 'typeName'));
        } else if($typeId==2) { // non-academic
            $typeName = 'Non-Academic Institutions';
            $academics = Institution::getAllNonAcademicInstitutions()->get();
            return view('backend.institutions.academic', compact('typeId','academics', 'counter', 'typeName'));
        }
    }

    public function verify($typeId, $id) {   

        $inst = Institution::find($id);
        $inst->member->is_verified = 1;
        $inst->member->save();


        $user = $inst->member;
        $aid = $user->subType->membershipType->prefix."-".$user->id;
        $email = $user->email;
        $password = '1234';
        $period = $user->payments->first()->paymentHead->membershipPeriod->name;
        $membership_type = ($typeId==3)? 'Institution (Academic)': 'Institution (Non-Academic)';

        $this->dispatch(new SendVerificationSms($aid, $email, $user->subType->mobile));
            
        Mail::queue('frontend.emails.institution_verify', ['membership_type' => $membership_type, 'period' => $period, 'password'=>$password, 'name' => $user->subType->getName(), 'email' => $email, 'aid' => $aid], function($message) use($user){
                    $message->to($user->email)->subject('CSI-Membership verified'); 
        });


        Flash::success('Success! verified the Institution, now they can use their services');
        
        return redirect()->route('backendInstitution', [$typeId]);
    }

    public function listStudentBranch() {
        $counter = 0;
        // academic
            // $institutions = Member::getAllInstitions()->get()->getAllAcademicInstitutions()->get();
        $typeName = 'Academic Institutions';
        $academics = CsiRequest::studentBranch()->isPending()->get();
        return view('backend.institutions.list_student_branch', compact('typeId', 'academics', 'counter', 'typeName'));
    }

    public function makeStudentBranch($rid) {
        $req = CsiRequest::find($rid);
        $academic = $req->requestedBy->subType->subType;

        $academic->is_student_branch = 1;
        $academic->save();

        $req->status_code = 1;
        $req->save();

        Flash::success('Success! insitution has been made a student branch');
        
        return redirect()->route('backendInstitutionListStudentBranch');

    }

    public function profile($typeId, $id) {   

        $user = Institution::find($id);
        return view('backend.institutions.profile', compact('user', 'typeId', 'id') );
    }

    public function reject_payment($typeId, $id, $narration_id) {   

        $user = Institution::find($id);
        return view('backend.institutions.payment_reject', compact('typeId', 'id', 'narration_id') );
    }

    public function store_reject_payment($typeId, $id, $narration_id) {   

        $reason = Input::get('reason');

        if(!is_null($reason) ) {
            if($reason != ''){
                 DB::transaction(function($connection) use ($narration_id, $reason){
                    $narration = Narration::findOrFail($narration_id);
                    $narration->is_rejected = 1;
                    $narration->save();
                    
                    $rejection = RejectedNarration::where('narration_id', $narration->id)->first();
                    
                    if($rejection == null) {
                        $rejection = RejectedNarration::create([
                            'narration_id' => $narration->id,
                            'reason' => $reason
                        ]);
                    } else {
                        $rejection->reason = $reason;
                    }

                    $rejection->save();
                    Flash::success('Rejection reason has been updated!');
                });
            }
        }

        
        return redirect()->route('backendInstitutionById', [$typeId, $id]);
    }

    public function accept_payment($typeId, $id, $narration_id) {   

            DB::transaction(function($connection) use ($narration_id){
                $narration = Narration::findOrFail($narration_id);
                $narration->is_rejected = 0;
                $narration->save();
                
                $rejection = RejectedNarration::where('narration_id', $narration->id)->first();
                
                if($rejection != null) {
                    $rejection->delete();
                }

                Flash::success('Payment Accepted!');
            });

        
        return redirect()->route('backendInstitutionById', [$typeId, $id]);
    }

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
}
