<?php

namespace App\Http\Product\Repositories;

use App\Models\Product;

class ProductRepository 
{
    public function getProducts()
    {
        return Product::all();
    }

    public function getProduct($id)
    {
        return Product::findOrFail($id);
    }
}
