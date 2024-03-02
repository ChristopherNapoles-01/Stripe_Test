<?php

namespace App\Http\Repositories\Stripe;

use Illuminate\Support\Facades\DB;

class StripeSessionRepository
{
    protected $table = 'stripe_session';

    public function __construct()
    {

    }

    public function buildQuery()
    {
        return DB::table($this->table);
    }

    public function saveStripeSession(array $sessionInfo)
    {
        return $this->buildQuery()
            ->insert($sessionInfo);
    }

    public function updateStripeSession(array $attributes, array $data)
    {
        return $this->buildQuery()
            ->where($attributes)
            ->update($data);
    }
}