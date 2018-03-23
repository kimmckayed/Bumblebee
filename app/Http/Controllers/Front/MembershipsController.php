<?php

namespace App\Http\Controllers\Front;


use App\DataModels\MembershipDataModel;
use App\Http\Controllers\Controller;
use App\Managers\BillingManager;
use App\Managers\NotificationManager;
use App\Managers\RegistrationManager;
use App\Models\Customer;
use App\Models\Membership;

use App\Models\PromotionalCodes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;


class MembershipsController extends Controller
{

    public function getIndex()
    {
        $memberships = (new Membership())->getMembership(env('memberships_available', 9));

        return view('front.registration', ['memberships' => $memberships]);
    }

    public function postIndex(Request $request)
    {

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }


        $membership_data_model = new MembershipDataModel($request,
            ['company_id' => 6,'added_by'=>186]);
        $billing_manager = new BillingManager();
        if($request->has('coupon') ){
            $code =  PromotionalCodes::where('code','=',$request->get('coupon'))
                ->where('date_end','>',date('Y-m-d'))
                ->where('date_start','<=',date('Y-m-d'))
                ->first();
            if($code){
                $billing_manager->setDiscount($code->discount);
            }

        }
        if (!$billing_manager->getPriceAndChargeCard($membership_data_model->membership)) {
            Flash::error('Your payment wasn\'t successful.');

            return redirect()->back()->withInput();
        }


        $registration_manager = new RegistrationManager();
        $user = $registration_manager->createMembership($membership_data_model);


        if (!$user) {
            Flash::error('Registration failed, please contact Cartow.ie support for further information');

            return redirect()->back()->withInput();
        }
        Customer::where('user_id',$user->id)->update(['accept_terms'=>1]);
        (new NotificationManager())->newMemberShipRegistration($membership_data_model);


        return Redirect::to('http://www.cartow.ie/membership-thanks.html');


    }
    public function getAcceptTerms($hashed_id){
        $id = intval($hashed_id,16);
        Customer::where('user_id',$id)->update(['accept_terms'=>1]);
       return Redirect::to('http://www.cartow.ie/accepted.html');

    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [

            'vehicle_registration' => 'required',
            'fuel' => 'required',
            'colour' => 'required',
            'make' => 'required',
            'model' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'phone_number' => 'required',            
            'nct' => 'required',
            'odometer_reading' => 'required',
            'odometer_type' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }



}
