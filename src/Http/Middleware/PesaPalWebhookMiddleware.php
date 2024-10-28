<?php

namespace AllanDereal\PesaPal\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use AllanDereal\PesaPal\Concerns\ConstructsWebhookEvent;

class PesaPalWebhookMiddleware
{
    public function handle(Request $request, ?Closure $next = null)
    {
        $secret = config('services.stripe.webhooks.lunar');
        $stripeSig = $request->header('Stripe-Signature');

        try {
            $event = app(ConstructsWebhookEvent::class)->constructEvent(
                $request->getContent(),
                $stripeSig,
                $secret
            );
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }

        if (! in_array(
            $event->type,
            [
                'payment_intent.payment_failed',
                'payment_intent.succeeded',
            ]
        )) {
            return response('', 200);
        }

        return $next($request);
    }
}
