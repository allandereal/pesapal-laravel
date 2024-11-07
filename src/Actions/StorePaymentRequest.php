<?php

namespace AllanDereal\PesaPal\Actions;

use AllanDereal\PesaPal\Models\PesaPalOrderRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StorePaymentRequest
{
    /**
     * @throws Exception
     */
    public function store(array $data): PesaPalOrderRequest
    {
        try {
            DB::beginTransaction();

            $billingAddress = config('pesapal.billing_address_model')::firstOrCreate(
                ['email_address' => request()->user()->email],
                [
                    ...array_filter($data['billing_address'], fn($item) => filled($item)),
                    'user_id' => request()->user()->id
                ]
            );

            $orderRequest = PesaPalOrderRequest::create([
                ...$data,
                'response_data' => $data,
                'status_check_data' => null,
                'billing_address_id' => $billingAddress->id,
                'status' => null
            ]);

            DB::commit();
        } catch (Exception $e) {
            Log::error('Error Storing Payment Request: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }

        return $orderRequest;
    }
}
