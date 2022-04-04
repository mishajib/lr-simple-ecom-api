<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    public function home()
    {
        $products = Product::latest()->take(10)->get();

        return ProductResource::collection($products)->chunk(5, true);
    }

    public function productDetails(Product $product)
    {
        return new ProductResource($product);
    }

    public function searchProducts($search)
    {
        $products = Product::where('title', 'like', '%' . $search . '%')->get();

        return ProductResource::collection($products)->chunk(5, true);
    }
}
