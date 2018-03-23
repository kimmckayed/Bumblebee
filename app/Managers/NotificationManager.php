<?php namespace App\Managers;


use App\DataModels\AgentDataModel;
use App\DataModels\CompanyDataModel;
use App\DataModels\MembershipDataModel;
use App\Enums\AccountTypes;
use App\Models\Agent;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotificationManager
{

    public function newCompanyRegistration(CompanyDataModel $company_data_model)
    {

        $notification = new Notification();
        $notification->newMasterNotifications("A company account for {$company_data_model->company_name} was created successfully");

        Mail::send('emails.registration_email', [
            'name' => $company_data_model->poc_name,
            'username' => $company_data_model->agent_data_model->user_data_model->username,
            'password' => $company_data_model->agent_data_model->user_data_model->password,
            'show_monthly_bill_text' => ($company_data_model->payment_method == 2)
        ],
            function ($message) use ($company_data_model) {
                $message->from('no-reply@cartow.ie', 'Cartow');
                $message->to($company_data_model->poc_email,
                    $company_data_model->company_name)->subject($company_data_model->poc_name . ', New CarTow account');
            if($company_data_model->poc_email_2){
                $message->to($company_data_model->poc_email_2,
                    $company_data_model->company_name)->subject($company_data_model->poc_name_2 . ', New CarTow account');
            }

                $message->cc('ken.morgan@cartow.ie', 'New CarTow account');
                $message->cc('rob.ingham@cartow.ie', 'New CarTow account');
                if ($company_data_model->payment_method == 2) {
                    $message->attach(public_path('uploads/attachments/Credit Facility Application Form Compatible Version Cartow ie.pdf'));
                    $message->attach(public_path('uploads/attachments/SEPA DIRECT DEBIT MANDATE.pdf'));
                }

            });


    }

    public function newMemberShipRegistration(MembershipDataModel $membership_data_model)
    {

        $notification = new Notification();
        $notification->newMasterNotifications("{$membership_data_model->first_name} was added successfully as a customer_repository through the CarTow.ie Membership form");

        Mail::send('emails.memberships_registration_by_users', [
            'user_id' => $membership_data_model->user_id,
            'title' => $membership_data_model->title,
            'last_name' => $membership_data_model->last_name,
            'first_name' => $membership_data_model->first_name,
            'vehicle_registration' => $membership_data_model->vehicle_registration,
            'make' => $membership_data_model->make,
            'model' => $membership_data_model->model,
            'start_date' => $membership_data_model->start_date
        ],
            function ($message) use ($membership_data_model) {
                $message->from('no-reply@cartow.ie', 'Cartow');
                $message->to($membership_data_model->email,
                    $membership_data_model->first_name)->subject('New CarTow Membership');
                $message->cc('ken.morgan@cartow.ie', 'New CarTow Membership');
                $message->cc('rob.ingham@cartow.ie', 'New CarTow Membership');
            });


    }

    public function newMemberShipRegistrationByAgent(User $user, MembershipDataModel $membership_data_model, $bypass_email)
    {
        $notification = new Notification();
        $notification->newNotification($user->id,
            "{$membership_data_model->first_name} was added successfully as a customer");

        $agent = (new Agent())->getByAccountId($user->account_id);

        $notification->newMasterNotifications("{$membership_data_model->first_name} was added successfully as a customer by {$user->username}");

        if(!$bypass_email) {
            Mail::send('emails.memberships_registration_by_agent', [
                'agent' => $agent,
                'user_id' => $membership_data_model->user_id,
                'title' => $membership_data_model->title,
                'last_name' => $membership_data_model->last_name,
                'first_name' => $membership_data_model->first_name,
                'vehicle_registration' => $membership_data_model->vehicle_registration,
                'make' => $membership_data_model->make,
                'model' => $membership_data_model->model,
                'start_date' => $membership_data_model->start_date
            ],
            function ($message) use ($membership_data_model) {
                $message->from('no-reply@cartow.ie', 'Cartow');
                $message->to($membership_data_model->email,
                    $membership_data_model->first_name)->subject('New CarTow Membership');
                $message->cc('ken.morgan@cartow.ie', 'New CarTow Membership');
                $message->cc('rob.ingham@cartow.ie', 'New CarTow Membership');
            });
        }
    }

    public function newMemberShipRegistrationByCarTow(MembershipDataModel $membership_data_model, $bypass_email)
    {
        $notification = new Notification();
        $notification->newMasterNotifications("{$membership_data_model->first_name} was added successfully as a customer ");

        if(!$bypass_email) {
            Mail::send('emails.memberships_registration_cartow_system', [
                'user_id' => $membership_data_model->user_id,
                'title' => $membership_data_model->title,
                'last_name' => $membership_data_model->last_name,
                'first_name' => $membership_data_model->first_name,
                'vehicle_registration' => $membership_data_model->vehicle_registration,
                'make' => $membership_data_model->make,
                'model' => $membership_data_model->model,
                'start_date' => $membership_data_model->start_date
            ],
            function ($message) use ($membership_data_model) {
                $message->from('no-reply@cartow.ie', 'Cartow');
                $message->to($membership_data_model->email,
                    $membership_data_model->first_name)->subject('New CarTow Membership');
                $message->cc('ken.morgan@cartow.ie', 'New CarTow Membership');
                $message->cc('rob.ingham@cartow.ie', 'New CarTow Membership');
            });
        }
    }

    public function newAgentCreated(AgentDataModel $agent_data_model)
    {
        $notification = new Notification();
        $notification->newNotification($agent_data_model->user_id,
            "An agent account for {$agent_data_model->user_data_model->first_name} {$agent_data_model->user_data_model->last_name} was created successfully");
        $added_by = User::whereId($agent_data_model->added_by)->first();
        if($added_by->account_type ===  AccountTypes::master){

            $notification->newMasterNotifications("An agent account for {$agent_data_model->user_data_model->first_name} was added successfully by {$added_by->first_name}");

        }

        Mail::send('emails.new_agent_created', [
            'first_name' => $agent_data_model->user_data_model->first_name,
            'username' => $agent_data_model->user_data_model->username,
            'password' => $agent_data_model->user_data_model->password,

        ],
            function ($message) use ($agent_data_model) {
                $message->from('no-reply@cartow.ie', 'Cartow');
                $message->to($agent_data_model->user_data_model->email,
                    $agent_data_model->user_data_model->first_name)->subject('New CarTow Agent Account');
                $message->cc('ken.morgan@cartow.ie', 'New CarTow Agent Account');
                $message->cc('rob.ingham@cartow.ie', 'New CarTow Agent Account');
            });


    }

}