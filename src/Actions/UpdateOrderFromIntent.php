<?php

namespace AllanDereal\PesaPal\Actions;

use Illuminate\Support\Facades\DB;
use AllanDereal\PesaPal\Models\Order;
use AllanDereal\PesaPal\Facades\PesaPal;
use Stripe\PaymentIntent;

class UpdateOrderFromIntent
{
    final public static function execute(
        Order $order,
        PaymentIntent $paymentIntent,
        string $successStatus = 'paid',
        string $failStatus = 'failed'
    ): Order {
        return DB::transaction(function () use ($order, $paymentIntent) {

            $charges = PesaPal::getCharges($paymentIntent->id);

            $order = app(StoreCharges::class)->store($order, $charges);
            $requiresCapture = $paymentIntent->status === PaymentIntent::STATUS_REQUIRES_CAPTURE;

            $statuses = config('lunar.stripe.status_mapping', []);

            $placedAt = null;

            if ($paymentIntent->status === PaymentIntent::STATUS_SUCCEEDED) {
                $placedAt = now();
            }

            if ($charges->isEmpty() && ! $requiresCapture) {
                return $order;
            }

            if (config('lunar.stripe.sync_addresses', true) && $paymentIntent->payment_method) {
                (new StoreAddressInformation)->store($order, $paymentIntent);
            }

            $order->update([
                'status' => $statuses[$paymentIntent->status] ?? $paymentIntent->status,
                'placed_at' => $order->placed_at ?: $placedAt,
            ]);

            return $order;
        });
    }
}
