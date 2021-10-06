<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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
        // Meaning products of this place have categories returned here

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

    public function create(CreateCategoryRequest $request): void
    {
        $validatedData = $request->validated();

        auth()->user()
            ->ownerCafes
            ->categories()
            ->create([
                'name' => $validatedData['category'],
            ]);
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category->update([
            'name' => $validatedData['category'],
        ]);
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }
}
