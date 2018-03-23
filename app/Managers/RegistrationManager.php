<?php namespace App\Managers;


use App\DataModels\CompanyDataModel;
use App\DataModels\MembershipDataModel;
use App\Enums\AccountTypes;
use App\Enums\PaymentMethod;
use App\Models\Agent;
use App\Models\Company;
use App\Models\CompanyPaymentMethod;
use App\Models\CompanyPOC;
use App\Models\Customer;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Log;
use Sentinel;
use App\DataModels\AgentDataModel;
use App\DataModels\UserDataModel;

class RegistrationManager
{
    /**
     * @param MembershipDataModel $membership_data_model
     * @param bool $bypass_automatic_notification
     * @param bool $bypass_email
     * @param bool $bypass_user_creation
     * @param \App\Models\User $user
     * @param string $type
     * @return bool|\Cartalyst\Sentinel\Users\UserInteface
     */

    public function createMembership(
        MembershipDataModel &$membership_data_model,
        $bypass_automatic_notification = false,
        $bypass_email = false,
        $bypass_user_creation = false,
        $user = null,
        $type = 'customer'
    ) {
        if(!$bypass_user_creation) {
            $credentials = [
                'email' => $membership_data_model->email,
                'password' => $membership_data_model->password,
                'first_name' => $membership_data_model->first_name,
                'last_name' => $membership_data_model->last_name,
                'username' => $membership_data_model->username,
                'account_type' => AccountTypes::customer
            ];
            $user = $this->createUser($credentials, 10);
            if (!$user) {
                return false;
            }
        }

        $membership_data_model->user_id = $user->id;

        $vehicle_id = $this->createVehicles($membership_data_model->make, $membership_data_model->model,
            $membership_data_model->version, $membership_data_model->engine_size, $membership_data_model->fuel,
            $membership_data_model->transmission, $membership_data_model->colour);
        $customer_id = $this->createCustomer($membership_data_model->company_id,
            $membership_data_model->title,
            $membership_data_model->first_name,
            $membership_data_model->last_name,
            $membership_data_model->email,
            $membership_data_model->address_line_1,
            $membership_data_model->address_line_2,
            $membership_data_model->town,
            $membership_data_model->county,
            $membership_data_model->postal_code,
            $membership_data_model->phone_number,
            $membership_data_model->nok_phone_number,
            $membership_data_model->vehicle_registration,
            $membership_data_model->have_nct,
            $membership_data_model->odometer_reading,
            $membership_data_model->odometer_type,
            $membership_data_model->membership,
            $membership_data_model->start_date,
            $membership_data_model->membership_expiration,
            $membership_data_model->added_by,
            $vehicle_id,
            $user->id,
            $type);

        if (!$bypass_automatic_notification && $membership_data_model->added_by !== false) {
            $added_by = User::whereId($membership_data_model->added_by)->first();
            if ($added_by->account_type === 4) {
                (new NotificationManager())->newMemberShipRegistrationByAgent($added_by, $membership_data_model,$bypass_email);
            } else {
                (new NotificationManager())->newMemberShipRegistrationByCarTow($membership_data_model,$bypass_email);
            }
        }
        if($type=='fleet') return $customer_id;

        return $user;
    }

    public function createCompany(CompanyDataModel $company_data_model)
    {
        $main_poc_id = CompanyPOC::insertGetId([
            'name' => $company_data_model->poc_name,
            'email' => $company_data_model->poc_email,
            'phone_number' => $company_data_model->poc_number
        ]);
        if($company_data_model->poc_email_2) {
            $accounts_poc_id = CompanyPOC::insertGetId([
                'name' => $company_data_model->poc_name_2,
                'email' => $company_data_model->poc_email_2,
                'phone_number' => $company_data_model->poc_number_2
            ]);
        } else {
            $accounts_poc_id = '';
        }
        if ($company_data_model->payment_method == PaymentMethod::offline) {
            $company_data_model->agent_data_model->user_data_model->status = 0;
        }
        $company_repository = new Company();
        $response = $company_repository->add(
            $company_data_model->code,
            $company_data_model->company_name,
            $company_data_model->website,
            $company_data_model->address,
            $company_data_model->memberships_json,
            $company_data_model->added_by,
            $main_poc_id,
            $accounts_poc_id,
            $company_data_model->agent_data_model->user_data_model->status
        );
        if ($response['error'] === 0) {
            (new CompanyPaymentMethod())->add(
                $response['account_id'],
                $company_data_model->payment_method,
                $company_data_model->payment_method_check
            );
        }
        $company_data_model->agent_data_model->user_data_model->account_type = AccountTypes::agent;

        $company_data_model->agent_data_model->user_data_model->first_name = $company_data_model->poc_name;
        $company_data_model->agent_data_model->user_data_model->email = $company_data_model->poc_email;
        $company_data_model->agent_data_model->phone_number = $company_data_model->poc_name;
        $company_data_model->agent_data_model->company_id = $response['account_id'];
        $company_data_model->agent_data_model->user_data_model->role = 9;

        $agent = $this->createAgent($company_data_model->agent_data_model);

        $email = new NotificationManager();
        $email->newCompanyRegistration($company_data_model);


        return $response;
    }

    /**
     * @param $credentials
     * @return bool|\Cartalyst\Sentinel\Users\UserInteface
     */
    public function createUser($credentials, $role_id = 10)
    {
        try {
            $user = Sentinel::registerAndActivate($credentials);
            unset($credentials['email'], $credentials['password']);
            foreach ($credentials as $key => $attribute) {
                $user->{$key} = $attribute;
            }
            $user->save();
            $this->addRoleToUser($user, $role_id);
            /*   unset($credentials['email']);
               unset($credentials['password']);
               foreach($credentials as $key => $attribute){
                   $user->{$key} = $attribute;
               }
               $user->save();*/
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }

        return $user;
    }

    private function addRoleToUser($user, $role_id)
    {
        $role = Sentinel::findRoleById($role_id);
        $role->users()->attach($user);

        return true;
    }

    public function createAgent(AgentDataModel $agent_data_model)
    {
        $credentials = [
            'email' => $agent_data_model->user_data_model->email,
            'password' => $agent_data_model->user_data_model->password,
            'first_name' => $agent_data_model->user_data_model->first_name,
            'last_name' => $agent_data_model->user_data_model->last_name,
            'username' => $agent_data_model->user_data_model->username,
            'account_type' => $agent_data_model->user_data_model->account_type,
            'status' => $agent_data_model->user_data_model->status
        ];
        $user = $this->createUser($credentials, $agent_data_model->user_data_model->role);
        if (!$user) {
            return false;
        }
        $agent_data_model->user_id = $user->id;
        $agent_data_model->added_by = Auth::user()->id;

        $agent = new Agent();
        $agent->add($agent_data_model);


        (new NotificationManager())->newAgentCreated($agent_data_model);

        return $agent;


    }

    public function createCustomer(
        $company_id,
        $title,
        $first_name,
        $last_name,
        $email,
        $address_line_1,
        $address_line_2,
        $town,
        $county,
        $postal_code,
        $phone_number,
        $nok_phone_number,
        $vehicle_registration,
        $have_nct,
        $odometer_reading,
        $odometer_type,
        $membership,
        $start_date,
        $membership_expiration,
        $added_by,
        $vehicle_id,
        $user_id,
        $type
    ) {
        $membership_id = 'M' . $vehicle_registration;
        $customer = new Customer();
        $customer->company_id = $company_id;
        $customer->user_id = $user_id;
        $customer->membership_id = $membership_id;
        $customer->title = $title;
        $customer->first_name = $first_name;
        $customer->last_name = $last_name;
        $customer->email = $email;
        $customer->address_line_1 = $address_line_1;
        $customer->address_line_2 = $address_line_2;
        $customer->town = $town;
        $customer->county = $county;
        $customer->postal_code = $postal_code;
        $customer->phone_number = $phone_number;
        $customer->nok_phone_number = $nok_phone_number;
        $customer->vehicle_registration = $vehicle_registration;
        $customer->have_nct = $have_nct;
        $customer->odometer_reading = $odometer_reading;
        $customer->odometer_type = $odometer_type;
        $customer->membership = $membership;
        $customer->start_date = $start_date;
        $customer->expiration_date = $membership_expiration.' 00:00:00';
        $customer->vehicle_id = $vehicle_id;
        $customer->added_by = $added_by;
        $customer->type = $type;
        $customer->save();

        return $customer->id;

    }

    /**
     * @param $make
     * @param $model
     * @param $version
     * @param $engine_size
     * @param $fuel
     * @param $transmission
     * @param $colour
     * @return int Vehicle_id |bool
     */
    public function createVehicles($make, $model, $version, $engine_size, $fuel, $transmission, $colour)
    {
        return DB::table('vehicles')->insertGetId([
            'make' => $make,
            'model' => $model,
            'version_type' => $version,
            'engine_size' => $engine_size,
            'fuel_type' => $fuel,
            'transmission' => $transmission,
            'colour' => $colour
        ]);

    }

    public function renewCustomerMembership($customer, $new_start_date, $new_membership_expiry)
    {
        return $customer->update(['start_date'=>$new_start_date,
            'expiration_date'=>$new_membership_expiry,'number_of_assists'=>0]);
    }
}