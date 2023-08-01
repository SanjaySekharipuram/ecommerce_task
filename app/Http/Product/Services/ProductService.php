<?php

namespace App\Http\Product\Services;

use App\Http\Product\Repositories\ProductRepository;
use Yajra\DataTables\Facades\DataTables;

class ProductService 
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function getProducts()
    {
        $products = $this->repository->getProducts();
        
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getProduct($id)
    {
        if (isset($id)) {
            $product = $this->repository->getProduct($id);
            
            return response()->json([
                'success' => true,
                'data' => $product,
            ]);
        }
        return response()->json([
            'success' => false,
            'errorMsg' => "id is required"
        ]);
    }

    public function delete($id)
    {
        if (isset($id)) {
            $product = $this->repository->getProduct($id);
            $product->delete();

        return response()->json(['success' => 'product deleted successfully.']);
           
        }
        return response()->json([
            'success' => false,
            'errorMsg' => "id is required"
        ]);
    }
}
