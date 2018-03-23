<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Managers\AuthManager;
use App\Models\Activities;
use App\Models\Agent;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Orders;
use DataFilter;
use DateInterval;
use DateTime;
use DB;
use Input;
use ReflectionClass;
use Stripe;
use DataGrid;

// require_once(public_path()."\stripe-php\lib\Stripe.php");

class ReportsController extends Controller
{

    /**
     * @return mixed
     */
    public function getAgentsActivities()
    {


        $reflection = new ReflectionClass('App\Enums\ActivityTypes');
        $activity_types = (array_flip($reflection->getConstants()));
        $customers = Activities::with(['user', 'entryBy'])->orderBy('id','DESC');

        $filter = DataFilter::source($customers);
        $filter->add('activity_type_id', 'Activity type', 'select')->options($activity_types);
        $filter->add('created_at', 'Date ranges', 'daterange')->format('m/d/Y', 'en');
        $filter->submit('search', 'BL',
            ['class' => 'btn btn-primary form-btn', 'name' => 'submit', 'value' => 'download']);
        $filter->reset('reset');
        $filter->build();
        $grid = DataGrid::source($filter);
        $grid->add('activity_type_id', 'Activity type');
        $grid->add('user.first_name', 'user');
        $grid->add('note', 'Note');
        $grid->add('created_at|strtotime|date[m/d/Y]', 'Date', true);
        $grid->add('entryBy.first_name', 'entry by');
        $grid->row(function ($row) use ($activity_types) {
            $row->cell('activity_type_id')->value = $activity_types[$row->cell('activity_type_id')->value];
        });


        $grid->paginate(10);


        return view('home.master.reports.agents_activities',
            compact('grid', 'filter'));
    }

    /**
     * @return mixed
     */
    public function getMembershipsSold()
    {
        $company_id = Input::get('company_id');
        $last_invoice = Orders::where('customer_id', '=', $company_id)->orderBy('order_id',
            'DESC')->first(['date_added']);
        $last_invoice_date = null;
        if ($last_invoice) {
            $last_invoice_date = $last_invoice->date_added;
        }
        $customers = Customer::with('vehicle', 'membership', 'adder', 'company');
        if ($last_invoice_date != null) {

            $last_invoice_date = new DateTime($last_invoice_date);
            $last_invoice_date->add(new DateInterval('P3D'));

            $customers = $customers->where('start_date', '>', $last_invoice_date->format('Y-m-d H:i:s'));
        }

        $filter = DataFilter::source($customers);

        $filter->add('company_id', 'Company ID', 'select')->options(Company::lists('name', 'id'));


        $filter->submit('search');
        $filter->submit('download', 'BL',
            ['class' => 'btn btn-primary form-btn', 'name' => 'submit', 'value' => 'download']);
        $filter->reset('reset');
        $filter->build();

        $grid = DataGrid::source($filter);

        if (Input::get('submit', 'search') === 'download') {

            $grid = $this->getFieldsForDownload($grid);
        } else {

            $grid = $this->getFieldsForGrid($grid);
        }

        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');
        if (Input::get('submit', 'search') === 'download') {
            return $grid->buildCSV('MemberShips', 'Y-m-d.His');
        }
        $grid->paginate(20);

        return view('home.master.reports.memberships-sold', compact('filter', 'grid'));
    }

    private function getFieldsForGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {

        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('phone_number', 'Phone Number');
        $grid->add('membership.membership_name', 'Membership');
        $grid->add('membership_id', 'Membership ID', true);
        $grid->add('title', 'Title');
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('email', 'Email');
        $grid->add('start_date|date[m/d/Y]', 'Start Date');
        $grid->edit(url('/user/edit/customer'), 'Edit', 'show|modify');
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });

        return $grid;
    }

    /**
     * @param DataGrid|\Zofe\Rapyd\DataGrid\DataGrid $grid
     * @return DataGrid
     */
    private function getFieldsForDownload(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {
        //Form Name
        //Submission Date
        $grid->add('membership_id', 'CarTow Membership ID', true);
        $grid->add('company.name', 'Company or Dealership Name');
        //Agent Full Name
        $grid->add('adder.username', 'Member&#039;s Full Name');
        $grid->add('email', 'Member&#039;s E-mail');
        $grid->add('address_line_1', 'Member&#039;s Address');
        $grid->add('phone_number', 'Member&#039;s Phone Number');
        //Preffered next of kin Phone Number
        //Odometer Reading
        //Odometer Type
        //Tax renewal date (optional for friendly reminders)
        //NCT renewal date (optional for friendly reminders)
        $grid->add('membership.membership_name', 'Membership Type', 'text');
        $grid->add('start_date|date[m/d/Y]', 'Start date for cover');
        $grid->add('expiration_date|date[m/d/Y]', 'End date for cover');
        //Receipt of member payment received by agent
        //  	Verification
        //Receipt of member payment received by agent
        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('title', 'Title');
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('status', 'Status');
        $grid->add('number_of_assists', 'Number of Assists');
        $grid->row(function ($row) {
            if ($row->cell('adder.username')->value === '{{$adder->username}}') {
                $row->cell('adder.username')->value = 'Online';
            }

//                        $row->cell('checkbox')->value = '<input type="checkbox" name="" id="" />';

            if ($row->cell('company.name')->value === '{{$company->name}}') {
                $row->cell('company.name')->value = '-';
            }

            if (strtotime($row->cell('expiration_date')->value) < time()) {
                $row->style('color:#FF0000');
                $row->cell('status')->value = 'Expired';
            } else {
                $row->cell('status')->value = 'Active';
            }

        });


        return $grid;
    }

    /**
     * @return mixed
     */
    private function getCompanyIDOrNull()
    {
        $company_id = Agent::where('user_id', '=', Auth::user()->id)->pluck('company_id');

        return $company_id;

    }
}