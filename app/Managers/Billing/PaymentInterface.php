<?php namespace App\Managers\Billing;


use App\DataModels\OrderDataModel;

interface PaymentInterface{
    /**
     * @param OrderDataModel $order_data_model
     * @return bool|string
     */
    public function processPayment(OrderDataModel &$order_data_model);
    public function getPaymentCode();
    public function setPaymentCode($payment_code);
}