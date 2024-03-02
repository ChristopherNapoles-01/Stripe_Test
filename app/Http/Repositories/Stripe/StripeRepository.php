<?php

namespace App\Http\Repositories\Stripe;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;

class StripeRepository
{
    private Stripe $stripe;

    private Session $stripeSession;

    private Customer $customer;


    public function __construct()
    {
        $this->setStripe();
    }

    public function setStripe() : void
    {
        $this->stripe = new Stripe;
        $this->stripeSession = new Session;
        $this->customer = new Customer;
        $this->stripe->setApiKey(config('stripe.stripeKey'));
    }

    public function checkout(array $lineItems) : Session
    {
        return $this->setSession($lineItems);
    }

    public function cancel()
    {
        
    }


    public function getSession(string $sessionId) : Session
    {
        return $this->stripeSession->retrieve($sessionId);
    }

    public function getCustomerData(Session $session) : Customer
    {
        return $this->customer->retrieve($session->id);
    }

    private function setSession(array $lineItems) : Session
    {
        $session = $this->stripeSession->create([
            'line_items' => $lineItems,
              'mode' => 'payment',
              'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
              'cancel_url' => 'http://localhost:4242/cancel.html',
        ]);

        return $session;
    }
}