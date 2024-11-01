<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('pesapal.table_prefix').'order_requests', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->double('amount');
            $table->string('merchant_reference');
            $table->string('order_tracking_id');
            $table->text('description')->nullable();
            $table->string('callback_url');
            $table->string('notification_id');
            $table->foreignId('billing_address_id')
                ->constrained(config('pesapal.table_prefix') . app(config('pesapal.billing_address_model'))->getTable(), 'id');
            $table->json('response_data')->nullable();
            $table->json('status_check_data')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('pesapal.table_prefix').'order_requests');
    }
};
