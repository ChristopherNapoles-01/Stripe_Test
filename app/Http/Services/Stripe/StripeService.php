<?php

namespace App\Http\Services\Stripe;

use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use App\Http\Services\Orders\OrdersService;
use App\Http\Services\Products\ProductsService;
use App\Http\Repositories\Stripe\StripeRepository;
use App\Http\Repositories\Stripe\StripeSessionRepository;

class StripeService
{

    public function __construct(
        private ProductsService $productsService,
        private StripeRepository $stripeRepository,
        private StripeSessionRepository $stripeSessionRepository,
        private OrdersService $ordersService
    ){}
    
    public function handleCheckout()
    {
        $products = $this->productsService->listAllProducts();
        $lineItems = [];
        $productIds = [];
        $totalPrice = 0;

        foreach ($products as $product) {
            $lineItems[] =  [
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => $product->name,
                  ],
                  'unit_amount' => $product->price * 100,
                ],
                'quantity' => 1,
            ];

            $productIds[] = $product->product_id;
            $totalPrice += $product->price;
        }

        $stripeSession = $this->stripeRepository->checkout($lineItems);

        $orderData = [
            'order_id' => Str::uuid(),
            'session_id' => $stripeSession->id,
            'product_ids' => json_encode($productIds),
            'user_id' => Str::uuid(),
            'status' => 'unpaid',
            'total_price' => $totalPrice,

        ];

        $this->ordersService->saveOrders($orderData);
    
        $sessionInfo = [
            'session_id' => $stripeSession->id,
            'session_status' => 'unpaid',
        ];

        $this->stripeSessionRepository->saveStripeSession($sessionInfo);

        return $stripeSession->url;
    }

    public function getSession(string $sessionId) : Session
    {
        return $this->stripeRepository->getSession($sessionId);
    }
    

    public function getCustomerData(Session $session)
    {
        return $this->stripeRepository->getCustomerData($session);
    }
}