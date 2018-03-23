<?php namespace App\Managers\Billing;

use App\DataModels\OrderDataModel;

class OfflinePayment implements PaymentInterface{



    public function processPayment(OrderDataModel &$order_data_model)
    {
        // TODO: Implement processPayment() method.
    }

    public function getPaymentCode()
    {
        // TODO: Implement getPaymentCode() method.
    }

    public function setPaymentCode($payment_code)
    {
        // TODO: Implement setPaymentCode() method.
    }
}