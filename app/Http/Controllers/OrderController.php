<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Orders\OrdersService;
use App\Http\Services\Stripe\StripeService;
use App\Http\Services\Stripe\WebhookService;

class OrderController extends Controller
{
    public function __construct(
        private OrdersService $orderService,
        private WebhookService $webhookService,
        private StripeService $stripeService
    ){}
    public function updateOrderStatusViaWebhook(Request $request)
    {
        $endPoint = config('stripe.webHookKey');
        $payload = @file_get_contents('php://input');
        $signature = $request->header('Stripe-Signature');

        $this->orderService->updateOrdersViaWebhook($payload, $signature, $endPoint);
    }
}
