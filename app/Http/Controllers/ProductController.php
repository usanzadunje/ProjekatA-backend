<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function index($placeId = null): ResourceCollection
    {
        $providedPlaceId = $placeId ?: auth()->user()->isOwner();

        return ProductResource::collection(
            Product::select('id', 'name', 'description', 'price', 'cafe_id')
                ->where('cafe_id', $providedPlaceId)
                ->get()
        );
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function create(): ResourceCollection
    {

    }

    public function update(): ResourceCollection
    {

    }

    public function delete(): ResourceCollection
    {

    }
}
