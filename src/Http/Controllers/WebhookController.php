<?php

namespace AllanDereal\PesaPal\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use AllanDereal\PesaPal\Concerns\ConstructsWebhookEvent;
use AllanDereal\PesaPal\Jobs\ProcessPesaPalWebhook;
use AllanDereal\PesaPal\Models\PesaPalTransaction;

final class WebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
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
            Log::error(
                $error = $e->getMessage()
            );

            return response()->json([
                'webhook_successful' => false,
                'message' => $error,
            ], 400);
        }

        $paymentIntent = $event->data->object->id;
        $orderId = $event->data->object->metadata?->order_id;

        // Is this payment intent already being processed?
        $paymentIntentModel = PesaPalTransaction::where('intent_id', $paymentIntent)->first();

        if (! $paymentIntentModel?->processing_at) {
            $paymentIntentModel?->update([
                'event_id' => $event->id,
            ]);
            ProcessPesaPalWebhook::dispatch($paymentIntent, $orderId)->delay(
                now()->addSeconds(5)
            );
        }

        return response()->json([
            'webhook_successful' => true,
            'message' => 'Webook handled successfully',
        ]);
    }
}
