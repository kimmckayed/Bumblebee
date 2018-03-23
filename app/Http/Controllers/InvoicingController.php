<?php

namespace App\Http\Controllers;


use App\DataModels\OrderDataModel;
use App\Enums\OrderStatuses;
use App\Managers\Billing\BillingManager;
use App\Managers\Billing\OfflinePayment;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Orders;
use DataEdit;
use DataGrid;
use DataFilter;
use Flash;
use Redirect;

class InvoicingController extends Controller
{

    public function getIndex()
    {

        $filter = DataFilter::source(new Orders());
        $filter->add('order_id', 'order  ID', 'text');

        $filter->add('date_added', 'order Date', 'daterange')->format('m/d/Y', 'en');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
        $grid = DataGrid::source($filter);
        $grid->add('order_id', 'Order_id', true)->style('width:100px');
        $grid->add('invoice_no', 'invoice_no');

        $grid->add('firstname', 'First Name');
        $grid->add('customer_id', 'customer');


        $grid->add('total', 'total');
        $grid->add('order_status_id', 'status');
        $grid->add('date_added|date[m/d/Y]', 'order Date');
        $grid->add('print', 'print');
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
            $row->cell('print')->value = link_to('invoicing/print/' . $row->cell('order_id')->value, "Print");

        });
        $grid->orderBy('order_id', 'asc');
        $grid->paginate(10);

        return view('layouts.master.main')
            ->nest('content', 'billing.index', compact('filter', 'grid'));
    }

    public function getEdit()
    {
        $edit = DataEdit::source(new Orders());
        $edit->add('order_id', 'Order_id', 'text');
        $edit->add('membership_id', 'Membership ID', 'text');
        $edit->add('title', 'Title', 'text');
        $edit->add('firstname', 'First Name', 'text');
        $edit->add('lastname', 'Last Name', 'text');
        $edit->add('email', 'Email', 'text');
        $edit->add('date_added|date[m/d/Y]', 'order Date', 'text');
        $edit->add('total', 'total', 'text');
        $edit->add('order_status_id', 'status', 'text');


        return view('layouts.master.main')
            ->nest('content', 'billing.index', compact('edit'));
    }

    public function getCreate($company_id)
    {


        $company = Company::with('company_poc', 'accounts_poc')->find($company_id);
        if (!$company) {
            Flash::error('No company Id');

            return Redirect::back();
        }
        $last_invoice = Orders::where('customer_id', '=', $company_id)->orderBy('order_id',
            'DESC')->first(['date_added']);
        $last_invoice_date = null;
        if ($last_invoice) {
            $last_invoice_date = $last_invoice->date_added;
        }

        $order_info = [

            'invoice_prefix' => 'MONTHLY',
            'customer_id' => $company->id,
            'firstname' => $company->company_poc->name,
            'email' => $company->company_poc->email,
            'telephone' => $company->company_poc->phone_number,
            'payment_firstname' => (isset($company->accounts_poc->name) ? $company->accounts_poc->name : $company->company_poc->name),
            'payment_company' => $company->name,
            'payment_address_1' => (isset($company->accounts_poc->adress) ? $company->accounts_poc->adress : $company->company_poc->adress),
            'comment' => "Generate invoice by finance user after $last_invoice_date",
            'total' => $company->total,
            'order_status_id' => OrderStatuses::accepted,
        ];
        $sold_memberships = Customer::with('vehicle', 'membership', 'adder', 'company');
        if ($last_invoice_date != null) {
            $sold_memberships = $sold_memberships->where('start_date', '>', $last_invoice_date);
        }
        $sold_memberships = $sold_memberships->get(['id', 'title', 'first_name', 'last_name', 'membership']);

        $order_data_model = new OrderDataModel($order_info);

        $billing_manager = new BillingManager();

        $billing_manager->placeOrder($order_data_model, $sold_memberships);


        $billing_manager->processPayment($order_data_model, new OfflinePayment());
        Flash::success('invoice created successfully');

        return Redirect::to('invoicing/print/' . $order_data_model->order_id);


    }

    public function  getPrint($id)
    {
        $order = Orders::find($id);
        return view('home.master.reports.invoice', ['order' => $order]);

    }
    public function  getGeneratePdfInvoice($hashed_id)
    {
        $user_id = intval($hashed_id,16);
        $order = Customer::with('user','vehicle','membership_detail','membership','company')->where('user_id',$user_id)->first();
        if(!$order){
            dd('no records');
        }
        return view('home.print.member_invoice', ['order' => $order]);

    }

}
