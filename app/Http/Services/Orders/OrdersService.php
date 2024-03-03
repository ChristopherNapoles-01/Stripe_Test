<?php

namespace App\Http\Services\Orders;

use App\Http\Services\Stripe\WebhookService;
use App\Http\Repositories\Orders\OrdersRepository;
use App\Http\Services\Stripe\StripeSessionService;

class OrdersService
{
    public function __construct(
         private OrdersRepository $ordersRepository,
         private WebhookService $webhookService,
         private StripeSessionService $stripeSessionService,
    ){}
    public function saveOrders(array $orderData)
    {
        return $this->ordersRepository->saveOrders($orderData);
    }

    public function updateOrdersBySessionId(string $sessionId)
    {
        return $this->ordersRepository->updateOrder(
            [
                'session_id' => $sessionId
            ],
            [
                'status' => 'paid',
            ]
        );
    }

    public function updateOrdersViaWebhook(string $payload, string $signature, string $endpoint)
    {
        try {
            $event = $this->webhookService->constructEvent($payload, $signature, $endpoint);

            $callback = function () use ($event){
                logger()->info($event->data);
                $paymentStatus = $event->data->object->payment_status;
                if ($paymentStatus === 'paid') {
                    $this->stripeSessionService->updateSessionBySessionId($event->data->object->id);
                    $this->updateOrdersBySessionId($event->data->object->id);
                }

            };

            if ($event) {
                match ($event->type) {
                    'checkout.session.completed' => $isPaymentSuccessful = $callback(),
                    default => ''
                };
               
            }

        }
        catch(\Exception $e) {
            logger()->info(json_encode($e));
        }
        
    }
}