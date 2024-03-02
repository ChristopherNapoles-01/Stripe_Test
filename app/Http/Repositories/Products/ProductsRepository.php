<?php


namespace App\Http\Repositories\Products;

use Illuminate\Support\Facades\DB;

class ProductsRepository
{
    public function buildQuery() 
    {
        return DB::table('products');
    }
    public function listAllProducts() : array
    {
        return $this->buildQuery()->get()->all();
    }
}