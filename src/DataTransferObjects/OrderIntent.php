<?php

namespace AllanDereal\PesaPal\DataTransferObjects;

use AllanDereal\PesaPal\Models\Order;
use Stripe\PaymentIntent;

class OrderIntent
{
    public function __construct(
        public Order $order,
        public PaymentIntent $paymentIntent
    ) {}
}
