<?php namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyPaymentMethod extends Model
{

    protected $table = 'company_payment_method';
    protected $fillable = ['company_id', 'payment_method_id', 'status'];

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'company_id', 'id');
    }

    public function getByCompanyId($company_id)
    {
        $payment_method_id = CompanyPaymentMethod::where(
            'company_id', '=', $company_id)
            ->where('status', '=', PaymentMethod::active)
            ->pluck('payment_method_id');
        if ($payment_method_id) {
            return (int)$payment_method_id;
        }

        return PaymentMethod::online;

    }

    public function add($company_id, $payment_method, $status=1)
    {
        if (CompanyPaymentMethod::create([
            'company_id' => $company_id,
            'payment_method_id' => $payment_method,
            'status' => $status
        ])
        ) {
            return true;
        }

        return false;

    }

    public function getNameByCompanyId($companyId)
    {
        $payment_method = CompanyPaymentMethod::where('company_id', $companyId)
            ->first([DB::raw('(SELECT name FROM payment_methods WHERE id = payment_method_id) as name')]);
        if ($payment_method !== null) {
            return $payment_method->name;
        }

        return 'not set yet';
    }

    public function getNameById($payment_method_id)
    {
        $payment_method = DB::table('payment_methods')->whereId($payment_method_id)
            ->first(['name']);
        if ($payment_method !== null) {
            return $payment_method->name;
        }

        return 'not found';
    }

}
