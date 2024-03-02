<?php

namespace App\Http\Controllers;

use App\Http\Services\Stripe\StripeService;
use Illuminate\Http\Request;

class StripeController extends Controller
{

    public function __construct(
        private StripeService $stripeService
    ){}
    public function store(Request $request)
    {
        return responseOne($this->stripeService->handleCheckout());
    }
}
