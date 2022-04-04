<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::query()->latest();

        if (request()->has('search')) {
            $products->where('title', 'like', '%' . request('search') . '%');
        }

        return ProductResource::collection($products->paginate(10))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = imageUploadHandler($request->file('image'), 'products', '450x450');
        }

        if ($request->has('slug')) {
            $data['slug'] = Str::slug($request->slug);
        } else {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        $product = Product::create($data);

        return success_response(
            'Product created successfully!',
            Response::HTTP_CREATED,
            new ProductResource($product)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return success_response(
            'Product Details!',
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image'] = imageUploadHandler($request->file('image'), 'products', '450x450', $product->image);
        }

        if ($request->has('slug')) {
            $data['slug'] = Str::slug($request->slug);
        }

        $product->update($data);

        return success_response(
            'Product updated successfully!',
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return success_response(
            'Product deleted successfully!',
            Response::HTTP_OK
        );
    }
}
