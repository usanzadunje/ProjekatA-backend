<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ProductResource;
use App\Models\Cafe;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function index(Cafe $place = null): ResourceCollection
    {
        $products = $place
            ? $place->products()
            : auth()->user()->ownerCafes->products();

        return ProductResource::collection(
            $products->with(['images' => function($query) {
                $query->select('id', 'path', 'is_main', 'imagable_id')
                    ->where('is_main', true);
            }])->get()
        );
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product->load('category', 'images'));
    }

    public function create(CreateProductRequest $request): void
    {
        $validatedData = $request->validated();

        //add logic for storing image

        auth()->user()
            ->ownerCafes
            ->products()
            ->create($validatedData);
    }

    public function update(Product $product, UpdateProductRequest $request): void
    {
        $validatedData = $request->validated();

        $product->update($validatedData);
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }

    public function images(Product $product): ResourceCollection
    {
        return ImageResource::collection($product->images()->select('id', 'path', 'is_main')->get());
    }
}
