<?php

namespace AllanDereal\PesaPal\Http\Controllers;

use AllanDereal\PesaPal\Facades\PesaPal;
use AllanDereal\PesaPal\Models\PesaPalOrderRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

final class WebhookController extends Controller
{
    public function webhook(Request $request): RedirectResponse
    {
        try {
            $this->checkOrderRequestStatus($request);
        } catch (Exception $e) {
            //
        }

        return redirect(config('pesapal.redirect_path'));
    }

    public function ipn(Request $request): JsonResponse
    {
        try {
            $this->checkOrderRequestStatus($request);
        } catch (Exception $e) {
            return response()->json(['status' => 500]);
        }

        return response()->json([
            'orderNotificationType' => 'IPNCHANGE',
            'orderTrackingId' => $request->OrderTrackingId,
            'orderMerchantReference' => $request->OrderMerchantReference,
            'status' => 200
        ]);
    }

    /**
     * @throws Exception
     */
    protected function checkOrderRequestStatus(Request $request): void
    {
        $request->validate([
            'OrderTrackingId' => 'required',
            'OrderMerchantReference' => 'required', //TODO: validate exists in the DB
        ]);

        try {
            $response = PesaPal::getOrderRequestStatus($request->OrderTrackingId);
        } catch (Exception $e) {
            Log::error($message = 'Error fetching pesapal order request: '. $e->getMessage());
            throw new Exception($message);
        }

        if($orderRequest = PesaPalOrderRequest::firstWhere('merchant_reference', $request->OrderMerchantReference)){
            $orderRequest->update([
                'status' => $response['status_code'],
                'status_check_data' => is_null($orderRequest->status_check_data) ? [$response] : [...$orderRequest->status_check_data, $response]
            ]);
        }

        //TODO: dispatch job to notify of status change
    }
}
