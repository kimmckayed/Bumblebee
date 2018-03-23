<?php namespace App\Managers;


use App\Enums\ActivityTypes;
use App\Models\Activities;

class ActivityManager
{
    protected $entry_by = null;

    public function __construct()
    {
        $user = (new AuthManager())->getUser();
        if ($user) {
            $this->entry_by = $user->id;
        }

    }

    public function userLogin($user_id, $note)
    {
        $this->addActivity(ActivityTypes::user_login, $user_id, $note);
    }

    public function userLogout($user_id, $note)
    {
        $this->addActivity(ActivityTypes::user_logout, $user_id, $note);
    }

    public function addMember($user_id, $note)
    {
        $this->addActivity(ActivityTypes::add_member, $user_id, $note);
    }
    public function pyPassedPayment($user_id, $note)
    {
        $this->addActivity(ActivityTypes::py_passed_payment, $user_id, $note);
    }
    public function pyPassedNotification($user_id, $note)
    {
        $this->addActivity(ActivityTypes::py_passed_notification, $user_id, $note);
    }
    public function paymentCompleted($user_id, $note)
    {
        $this->addActivity(ActivityTypes::payment_completed, $user_id, $note);
    }

    public function addAgent($user_id, $note)
    {
        $this->addActivity(ActivityTypes::add_agent, $user_id, $note);
    }

    public function addCompany($user_id, $note)
    {
        $this->addActivity(ActivityTypes::add_company, $user_id, $note);
    }

    public function addCallOutService($user_id, $note)
    {
        $this->addActivity(ActivityTypes::add_call_out_service, $user_id, $note);
    }

    public function renewMembership($user_id, $note)
    {
        $this->addActivity(ActivityTypes::renew_membership, $user_id, $note);
    }

    private function addActivity($type, $user_id, $note)
    {
        $activity = new Activities();

        $activity->activity_type_id = $type;

        $activity->user_id = $user_id;

        $activity->note = $note;
        $activity->entry_by = $this->entry_by;
        $activity->created_at = time();
        $activity->updated_at = time();
        $activity->save();
    }


}