<?php namespace App\Managers;


use App\Enums\PaymentMethod;
use App\Models\CompanyPaymentMethod;
use App\Models\Membership;
use Exception;
use Log;
use Stripe\Charge;
use Stripe\Stripe;

class BillingManager
{

    public $discount = 0;
    public $payment_return = [];
    public $error = false;

    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function placeMembershipOrder($company_id, $customer_id, $membership_code)
    {

    }

    public function processPayment($company_id, $membership)
    {
        $payment_method = (new CompanyPaymentMethod())->getByCompanyId($company_id);
        if (!$payment_method) {
            return false;
        }


        if ($payment_method === PaymentMethod::online) {
            return $this->processOnlinePayment($membership);
        } elseif ($payment_method === PaymentMethod::offline) {
            return $this->processOfflinePayment();
        }

        return false;
    }

    public function processOfflinePayment()
    {
        return true;
    }

    public function processOnlinePayment($membership)
    {
        if ($this->getPriceAndChargeCard($membership)) {
            return true;
        }

        return false;
    }

    /**
     * @param $membership $membership_id
     * @return int
     */
    public function getPriceAndChargeCard($membership)
    {
        $amount = $this->getAmount($membership);
        /*
         * applying  discount
         */

        $amount -= ($amount * ($this->discount / 100));

        return $this->chargeCardWith($amount);

    }

    /**
     * @param $amount
     * @return bool
     */
    private function chargeCardWith($amount)
    {
        Stripe::setApiKey(env('stripe_key', 'sk_live_sz2A85JU9QcZPcjVYwfBPnza'));
        try {
            if (!isset($_POST['stripeToken'])) {
                throw new Exception('The Stripe Token was not generated correctly');
            }
            if ($amount > 0) {
                $charge = Charge::create(array(
                    'amount' => $amount,
                    'currency' => 'eur',
                    'card' => $_POST['stripeToken']
                ));
                if ($charge) {
                    $this->payment_return = $charge->__toArray();
                }

            } else {
                $this->payment_return = [
                    'amount' => $amount,
                    'currency' => 'eur',
                    'card' => $_POST['stripeToken']
                ];
            }


            return true;
        } catch (Exception $e) {
            Log::error($e);
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * @param $membership
     * @return int
     */
    private function getAmount($membership)
    {
        $membership_repository = new Membership();
        $item = $membership_repository->getMembership($membership);
        $amount = (float)($item['price']) * 100;

        return $amount;
    }

}