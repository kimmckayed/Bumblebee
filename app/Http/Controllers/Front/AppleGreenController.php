<?php

namespace App\Http\Controllers\Front;


use App\DataModels\MembershipDataModel;
use App\Http\Controllers\Controller;
use App\Managers\NotificationManager;
use App\Managers\RegistrationManager;
use App\Models\Applegreencode;
use App\Models\Customer;
use App\Models\Membership;

use Illuminate\Http\Request;
use Input;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Flash;


class AppleGreenController extends Controller
{

    public function getIndex()
    {
        $memberships = (new Membership())->getMembership(env('memberships_available_apple_green', 5));

        return view('front.apple_green', ['memberships' => $memberships]);

    }

    public function postIndex(Request $request)
    {

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }


        $membership_data_model = new MembershipDataModel($request,
            ['company_id' => 14,'added_by'=>186]);
        $apple_green_code = $request->get('applegreen_code');

        $apple_green_manager = new Applegreencode();
        if ($apple_green_manager->checkApplgreencode($apple_green_code)['error'] !== 0) {
            Flash::error('This code has already been used or Invalid');
            return redirect()->back()->withInput();
        }



        $registration_manager = new RegistrationManager();
        $user = $registration_manager->createMembership($membership_data_model);
        if ($user) {
            Customer::where('user_id',$user->id)->update(['accept_terms'=>1]);
            (new NotificationManager())->newMemberShipRegistration($membership_data_model);

            $apple_green_manager->codeUsed($apple_green_code, $user->id);

            return Redirect::to('http://www.cartow.ie/applegreen-thanks.html');
        }


        return Redirect::back();
    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [
            'applegreen_code'=>'required',
            'vehicle_registration' => 'required',
            'fuel' => 'required',
            'colour' => 'required',
            'make' => 'required',
            'model' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'address_line_1' => 'required',
            'county' => 'required',
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
