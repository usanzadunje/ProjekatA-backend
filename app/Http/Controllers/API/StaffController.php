<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Staff\CreateStaffMember;
use App\Actions\Owner\Staff\UpdateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use App\Http\Requests\ToggleActivityStaffRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StaffController extends Controller
{
    public function index(): ResourceCollection
    {
        return UserResource::collection(auth()->user()->staff());
    }

    public function store(CreateStaffMemberRequest $request, CreateStaffMember $createStaffMember): void
    {
        $createStaffMember->handle($request->validated());
    }

    public function update(User $staff, UpdateStaffMemberRequest $request, UpdateStaffMember $updateStaffMember): void
    {
        $updateStaffMember->handle($staff, $request->validated());
    }

    public function destroy(User $staff): void
    {
        $staff->delete();
    }

    public function toggle(ToggleActivityStaffRequest $request): void
    {
        $validatedData = $request->validated();

        auth()->user()->update([
            'active' => $validatedData['active'],
        ]);
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
