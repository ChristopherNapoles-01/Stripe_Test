<?php

namespace App\Http\Services\Orders;

use App\Http\Repositories\Orders\OrdersRepository;

class OrdersService
{
    public function __construct(
         private OrdersRepository $ordersRepository,
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
}