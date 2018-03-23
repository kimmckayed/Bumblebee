<?php namespace App\Managers\Billing;


use App\DataModels\OrderDataModel;
use App\Enums\OrderStatuses;
use App\Models\Membership;
use App\Models\OrderProduct;
use App\Models\Orders;
use Stripe\Charge;
use Stripe\Stripe;

class BillingManager
{
    /**
     * @var Orders
     */
    public $repo;

    function  __construct()
    {
        $this->repo = new Orders();
    }

    public function placeMembershipOrder(OrderDataModel $order_data_model)
    {
        $order_placement = $this->placeOrder($order_data_model);
        if (!$order_placement) {
            return false;
        }

        return $order_placement;

    }

    /**
     * @param $order_data_model
     * @param PaymentInterface $payment
     * @return bool|string
     */
    public function processPayment(OrderDataModel &$order_data_model, PaymentInterface $payment)
    {
        $payment_status = $payment->processPayment($order_data_model);
        if ($payment_status == OrderStatuses::failed) {
            $order_data_model->changeStatus(OrderStatuses::failed);
            $this->repo->changeStatus($order_data_model->order_id, OrderStatuses::failed);

            return false;
        }
        // order ssuccess
        $order_data_model->changeStatus(OrderStatuses::accepted);
        $this->repo->changeStatus($order_data_model->order_id, OrderStatuses::accepted);
        $order_data_model->payment_code = $payment->getPaymentCode();
        $this->repo->processPayment($order_data_model->order_id, $payment->getPaymentCode());

        return true;
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

    public function placeOrder(OrderDataModel &$order_data_model, $sold_memberships = null)
    {
        $static_order_id = mt_rand(1000000000, 10000000000);
        $total_amount = 0;
        if ($sold_memberships) {
            foreach ($sold_memberships as $membership) {

                $price = $this->getAmount($membership->membership);
                $total_amount += $price;
                $order_product = new OrderProduct();
                $order_product->order_id = $static_order_id;
                $order_product->product_id = $membership->membership;
                $order_product->name = $membership->membership_detail->membership_name;
                $order_product->quantity = 1;
                $order_product->price = $price;
                $order_product->total = $price;

                $order_product->save();


            }
            $order_data_model->total = $total_amount;
        }
        if (!$this->repo->newOrder($order_data_model)) {
            return false;
        }
        OrderProduct::where('order_id','=',$static_order_id)->update(['order_id'=>$order_data_model->order_id]);

        return true;

    }


}