<?php

namespace App\Http\Services\Stripe;

use App\Http\Repositories\Stripe\WebhookRepository;

class WebhookService
{
    public function __construct(
        private WebhookRepository $webhookRepository
    ){}

    public function constructEvent(string $payload, string $signature, string $endpoint)
    {
        return $this->webhookRepository->webhookConstructEvent($payload, $signature, $endpoint);
    }

    public function getPaymentStatus()
    {
        
    }
}