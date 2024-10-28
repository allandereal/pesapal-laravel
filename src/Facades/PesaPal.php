<?php

namespace AllanDereal\PesaPal\Facades;

use Illuminate\Support\Facades\Facade;
use AllanDereal\PesaPal\Models\Cart;
use AllanDereal\PesaPal\Enums\CancellationReason;
use AllanDereal\PesaPal\MockClient;
use Stripe\ApiRequestor;

/**
 * @method static getClient(): \Stripe\StripeClient
 * @method static getCartIntentId(Cart $cart): ?string
 * @method static fetchOrCreateIntent(Cart $cart, array $createOptions): ?string
 * @method static createIntent(\AllanDereal\PesaPal\Models\Cart $cart, array $createOptions): \Stripe\PaymentIntent
 * @method static syncIntent(\AllanDereal\PesaPal\Models\Cart $cart): void
 * @method static updateIntent(\AllanDereal\PesaPal\Models\Cart $cart, array $values): void
 * @method static cancelIntent(\AllanDereal\PesaPal\Models\Cart $cart, CancellationReason $reason): void
 * @method static updateShippingAddress(\AllanDereal\PesaPal\Models\Cart $cart): void
 * @method static getCharges(string $paymentIntentId): \Illuminate\Support\Collection
 * @method static getCharge(string $chargeId): \Stripe\Charge
 * @method static buildIntent(int $value, string $currencyCode, \AllanDereal\PesaPal\Models\CartAddress $shipping): \Stripe\PaymentIntent
 */
class PesaPal extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return 'allandereal:pesapal';
    }

    public static function fake(): void
    {
        $mockClient = new MockClient;
        ApiRequestor::setHttpClient($mockClient);
    }
}
