<?php

namespace App\Http\Services\Products;

use App\Http\Repositories\Products\ProductsRepository;

class ProductsService
{
    public function __construct(
        protected ProductsRepository $productsRepository
    ){}
    public function listAllProducts()
    {
        return $this->productsRepository->listAllProducts();
    }
}