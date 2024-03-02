<?php

namespace App\Http\Repositories\Orders;

use Illuminate\Support\Facades\DB;

class OrdersRepository
{

    public function buildQuery()
    {
        return DB::table('orders');
    }

    public function saveOrders(array $orderData)
    {
        return $this->buildQuery()->insert($orderData);
    }

    public function updateOrder(array $attributes, array $data)
    {
        return $this->buildQuery()
            ->where($attributes)
            ->update($data);
    }
}