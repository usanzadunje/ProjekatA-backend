<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Cafe;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Psy\Util\Json;

class CategoryController extends Controller
{
    public function index(Cafe $place = null): ResourceCollection
    {
        //$place->allProductCategories();
        // Request for specific place and its categories that are used on products
        // Meaning products of this pace have categories returned here

        //auth()->user()->ownerCafes->allAvailableCategories;
        // Request for all available categories which may not be used on any product

        $categories = $place
            ? $place->allProductCategories()
            : auth()->user()->ownerCafes->allAvailableCategories();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function create(CreateCategoryRequest $request)
    {
        $validatedData = $request->validated();

        auth()->user()->ownerCafes->categories()->create([
            'name' => $validatedData['category'],
        ]);

        return auth()->user()->ownerCafes->categories;
    }

    public function update(): ResourceCollection
    {

    }

    public function delete(Category $category): ResourceCollection
    {

    }
}
