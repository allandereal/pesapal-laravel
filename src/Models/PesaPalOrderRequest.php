<?php

namespace AllanDereal\PesaPal\Models;

use AllanDereal\PesaPal\Enums\StatusCode;
use Illuminate\Database\Eloquent\Model;

class PesaPalOrderRequest extends Model
{
    public function getTable(): string
    {
        return config('pesapal.table_prefix') . 'order_requests';
    }

    protected $fillable = [
        "merchant_reference",
        "currency",
        "amount",
        "description",
        "callback_url",
        "notification_id",
        "billing_address_id",
        "response_data",
        "status_check_data",
        "status",
        "created_at",
        "updated_at",
        "order_tracking_id",
    ];

    protected $casts = [
        'response_data' => 'object',
        'status_check_data' => 'object',
        'status' => StatusCode::class,
    ];
}