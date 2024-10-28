<?php

namespace AllanDereal\PesaPal\Pipelines;

use AllanDereal\PesaPal\DataTransferObjects\OrderIntent;

class UpdateOrderFromCharges
{
    public function handle(OrderIntent $orderIntent, \Closure $next) {}
}
