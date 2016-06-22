<?php

namespace App\Http\Controllers;

use App\AcademicMember;
use App\Address;
use App\CsiChapter;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\CreateRegisterRequest;
use App\Individual;
use App\Institution;
use App\InstitutionType;
use App\Jobs\SendRegisterSms;
use App\Journal;
use App\Member;
use App\MembershipPeriod;
use App\Narration;
use App\Payment;
use App\PaymentHead;
use App\PaymentMode;
use App\Phone;
use App\ProfessionalMember;
use App\RequestService;
use App\Salutation;
use App\Service;
use App\ServiceTaxClass;
use App\State;
use App\StudentMember;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Input;
use Log;
use Response;

class RegisterController extends Controller
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
    public function create($entity) {   
        $name = $entity;
        $membershipPeriods = [];
        $institutionTypes = [];
        $titles = [];
        $payModes = [];
        
        $titles = Salutation::all();
        $modes = PaymentMode::all();
        foreach ($modes as $mode) {
            $payModes[$mode->id] = $mode->name;
        }

        if( ( $entity == 'institution-academic') ) {
            $membershipPeriods = MembershipPeriod::getPeriodsByType(1)->get();
            $institutionTypes = InstitutionType::getInstitutionTypesById(1)->get();
            return view('frontend.register.institution-academic', compact('entity', 'membershipPeriods', 'institutionTypes', 'titles', 'payModes'));
        } else if( ( $entity == 'institution-non-academic' ) ){
            $membershipPeriods = MembershipPeriod::getPeriodsByType(2)->get();
            return view('frontend.register.institution-non-academic', compact('entity', 'membershipPeriods', 'titles', 'payModes'));
        } else if( ( $entity == 'individual-student' ) ){
            $membershipPeriods = MembershipPeriod::getPeriodsByType(3)->get();
            return view('frontend.register.individual-student', compact('entity', 'membershipPeriods', 'titles', 'payModes'));
        } else if( ( $entity == 'individual-professional' ) ){
            $membershipPeriods = MembershipPeriod::getPeriodsByType(4)->get();
            $non_academic = Institution::where('membership_type_id', 2); // taking all the professional institutions 
            return view('frontend.register.individual-professional', compact('entity', 'membershipPeriods', 'titles', 'payModes', 'non_academic'));
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRegisterRequest $request, $entity)
    {
        $user = null;

        if ( ( $entity == 'institution-academic') ) {
            $user = $this->storeAcademicInstitution();               
        } else if ( ( $entity == 'institution-non-academic') ) {
            $user = $this->storeNonAcademicInstitution();               
        } else if ( ( $entity == 'individual-student') ) {
            $user = $this->storeStudentIndividual();               
        } else if ( ( $entity == 'individual-professional') ) {
            $user = $this->storeProfessionalIndividual();               
        }

        if ($user){
            
            $name = $user->subType()->getName();
            $aid = $user->subType->membershipType->prefix."-".$user->id;
            $email = $user->email;
            
            if ( ( $entity == 'institution-academic') || ( $entity == 'institution-non-academic')) {
                return View('frontend.register.register_success_institution', compact('name', 'email', 'aid'));
            } else if ( ( $entity == 'individual-student') || ( $entity == 'individual-professional')) {
                return View('frontend.register.register_success_individual', compact('name', 'email', 'aid'));
            } 
        }
        

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

    public function getResource($resource){

        if(is_string($resource)){
            
            if('amount' == $resource){
                $country_code = Input::get('country_code');
                $mem_period = Input::get('mem_period');
                                
                // hard coding the currency ID to query payment-heads
                if('IND' == $country_code){
                    $currency_id = 1;
                } else{
                    $currency_id = 2;
                }
                Log::info('In getResource: '.$country_code.$mem_period);
                $head = PaymentHead::getHead($mem_period, $currency_id)->first();
                $data = [
                    'amount' => $head->amount,
                    'service_tax' => ServiceTaxClass::find($head->service_tax_class_id)->tax_rate
                ];
                
            } else if('states' == $resource){
                $country_code = Input::get('code');
                Log::info('In getResource for states: '.$country_code);
                // querying with states of india and not regions > states;
                $states = State::where('country_code', 'like', $country_code)->orderBy('name', 'asc')->get(['state_code', 'name'])->toarray();
                Log::info('In getResource for states: typeof '.gettype($states));
                
                $data = $states;

            } else if('branches' == $resource){
                $state_code = Input::get('code');
                Log::info('In getResource for branches: '.$state_code);
                $chapters = CsiChapter::where('csi_state_code', $state_code)->get();
                $collection = new \Illuminate\Database\Eloquent\Collection;
                $result = new \Illuminate\Database\Eloquent\Collection;
                foreach ($chapters as $chapter) {
                    $members = Member::where('csi_chapter_id', $chapter->id)->get();
                    if(!$members->isEmpty()){
                        $collection = $members->filter(function ($item) {
                            $curr = $item->subType;
                            if($curr->membership_type_id == 1) {
                                if($curr->subType->is_student_branch) {
                                    return $item;
                                }
                            }
                        });
                    }
                }
                foreach ($collection as $member) {
                    $arr = [];
                    $arr['member_id'] = $member->subType->id;
                    $arr['name'] = $member->subType->name;
                    $result->add($arr);
                }
                
                $data = $result->sortBy('name')->toarray();
            } else if('chapters' == $resource){
                $state_code = Input::get('code');
                Log::info('In getResource for chapters: '.$state_code);
                $chapters = CsiChapter::where('csi_state_code', $state_code)->orderBy('name', 'asc')->get(['id', 'name'])->toarray();
                Log::info('In getResource for chapters: typeof '.gettype($chapters));
               
                $data = $chapters;
            } else if('institutions' == $resource){

            }
            
            $response = Response::json($data, 200);
        } else{
            $response = Response::json(array('errors' => $e->getMessage()), 500);
        }
        return $response;
    }


    private function storeAcademicInstitution() {

        $var = DB::transaction(function($connection) {
               
                $membership_period      = Input::get('membership-period');
                $institution_type       = Input::get('institution_type');
                $nameOfInstitution      = Input::get('nameOfInstitution');
                
                $country                = Input::get('country');
                $state                  = Input::get('state');
                $chapter                = Input::get('chapter');
                $address                = Input::get('address');
                $city                   = Input::get('city');
                $pincode                = Input::get('pincode');
                $email1                 = Input::get('email1');
                $email2                 = Input::get('email2');
                $std                    = Input::get('std');
                $phone                  = Input::get('phone');
                
                $salutation             = Input::get('salutation');
                $headName               = Input::get('headName');
                $headDesignation        = Input::get('headDesignation');
                $headEmail              = Input::get('headEmail');
                $country_code           = Input::get('country-code');
                $mobile                 = Input::get('mobile');
                
                $paymentMode            = Input::get('paymentMode');
                $tno                    = Input::get('tno');
                $drawn                  = Input::get('drawn');
                $bank                   = Input::get('bank');
                $branch                 = Input::get('branch');
                $paymentReciept         = Input::file('paymentReciept');
                $amountPaid             = Input::get('amountPaid');

                $member = new Member; 

                $num = $country_code.'-'.$mobile;

                $member->membership_id = 1;
                $membership_type = 1;
                $member->csi_chapter_id = $chapter;
                $member->email = $email1;
                $member->email_extra = $email2;
                $member->password = bcrypt('1234');

                $member->save();
                $member->id;
                $filename = $member->id.'.';
                $filename.=$paymentReciept->getClientOriginalExtension();
            
                Address::create([
                    'type_id' => 1,
                    'member_id' => $member->id,
                    'country_code' => $country, 
                    'state_code' => $state,
                    'address_line_1' => $address,
                    'city' => $city,
                    'pincode' => $pincode
                ]);

                Phone::create([
                    'member_id' => $member->id,
                    'std_code' => $std,
                    'landline' => $phone
                ]);

                $paymentReciept->move(storage_path('uploads/payment_proofs'), $filename);
                

                $institution = Institution::create([
                    'member_id' => $member->id, 
                    'membership_type_id' => $membership_type, 
                    'salutation_id' => $salutation, 
                    'name' => $nameOfInstitution, 
                    'head_name' => $headName, 
                    'head_designation' => $headDesignation, 
                    'email' => $headEmail, 
                    'country_code' => $country_code,
                    'mobile' => $mobile,
                ]);


                $academic_member = AcademicMember::create([
                    'id' => $institution->id,
                    'institution_type_id' => $institution_type
                ]);


                // 2nd arg is currency.. needs to be queried to put here
                $head = PaymentHead::getHead($membership_period, 1)->first();

                $payment = Payment::create([
                    'paid_for' => $member->id, 
                    'payment_head_id' => $head->id, 
                    'service_id' => 1
                ]);

                $narration = Narration::create([ 
                    'payer_id' => $member->id, 
                    'mode' => $paymentMode, 
                    'transaction_number' => $tno, 
                    'bank' => $bank, 
                    'branch' => $branch, 
                    'date_of_payment' => $drawn, 
                    'drafted_amount' => $head->amount, 
                    'proof' => $filename
                ]);

                $journal = Journal::create([
                    'payment_id' => $payment->id,
                    'narration_id' => $narration->id,
                    'paid_amount' => $amountPaid, 
                ]);
                
                $request = RequestService::create([
                    'service_id' => Service::getServiceIDByType('membership'),
                    'payment_id' => $payment->id, 
                    'member_id'  => $member->id
                ]);


                return $member;
            });

        return $var;

    }

    private function storeNonAcademicInstitution() {
        $var = DB::transaction(function($connection) {
               
                $membership_period = Input::get('membership-period');
                $nameOfInstitution = Input::get('nameOfInstitution');
                
                $country = Input::get('country');
                $state = Input::get('state');
                $chapter = Input::get('chapter');
                $address = Input::get('address');
                $city = Input::get('city');
                $pincode = Input::get('pincode');
                
                $email1 = Input::get('email1');
                $email2 = Input::get('email2');
                $std = Input::get('std');
                $phone = Input::get('phone');
                
                $salutation = Input::get('salutation');
                $headName = Input::get('headName');
                $headDesignation = Input::get('headDesignation');
                $headEmail = Input::get('headEmail');
                $country_code = Input::get('country-code');
                $mobile = Input::get('mobile');
                
                $paymentMode = Input::get('paymentMode');
                $tno = Input::get('tno');
                $drawn = Input::get('drawn');
                $bank = Input::get('bank');
                $branch = Input::get('branch');
                $paymentReciept = Input::file('paymentReciept');
                $amountPaid = Input::get('amountPaid');

                $member = new Member;

                $num = $country_code.'-'.$mobile;

                    
                $member->membership_id = 1; // institutional membership type ID
                $membership_type = 2; // non academic membership type id
                $member->csi_chapter_id = $chapter;
                $member->email = $email1;
                $member->email_extra = $email2;
                $member->password = bcrypt('1234');

                $member->save();
                $member->id;
                $filename = $member->id.'.';
                $filename.=$paymentReciept->getClientOriginalExtension();
                
                Address::create([
                    'type_id' => 1,
                    'member_id' => $member->id,
                    'country_code' => $country, 
                    'state_code' => $state,
                    'address_line_1' => $address,
                    'city' => $city,
                    'pincode' => $pincode
                ]);

                Phone::create([
                    'member_id' => $member->id,
                    'std_code' => $std,
                    'landline' => $phone
                ]);

                $paymentReciept->move(storage_path('uploads/payment_proofs'), $filename);

                $institution = Institution::create([
                    'member_id' => $member->id, 
                    'membership_type_id' => $membership_type, 
                    'salutation_id' => $salutation, 
                    'name' => $nameOfInstitution, 
                    'head_name' => $headName, 
                    'head_designation' => $headDesignation, 
                    'email' => $headEmail, 
                    'country_code' => $country_code,
                    'mobile' => $mobile,
                ]);


                        
                // 2nd arg is currency.. needs to be queried to put here
                $head = PaymentHead::getHead($membership_period, 1)->first();

                $payment = Payment::create([
                    'paid_for' => $member->id, 
                    'payment_head_id' => $head->id, 
                    'service_id' => 1
                ]);

                $narration = Narration::create([ 
                    'payer_id' => $member->id, 
                    'mode' => $paymentMode, 
                    'transaction_number' => $tno, 
                    'bank' => $bank, 
                    'branch' => $branch, 
                    'date_of_payment' => $drawn, 
                    'drafted_amount' => $head->amount, 
                    'proof' => $filename
                ]);

                $journal = Journal::create([
                    'payment_id' => $payment->id,
                    'narration_id' => $narration->id,
                    'paid_amount' => $amountPaid, 
                ]);
                
                $request = RequestService::create([
                    'service_id' => Service::getServiceIDByType('membership'),
                    'payment_id' => $payment->id, 
                    'member_id'  => $member->id
                ]);

                return $member;
            });

        return $var;
    }

    private function storeProfessionalIndividual(){
        $var = DB::transaction(function($connection) {

            $membership_period = Input::get('membership-period');
            $salutation = Input::get('salutation');
            $fname = Input::get('fname');
            $mname = Input::get('mname');
            $lname = Input::get('lname');
            $card_name = Input::get('card_name');
            $dob = Input::get('dob');
            $gender = Input::get('gender');
            
            $country = Input::get('country');
            $state = Input::get('state');
            $chapter = Input::get('chapter');
            $address = Input::get('address');
            $city = Input::get('city');
            $pincode = Input::get('pincode');
            
            $email1 = Input::get('email1');
            $email2 = Input::get('email2');
            $std = Input::get('std');
            $phone = Input::get('phone');
            $country_code = Input::get('country-code');
            $mobile = Input::get('mobile');
            
            $organisation = Input::get('organisation');
            $designation = Input::get('designation');
            
            $paymentMode = Input::get('paymentMode');
            $tno = Input::get('tno');
            $drawn = Input::get('drawn');
            $bank = Input::get('bank');
            $branch = Input::get('branch');
            $paymentReciept = Input::file('paymentReciept');
            $amountPaid = Input::get('amountPaid');

            $member = new Member;

                
            $member->membership_id = 2; // individual member
            $membership_type = 4; // professional member
            $member->csi_chapter_id = $chapter;
            $member->email = $email1;
            $member->email_extra = $email2;
            $member->password = bcrypt('1234');

            $member->save();
            $member->id;
            $filename = $member->id.'.';
            $filename.=$paymentReciept->getClientOriginalExtension();
            
            Address::create([
                'type_id' => 1,
                'member_id' => $member->id,
                'country_code' => $country, 
                'state_code' => $state,
                'address_line_1' => $address,
                'city' => $city,
                'pincode' => $pincode
            ]);

            Phone::create([
                'member_id' => $member->id,
                'std_code' => $std,
                'landline' => $phone,
                'country_code' => $country_code,
                'mobile' => $mobile,
            ]);

            $paymentReciept->move(storage_path('uploads/payment_proofs'), $filename);
            

            $individual = Individual::create([
                'member_id' => $member->id, 
                'membership_type_id' => $membership_type, 
                'salutation_id' => $salutation, 
                'first_name' => $fname,
                'middle_name' => $mname,
                'last_name' => $lname,
                'card_name' => $card_name,
                'gender' => $gender,
                'dob' => $dob
            ]);

            $professional = ProfessionalMember::create([
                'id' => $individual->id,
                'organisation' => $organisation,
                'designation' => $designation
            ]);
                
            // 2nd arg is currency.. needs to be queried to put here
            $head = PaymentHead::getHead($membership_period, 1)->first();

            $payment = Payment::create([
                'paid_for' => $member->id, 
                'payment_head_id' => $head->id, 
                'service_id' => 1
            ]);

            $narration = Narration::create([ 
                'payer_id' => $member->id, 
                'mode' => $paymentMode, 
                'transaction_number' => $tno, 
                'bank' => $bank, 
                'branch' => $branch, 
                'date_of_payment' => $drawn, 
                'drafted_amount' => $head->amount, 
                'proof' => $filename
            ]);

            $journal = Journal::create([
                'payment_id' => $payment->id,
                'narration_id' => $narration->id,
                'paid_amount' => $amountPaid, 
            ]);
            
            $request = RequestService::create([
                'service_id' => Service::getServiceIDByType('membership'),
                'payment_id' => $payment->id, 
                'member_id'  => $member->id
            ]);

                return $member;
            });
        return $var;
    }


    private function storeStudentIndividual(){
        $var = DB::transaction( function($connection) {

            $membership_period = Input::get('membership-period');
            $salutation = Input::get('salutation');
            $fname = Input::get('fname');
            $mname = Input::get('mname');
            $lname = Input::get('lname');
            $card_name = Input::get('card_name');
            $dob = Input::get('dob');
            $gender = Input::get('gender');
            
            $country = Input::get('country');
            $state = Input::get('state');
            $stud_branch = Input::get('stud_branch');
            $address = Input::get('address');
            $city = Input::get('city');
            $pincode = Input::get('pincode');
            
            $college = Input::get('college');
            $course = Input::get('course');
            $cbranch = Input::get('cbranch');
            $cduration = Input::get('cduration');    
            
            $email1 = Input::get('email1');
            $email2 = Input::get('email2');
            $std = Input::get('std');
            $phone = Input::get('phone');
            $country_code = Input::get('country-code');
            $mobile = Input::get('mobile');
            
            $paymentMode = Input::get('paymentMode');
            $tno = Input::get('tno');
            $drawn = Input::get('drawn');
            $bank = Input::get('bank');
            $branch = Input::get('branch');
            $paymentReciept = Input::file('paymentReciept');
            $amountPaid = Input::get('amountPaid');

            $student_branch = AcademicMember::find($stud_branch);
            $chapter = $student_branch->institution->member->csi_chapter_id;

            $member = new Member;
                
            $member->membership_id = 2; // individual member
            $membership_type = 3; // student member
            $member->csi_chapter_id = $chapter;
            $member->email = $email1;
            $member->email_extra = $email2;
            $member->password = bcrypt('1234');

            $member->save();
            $member->id;
            $filename = $member->id.'.';
            $filename.=$paymentReciept->getClientOriginalExtension();
            
            Address::create([
                'type_id' => 1,
                'member_id' => $member->id,
                'country_code' => $country, 
                'state_code' => $state,
                'address_line_1' => $address,
                'city' => $city,
                'pincode' => $pincode
            ]);

            Phone::create([
                'member_id' => $member->id,
                'std_code' => $std,
                'landline' => $phone,
                'country_code' => $country_code,
                'mobile' => $mobile,
            ]);

            $paymentReciept->move(storage_path('uploads/payment_proofs'), $filename);
            

                $individual = Individual::create([
                    'member_id' => $member->id, 
                    'membership_type_id' => $membership_type, 
                    'salutation_id' => $salutation, 
                    'first_name' => $fname,
                    'middle_name' => $mname,
                    'last_name' => $lname,
                    'card_name' => $card_name,
                    'gender' => $gender,
                    'dob' => $dob
                ]);

                $student_details = StudentMember::create([
                    'id'                => $individual->id,
                    'student_branch_id' => $student_branch->id,
                    'college_name'      => $college,
                    'course_name'       => $course,
                    'course_branch'     => $cbranch,
                    'course_duration'   => $cduration
                ]);

                // 2nd arg is currency.. needs to be queried to put here
                $head = PaymentHead::getHead($membership_period, 1)->first();

                $payment = Payment::create([
                    'paid_for' => $member->id, 
                    'payment_head_id' => $head->id, 
                    'service_id' => 1
                ]);

                $narration = Narration::create([ 
                    'payer_id' => $member->id, 
                    'mode' => $paymentMode, 
                    'transaction_number' => $tno, 
                    'bank' => $bank, 
                    'branch' => $branch, 
                    'date_of_payment' => $drawn, 
                    'drafted_amount' => $head->amount, 
                    'proof' => $filename
                ]);

                $journal = Journal::create([
                    'payment_id' => $payment->id,
                    'narration_id' => $narration->id,
                    'paid_amount' => $amountPaid, 
                ]);
                
                $request = RequestService::create([
                    'service_id' => Service::getServiceIDByType('membership'),
                    'payment_id' => $payment->id, 
                    'member_id'  => $member->id
                ]);
                
                return $member;
            });

            return $var;
    }

}
