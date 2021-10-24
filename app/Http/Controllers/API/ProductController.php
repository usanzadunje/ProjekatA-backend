<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Products\RemoveAllProductImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ProductResource;
use App\Models\Place;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function index(Place $place = null, $categoryId = null): ResourceCollection
    {
        $productsQuery = $place
            ? $place->products()->where('category_id', $categoryId)
            : auth()->user()->ownerPlaces->products();

        $products = $productsQuery
            ->with(['images' => function($query) {
                $query->select('id', 'path', 'is_main', 'imagable_id')
                    ->where('is_main', true);
            }])
            ->orderByDesc('id')
            ->filterAndChunk('name', request('filter'), request('offset'), request('limit'))
            ->get();

        return ProductResource::collection($products);
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product->load('category', 'images'));
    }

    public function create(StoreProductRequest $request): ProductResource
    {
        $validatedData = $request->validated();

        //add logic for storing image

        $createdProduct = auth()->user()
            ->ownerPlaces
            ->products()
            ->create($validatedData);

        return new ProductResource($createdProduct);
    }

    public function update(Product $product, UpdateProductRequest $request): void
    {
        $validatedData = $request->validated();

        $product->update($validatedData);
    }

    public function destroy(Product $product, RemoveAllProductImages $removeAllProductImages): void
    {
        $removeAllProductImages->handle($product);

        $product->delete();
    }

    public function images(Product $product): ResourceCollection
    {
        return ImageResource::collection($product->images()->select('id', 'path', 'is_main')->get());
    }
}
