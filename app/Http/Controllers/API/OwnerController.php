<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Staff\CreateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OwnerController extends Controller
{
    public function listStaff(): ResourceCollection
    {
        return UserResource::collection(auth()->user()->staff());
    }

    public function createStaff(CreateStaffMemberRequest $request, CreateStaffMember $createStaffMember): JsonResponse
    {
        $createStaffMember->handle(auth()->user(), $request->validated());

        return response()->success('Successfully created staff member.');
    }

    public function updatePlace(): JsonResponse
    {
        return response()->success('Successfully updated your place profile.');
    }

    //remove staff
    //update staff


}
