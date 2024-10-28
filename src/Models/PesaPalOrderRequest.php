<?php

namespace AllanDereal\PesaPal\Models;

use Illuminate\Database\Eloquent\Model;

class PesaPalOrderRequest extends Model
{
    public function getTable(): string
    {
        return config('pesapal.table_prefix') . 'order_request';
    }

    protected $guarded = [];
}