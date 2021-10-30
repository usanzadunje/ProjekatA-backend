<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Place;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    public function index(): ResourceCollection
    {
        /* If needed place can be injected and based on which place gather categories
            only if there is functionality that lists only categories for certain place
        */
        $categories = auth()->user()->ownerPlaces->allAvailableCategories();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function create(StoreCategoryRequest $request): CategoryResource
    {
        $validatedData = $request->validated();

        $createdCategory = auth()->user()
            ->ownerPlaces
            ->categories()
            ->create($validatedData);

        return new CategoryResource($createdCategory);
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category->update($validatedData);
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }
}
