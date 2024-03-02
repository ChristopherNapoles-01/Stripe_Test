<?php

namespace App\Http\Services\Stripe;

use App\Http\Repositories\Stripe\StripeSessionRepository;

class StripeSessionService
{
    public function __construct(
        private StripeSessionRepository $stripeSessionRepository
    ){}

    public function updateSessionBySessionId(string $sessionId)
    {
        return $this->stripeSessionRepository->updateStripeSession(
            [
                'session_id' => $sessionId
            ],
            [
                'session_status' => 'paid'
            ]
        );
    }
}