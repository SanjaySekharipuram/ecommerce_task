<?php

namespace App\Http\Controllers;

use App\Http\Product\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function productIndex()
    {
        return view('product.index');
    }

    public function getProducts()
    {
        return $this->service->getProducts();
    }
    public function getProduct($id)
    {
        return $this->service->getProduct($id);
        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'price' =>  'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            
            return response()->json([
                'success' => false,
                'errorMessage' => $error,
            ]);
        }


        Product::updateOrCreate(
            ['id' => $request->product_id],
            [
                'name' => $request->name,
                'price' => $request->price
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function delete($id)
    {
        return $this->service->delete($id);

    }
}
