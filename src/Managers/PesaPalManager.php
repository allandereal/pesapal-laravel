<?php

namespace AllanDereal\PesaPal\Managers;

use AllanDereal\PesaPal\DataTransferObjects\PesaPalConfig;
use AllanDereal\PesaPal\Enums\ApiEndpoint;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PesaPalManager
{
    protected ?PesaPalConfig $config = null;
    public function __construct()
    {
        $this->config = new PesaPalConfig();
    }

    protected function initRequest(): void
    {
        //
    }

    public function getToken(): string
    {
        return Cache::remember('pesapal_token', 270, function () { //4.5 minutes
            $response = Http::acceptJson()
                ->asJson()
                ->post(
                    url: $this->config->getBaseUrl().ApiEndpoint::REQUEST_TOKEN->value,
                    data: [
                        'consumer_key' => $this->config->getConsumerKey(),
                        'consumer_secret' => $this->config->getConsumerSecret(),
                    ],
                );

            if ($response->successful()) {
                return  $response->object()?->token;
            }

            throw new Exception('Unable to retrieve token');
        });
    }

    public function registerIpn(string $url, string $notificationType = 'GET'): array
    {
        $response = Http::asJson()
            ->acceptJson()
            ->withToken($this->getToken())
            ->post(
                url: $this->config->getBaseUrl().ApiEndpoint::REGISTER_IPN->value,
                data: [
                    'url' => $url,
                    'ipn_notification_type' => $notificationType,
                ],
        );

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Unable to create IPN');
    }

    /**
     * @throws ConnectionException
     */
    public function getIpnList(): array
    {
        $response = Http::asJson()
            ->acceptJson()
            ->withToken($this->getToken())
            ->get(
                url: $this->config->getBaseUrl().ApiEndpoint::LIST_IPNS->value,
            );

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Unable to retrieve ipn list');
    }

    /**
     * @throws ConnectionException
     *
     * @return array ['request'=>[], 'response'=>[]]
     */
    public function submitOrderRequest(array $payload): array
    {
        //TODO: validate payload. (make sure some required values are set.)
        $response = Http::asJson()
            ->acceptJson()
            ->withToken($this->getToken())
            ->post(
                url: $this->config->getBaseUrl().ApiEndpoint::CREATE_PAYMENT_REQUEST->value,
                data: $data = [
                    'id' => $payload['order_id'] ?? Str::random(32),
                    'currency' => $payload['currency'] ?? 'UGX',
                    'amount' => $payload['amount'],
                    'description' => $payload['description'] ?? config('app.name').' Collection',
                    'callback_url' => $this->config->getWebhookUrl(),
                    'notification_id' => $payload['notification_id'] ?? $this->config->getIpnId(),
                    'billing_address' => $payload['billing_address'] ?? [
                        'email_address' => 'email@example.com',
                        'phone_number' => '',
                        'country_code' => '',
                        'first_name' => '',
                        'middle_name' => '',
                        'last_name' => '',
                        'line_1' => '',
                        'line_2' => '',
                        'city' => '',
                        'state' => '',
                        'postal_code' => '',
                        'zip_code' => ''
                    ]
                ],
            );

        if ($response->successful()) {
            return [$data, $response->json()];
        }

        throw new Exception('Unable to create Order Request');
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function getOrderRequestStatus(string $orderTrackingId): array
    {
        $response = Http::asJson()
            ->acceptJson()
            ->withToken($this->getToken())
            ->get(
                url: $this->config->getBaseUrl().ApiEndpoint::GET_PAYMENT_REQUEST->value,
                query: [
                    'orderTrackingId' => $orderTrackingId
                ]
            );

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Unable to retrieve order request status');
    }
}
