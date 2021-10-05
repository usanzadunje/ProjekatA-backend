<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    public function index($placeId = null): ResourceCollection
    {
        $providedPlaceId = $placeId ?: auth()->user()->isOwner();

        $products = Product::select('id')
            ->where('cafe_id', $providedPlaceId)
            ->get();

        return CategoryResource::collection($products->categories);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function create(): ResourceCollection
    {

    }

    public function update(): ResourceCollection
    {

    }

    public function delete(Category $category): ResourceCollection
    {

    }
}
