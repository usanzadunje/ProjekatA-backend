<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Staff\CreateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use Illuminate\Http\JsonResponse;

class OwnerController extends Controller
{
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
