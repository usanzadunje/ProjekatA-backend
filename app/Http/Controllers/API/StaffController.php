<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Staff\CreateStaffMember;
use App\Actions\Owner\Staff\UpdateStaffMember;
use App\Actions\Place\Table\ToggleTableAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use App\Http\Requests\ToggleActivityStaffRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Http\Resources\UserResource;
use App\Models\Cafe;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class StaffController extends Controller
{
    public function index(): ResourceCollection
    {
        return UserResource::collection(auth()->user()->staff());
    }

    public function store(CreateStaffMemberRequest $request, CreateStaffMember $createStaffMember): JsonResponse
    {
        $createStaffMember->handle($request->validated());

        return response()->success('Successfully created staff member.');
    }

    public function update(User $staff, UpdateStaffMemberRequest $request, UpdateStaffMember $updateStaffMember): JsonResponse
    {
        $updateStaffMember->handle($staff, $request->validated());

        return response()->success('Successfully updated staff member.');
    }

    public function destroy(User $staff): JsonResponse
    {
        $staff->delete();

        return response()->success('Successfully deleted staff member.');
    }

    public function toggle(ToggleActivityStaffRequest $request)
    {
        $validatedData = $request->validated();

        auth()->user()->update([
            'active' => $validatedData['active'],
        ]);

        return response()->success('Successfully reported your activity status!');
    }

    //public function inactive(): JsonResponse
    //{
    //    auth()->user()->update([
    //        'active' => false,
    //    ]);
    //
    //    return response()->success('Successfully reported yourself as inactive!');
    //}
}
