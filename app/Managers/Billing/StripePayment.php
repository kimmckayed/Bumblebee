<?php namespace App\Managers\Billing;

use App\DataModels\OrderDataModel;
use App\Enums\OrderStatuses;
use App\Models\Orders;
use Exception;
use Log;
use Stripe\Charge;
use Stripe\Stripe;

class StripePayment implements PaymentInterface
{

    private $payment_code;

    public function processPayment(OrderDataModel &$order_data_model)
    {
        $payment_code = $this->getPriceAndChargeCard($order_data_model->total);
        if (!$payment_code) {
            return false;
        }

        return $payment_code;
    }

    /**
     * @param $membership $membership_id
     * @return int
     */
    public function getPriceAndChargeCard($amount)
    {
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
            if ($amount <= 0) {
                return false;
            }
            $payment = Charge::create(array(
                'amount' => $amount,
                'currency' => 'eur',
                'card' => $_POST['stripeToken']
            ));
            if (!$payment) {
                return OrderStatuses::failed;
            }
            $this->setPaymentCode($payment->id);

            return OrderStatuses::accepted;

        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }

    public function getPaymentCode()
    {
        return $this->payment_code;
    }

    public function setPaymentCode($payment_code)
    {
        $this->payment_code = $payment_code;
    }
}