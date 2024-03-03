<?php

namespace App\Http\Repositories\Stripe;
use Stripe\Webhook;

class WebhookRepository extends Webhook
{
    public function webhookConstructEvent(string $payload, string $signature, string $endpoint)
    {
        return $this->constructEvent($payload, $signature, $endpoint);
    }
}