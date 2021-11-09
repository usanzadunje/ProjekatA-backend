<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionController extends Controller
{
    public function store(StoreSectionRequest $request): JsonResource
    {
        $validatedData = $request->validated();

        $createdSection = auth()->user()
            ->ownerPlaces
            ->sections()
            ->create($validatedData);

        return new SectionResource($createdSection);
    }

    public function update(Section $section, UpdateSectionRequest $request): void
    {
        $section->update($request->validated());
    }

    public function destroy(Section $section): void
    {
        $section->delete();
    }
}
