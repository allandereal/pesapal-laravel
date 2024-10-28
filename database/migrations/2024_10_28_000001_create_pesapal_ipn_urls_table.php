<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('pesapal.table_prefix').'ipn_urls', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->timestamp('created_date')->nullable();
            $table->uuid('ipn_id')->index();
            $table->integer('notification_type');
            $table->string('ipn_notification_type_description');
            $table->integer('ipn_status');
            $table->string('ipn_status_decription');
            $table->text('error')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('pesapal.table_prefix').'ipn_urls');
    }
};
