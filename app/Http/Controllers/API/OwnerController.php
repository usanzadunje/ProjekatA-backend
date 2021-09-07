<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Place\UpdatePlaceInfo;
use App\Actions\Owner\Staff\CreateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class OwnerController extends Controller
{
    public function listStaff(): ResourceCollection
    {
        return UserResource::collection(auth()->user()->staff());
    }

    public function createStaff(CreateStaffMemberRequest $request, CreateStaffMember $createStaffMember): JsonResponse
    {
        $createStaffMember->handle($request->validated());

        return response()->success('Successfully created staff member.');
    }

    public function updatePlace(UpdatePlaceRequest $request, UpdatePlaceInfo $updatePlaceInfo): JsonResponse
    {
        try
        {
            $updatePlaceInfo->handle($request->validated());
        }catch(UnauthorizedException $e)
        {
            abort(403, 'Unauthorized.');
        }

        return \response()->success('Successfully updates place information.');
    }

    //remove staff
    //update staff


}
