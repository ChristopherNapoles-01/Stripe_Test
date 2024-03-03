<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Orders\OrdersService;
use App\Http\Services\Stripe\StripeService;
use App\Http\Services\Stripe\StripeSessionService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewsController extends Controller
{

    public function __construct(
        private StripeService $stripeService,
        private StripeSessionService $stripeSessionService,
        private OrdersService $orderService
    ){}

    public function success(Request $request)
    {
        try{
            $sessionId = $request->get('session_id') ?? '';
            if (!$sessionId) {
                throw new NotFoundHttpException;
            }

            $session = $this->stripeService->getSession($sessionId);
        
            if (!$session) {
                throw new NotFoundHttpException;
            }

            // $customer = $this->stripeService->getCustomerData($session);

            $customer = $session->customer_details;

            return view('stripe.index', [
                'customer' => $customer
            ]);
        }
        catch(\Exception $e) {
            return responseOne([
                'error_message' => 'Not Found',
                'error_code' => 404
            ]);
        }        
    }

    public function cancelled(Request $request)
    {
        
    }
}
