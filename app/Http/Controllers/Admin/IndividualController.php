<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Individual;
use App\Jobs\SendVerificationSms;
use App\Narration;
use App\RejectedNarration;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;

class IndividualController extends Controller
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
        if($typeId==3) {
            // $institutions = Member::getAllInstitions()->get()->getAllAcademicInstitutions()->get();
            $typeName = 'Student Members';
            $academics = Individual::getAllStudents()->get();
            return view('backend.individuals.academic', compact('typeId', 'academics', 'counter', 'typeName'));
        } else if($typeId==4) { // non-academic
            $typeName = 'Professional Members';
            $academics = Individual::getAllProfessionals()->get();
            return view('backend.individuals.academic', compact('typeId','academics', 'counter', 'typeName'));
        }
    }

    public function verify($typeId, $id) {   

        $inst = Individual::find($id);
        $inst->member->is_verified = 1;
        $inst->member->save();

        $user = $inst->member;
        $aid = $user->subType->membershipType->prefix."-".$user->id;
        $email = $user->email;
        $password = '1234';
        $period = $user->payments->first()->paymentHead->membershipPeriod->name;
        $membership_type = ($typeId==3)? 'Individual (Student)': 'Individual (Professional)';

        $this->dispatch(new SendVerificationSms($aid, $email, $user->subType->mobile));
            
        Mail::queue('frontend.emails.individual_verify', ['membership_type' => $membership_type, 'period' => $period, 'password'=>$password, 'name' => $user->subType->getName(), 'email' => $email, 'aid' => $aid], function($message) use($user) {
                    $message->to($user->email)->subject('CSI-Membership verified'); 
        });
        
        Flash::success('Success! verified the Member, now they can use their services');
        
        return redirect()->route('backendIndividual', [$typeId]);
    }

    public function profile($typeId, $id) {   

        $user = Individual::find($id);
        return view('backend.individuals.profile', compact('user', 'typeId', 'id') );
    }

    public function view_proof($typeId, $id, $nid){
        $narration = Narration::find($nid);
        $proof = storage_path('uploads/payment_proofs/'.$narration->proof);
        return view('backend.individuals.proof', compact('proof'));
    }

    public function reject_payment($typeId, $id, $narration_id) {   

        $user = Individual::find($id);
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
