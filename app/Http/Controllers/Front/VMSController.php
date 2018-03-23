<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use DB;
use App\DataModels\MembershipDataModel;
use App\Http\Controllers\Controller;
use App\Managers\RegistrationManager;
use App\Models\Customer;
use App\Models\Membership;
use Illuminate\Http\Request;
use Input;
use Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class VMSController extends Controller
{
    public function postIndex(Request $request)
    {
        $check_token = 'kjhkhk213kjlghsfkmo';
        if (!$request->get('token')) {
            return new JsonResponse('Authorization not granted');
        } else {
            if ($request->get('token') !== $check_token) {
                return new JsonResponse('Authorization token mismatch');
            }
        }
        if($request->get('membership')=='0'){
            $full_name = $this->split_name($request->get('name'));
            $id = DB::table('customers_trial')->insertGetId(
                ['first_name' => $full_name[0], 'last_name' => $full_name[1],
                    'address_line' => $request->get('address_line_1'),
                    'start_date' => $request->get('start_date'),
                    'expiration_date' => $request->get('membership_expiration'),
                    'myvehicle_ref' => $request->get('reference_no'),
                    'created_at' => Carbon::now()->toDateTimeString()]
            );
            if($id){
                return new JsonResponse(array(
                    'message' => 'Trial Customer was added successfully',
                    'User' => array(
                        'id' => $id,
                        'first name' => $full_name[0],
                        'last name' => $full_name[1]
                    )
                ), 200);
            } else {
                return new JsonResponse('Trial cover customer couldn\'t be inserted successfully', 500);
            }
        } else {
            if (($validation_message_bag = $this->validateForm()) !== true) {
                return new JsonResponse($validation_message_bag);
            }
            $request->merge(['membership_type' => Membership::where('membership_name', 'like', 'vms')->pluck('id')]);
            $full_name = $this->split_name($request->get('name'));
            $request->merge(['first_name' => $full_name[0],'last_name' => $full_name[1]]);
            $membership_data_model = new MembershipDataModel($request,
                ['company_id' => 39, 'added_by' => 248]);

            $registration_manager = new RegistrationManager();
            $user = $registration_manager->createMembership($membership_data_model,false,true);
            if ($user) {
                $customer = Customer::where('user_id','=',$user->id)->first();
                $customer->memberCompleted($customer->id);

                return new JsonResponse(array(
                    'message' => 'User was added successfully',
                    'User' => array(
                        'id' => $user->id,
                        'email' => $user->email,
                        'first name' => $user->first_name,
                        'last name' => $user->last_name
                    )
                ), 200);
            }
        }

        return new JsonResponse('Reached end of function', 200);
    }
    private function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }
    private function validateForm()
    {
        /**
         * Regisration number => vehicle_registration,
         * Odemeter reading => odometer_reading,
         * Odometer type =>odometer_type ,\
         * Customer name => first_name   , last_name ,
         * Customer address => address_line_1 , address_line_2,
         * Customer email => email,
         * Customer mobile no => phone_number,
         * Start date,
         * End date,
         * Price ex VAT
         */
        $validator = Validator::make(Input::all(), [
            'vehicle_registration' => 'required',
            'fuel' => 'required',
            'colour' => 'required',
            'make' => 'required',
            'model' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'address_line_1' => 'required',
            'phone_number' => 'required',
            'odometer_reading' => 'required',
            'odometer_type' => 'required',
            'start_date' => 'required',
            'membership_expiration' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }


}
